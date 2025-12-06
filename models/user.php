<?php
class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($firstname, $lastname, $email, $password)
    {
        // $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $request = "INSERT INTO users (firstname, lastname, email, password) 
                VALUES ('$firstname', '$lastname', '$email', '$password')";
        return mysqli_query($this->conn, $request);
    }


    public function login($email, $password)
    {
        // Clean the email input
        $email = trim(strtolower($email));

        // Prepare statement to avoid SQL injection
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // If user exists and password matches
        if ($user && password_verify($password, $user['password'])) {
            return $user; // return user data
        }

        return false; // login failed
    }
}
