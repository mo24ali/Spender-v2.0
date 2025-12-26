<?php

class Transaction
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function create($type, $data)
    {
        $title       = $data['title'];
        $amount      = $data['amount'];
        $description = $data['description'];
        $date        = $data['date'] ?? null;
        $card_id     = $data['card_id'];
        $category_id = $data['category_id'] ?? null;
        $user_id     = $data['user_id'];
        $is_recurring = $data['is_recurring'] ?? false;

        if (!empty($category_id) && $type === "expenses") {
            $limitStmt = $this->conn->prepare("
                SELECT monthly_limit FROM categories
                WHERE categoryId = ? AND user_id = ?
            ");
            $limitStmt->execute([$category_id, $user_id]);
            $res = $limitStmt->fetch(PDO::FETCH_ASSOC);
            $category_limit = $res['limit'] ?? null;

            if ($category_limit) {
                $sumStmt = $this->conn->prepare("
                    SELECT SUM(amount) as total 
                    FROM expense ex 
                    JOIN carte c ON c.idCard = ex.card_id 
                    WHERE c.user_id = ? AND ex.category_id = ?
                ");
                $sumStmt->execute([$user_id, $category_id]);
                $current_month_total = $sumStmt->fetch(PDO::FETCH_ASSOC)['total'];

                if ($current_month_total + $amount > $category_limit) {
                    return [
                        "success" => false,
                        "error" => "Transaction blocked: Category monthly limit exceeded!"
                    ];
                }
            }
        }

        $sql = "INSERT INTO $type (title, amount, description, card_id, category_id" . ($date ? ", date" : "") . ") 
                VALUES (:title, :amount, :description, :card_id, :category_id" . ($date ? ", :date" : "") . ")";

        $stmt = $this->conn->prepare($sql);
        $params = [
            ":title" => $title,
            ":amount" => $amount,
            ":description" => $description,
            ":card_id" => $card_id,
            ":category_id" => $category_id
        ];
        if ($date) $params[":date"] = $date;

        if ($stmt->execute($params)) {
            $lastId = $this->conn->lastInsertId();

            if ($is_recurring) {
                $eventTable = "{$type}_events";
                $foreignKey = ($type === "expenses") ? "expense_id" : "income_id";
                $eventStmt = $this->conn->prepare("INSERT INTO $eventTable ($foreignKey) VALUES (?)");
                $eventStmt->execute([$lastId]);
            }

            return ["success" => true];
        }

        return ["success" => false, "error" => "Database error occurred."];
    }


    
    public function processRecurring()
    {
        $todayDay = date('d');
        $todayDate = date('Y-m-d');

        $query = "SELECT ee.*, e.* FROM expense_events ee
              JOIN expense e ON ee.original_expense_id = e.expenseId
              WHERE ee.day_of_month = ? 
              AND (ee.last_generated IS NULL OR MONTH(ee.last_generated) != MONTH(CURRENT_DATE))";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$todayDay]);
        
        $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($templates as $template) {
            $data = [
                'title'       => $template['title'] . " (Recurring)",
                'amount'      => $template['amount'],
                'description' => $template['description'],
                'date'        => $todayDate,
                'card_id'     => $template['card_id'],
                'category_id' => $template['category_id'],
                'user_id'     => $template['user_id'],
                'is_recurring' => false 
            ];

            if ($this->create('expenses', $data)) {
                $update = $this->conn->prepare("UPDATE expenses_events SET last_generated = ? WHERE event_id = ?");
                $update->execute([$todayDate, $template['event_id']]);
            }
        }
    }
}
