DROP DATABASE IF EXISTS smart_wallet;

CREATE DATABASE smart_wallet;

USE smart_wallet;

drop table income;

drop table expense;

drop table categories;

drop table transactions;
drop table user_ips;
drop table otp_codes;
drop table login_logs;
drop table notifications;
drop table users;

 
-- users(#userId , firstname, lastname, email, password, join_date)

CREATE TABLE users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    join_date DATE DEFAULT CURRENT_DATE
);

-- expense(#expenseId, expenseTitle, description, price, categorie , duedate, state , user_id#)
CREATE TABLE expense (
    expenseId INT PRIMARY KEY AUTO_INCREMENT,
    expenseTitle VARCHAR(50) NOT NULL,
    description TEXT,
    user_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    categorie TEXT,
    dueDate DATE,
    state VARCHAR(20) DEFAULT 'not paid',
    CONSTRAINT fk_expense_user FOREIGN KEY (user_id) REFERENCES users (userId)
);

-- income(#incomeId, incomeTitle, description , price, categorie, getIncomeDate, user_id#)
CREATE TABLE income (
    incomeId INT PRIMARY KEY AUTO_INCREMENT,
    incomeTitle VARCHAR(50) NOT NULL,
    description TEXT,
    user_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    categorie TEXT,
    getIncomeDate DATE,
    CONSTRAINT fk_income_user FOREIGN KEY (user_id) REFERENCES users (userId)
);
-- categories(#categoryId, name)
CREATE TABLE categories (
    categoryId INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

--  transactions(#transactionId, title, description, type, amount , transaction_date, state, user_id#, category_id#)
CREATE TABLE transactions (
    transactionId INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT,
    user_id INT NOT NULL,
    category_id INT,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_date DATE NOT NULL,
    state VARCHAR(20) DEFAULT 'not paid',
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories (categoryId)
);
-- user_ips(#id,id_adress, created_at, user_id#)
CREATE TABLE user_ips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- otp_codes(#id, otp_code, expires_at, used, created_at, user_id#)
CREATE TABLE otp_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    expires_at DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- login_logs(#id, ip_adress, status, created_at, user_id#)
CREATE TABLE login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45),
    status ENUM('SUCCESS', 'FAILED', 'OTP_REQUIRED'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- notifications(#id, message, seen , created_at, user_id#)
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    seen TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
