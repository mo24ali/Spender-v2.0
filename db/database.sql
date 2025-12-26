    DROP DATABASE IF EXISTS spender;

CREATE DATABASE spender;

USE spender;

-- Drop child tables first
DROP TABLE IF EXISTS otp_codes;

DROP TABLE IF EXISTS user_ips;

DROP TABLE IF EXISTS login_logs;

DROP TABLE IF EXISTS notifications;

DROP TABLE IF EXISTS transactions;

DROP TABLE IF EXISTS income;

DROP TABLE IF EXISTS expense;

DROP TABLE IF EXISTS carte;

DROP TABLE IF EXISTS transfert;
-- Drop parent tables last
DROP TABLE IF EXISTS categories;

DROP TABLE IF EXISTS users;

-- users(#userId , firstname, lastname, email, password, join_date)
-- expense(#expenseId, expenseTitle, description, price, categorie , duedate, state , user_id#)
-- income(#incomeId, incomeTitle, description , price, categorie, getIncomeDate, user_id#)
-- categories(#categoryId, name)
--  transactions(#transactionId, title, description, type, amount , transaction_date, state, user_id#, category_id#)
-- user_ips(#id,id_adress, created_at, user_id#)
-- otp_codes(#id, otp_code, expires_at, used, created_at, user_id#)
-- login_logs(#id, ip_adress, status, created_at, user_id#)
-- carte(#idCard, nom, user_id, currentSold,limite, statue, expireDate, num, user_id# )
-- notifications(#id, message, seen , created_at, user_id#)

CREATE TABLE users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    join_date DATE DEFAULT CURRENT_DATE
);

CREATE TABLE expense (
    expenseId INT PRIMARY KEY AUTO_INCREMENT,
    expenseTitle VARCHAR(50) NOT NULL,
    description TEXT,
    user_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    categorie TEXT,
    dueDate DATE,
    isRecurent ENUM('YES', 'NO'),
    state VARCHAR(20) DEFAULT 'not paid',
    CONSTRAINT fk_expense_user FOREIGN KEY (user_id) REFERENCES users (userId)
);

CREATE TABLE income (
    incomeId INT PRIMARY KEY AUTO_INCREMENT,
    incomeTitle VARCHAR(50) NOT NULL,
    description TEXT,
    user_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    categorie TEXT,
    getIncomeDate DATE,
    isRecurent ENUM('YES', 'NO'),
    CONSTRAINT fk_income_user FOREIGN KEY (user_id) REFERENCES users (userId)
);

CREATE TABLE categories (
    categoryId INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE transactions (
    transactionId INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT,
    user_id INT NOT NULL,
    category_id INT,
    type text NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_date DATE NOT NULL,
    state VARCHAR(20) DEFAULT 'not paid',
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories (categoryId)
);

CREATE TABLE user_ips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE
);

CREATE TABLE otp_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    expires_at DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE
);

CREATE TABLE login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45),
    status ENUM(
        'SUCCESS',
        'FAILED',
        'OTP_REQUIRED'
    ),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    seen TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE
);

CREATE TABLE carte (
    idCard INT AUTO_INCREMENT PRIMARY KEY,
    nom TEXT NOT NULL,
    user_id INT NOT NULL,
    currentSold INT NOT NULL DEFAULT 0,
    limite INT NOT NULL DEFAULT 0,
    statue enum('Primary', 'Secondary') NOT NULL,
    expireDate DATE,
    num INT NOT NULL,
    primary_statue_user INT GENERATED ALWAYS AS (
        CASE
            WHEN statue = 'Primary' THEN user_id
            ELSE NULL
        END
    ) STORED,
    UNIQUE KEY uniq_primary_statue_per_user (primary_statue_user),
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE
);

CREATE TABLE transfert (
    transferId INT PRIMARY KEY AUTO_INCREMENT,
    idSender INT NOT NULL,
    idReceiver INT NOT NULL,
    amount INT NOT NULL,
    daySent DATETIME DEFAULT CURRENT_TIMESTAMP
);
 -- modifying the categories table
ALTER TABLE categories
ADD monthly_limit DECIMAL(10, 2) NOT NULL DEFAULT 0;
ALTER TABLE categories
ADD COLUMN user_id INT NOT NULL,
ADD CONSTRAINT fk_categories_user
FOREIGN KEY (user_id) REFERENCES users(userId) ON DELETE CASCADE;

CREATE TABLE expense_events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    original_expense_id INT NOT NULL,
    last_generated INT NOT NULL,
    day_of_month DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE expense 
ADD COLUMN card_id INT,
ADD CONSTRAINT fk_expense_card 
FOREIGN KEY (card_id) REFERENCES carte(idCard) ON DELETE SET NULL;