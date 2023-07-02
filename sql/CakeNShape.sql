CREATE DATABASE cake_shop;

USE cake_shop;

CREATE TABLE
    `users` (
        `userID` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `role` varchar(10) NOT NULL DEFAULT 'user',
        `password` varchar(200) NOT NULL,
        `email` varchar(255) NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE
    Categories (
        `CategoryID` VARCHAR(30) PRIMARY KEY NOT NULL,
        `CategoryName` VARCHAR(50) NOT NULL,
        `Image` VARCHAR(200) NOT NULL
    );

Create Table
    Cakes (
        `CakeID` VARCHAR(50) PRIMARY KEY NOT NULL,
        `CakeName` VARCHAR(100) NOT NULL,
        `CategoryID` VARCHAR(30),
        `MaterialUsed` VARCHAR(100) NOT NULL,
        `Flavor` VARCHAR(50) NOT NULL,
        `Weight` INT NOT NULL,
        `Quantity` INT NOT NULL DEFAULT 1,
        `Price` DECIMAL(10, 2) NOT NULL,
        `discount` INT(11) NULL DEFAULT 0,
        `Image` VARCHAR(200) NOT NULL
    );

CREATE TABLE
    cart (
        cartID INT(11) AUTO_INCREMENT,
        CakeID varchar(50) NULL,
        `userID` int(11) NOT NULL,
        CakeName VARCHAR(255) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NULL DEFAULT 0,
        discount INT(11) NULL DEFAULT 0,
        description TEXT NULL,
        orderType VARCHAR(20) DEFAULT 'ByShop',
        total DECIMAL(10, 2) NULL,
        Image VARCHAR(100) Null,
        PRIMARY KEY (cartID, userID)
    );

CREATE TABLE
    Orders (
        `OrderID` INT PRIMARY KEY AUTO_INCREMENT,
        `userID` int(11) NULL,
        `OrderDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `DeliveryDate` DATETIME NOT NULL,
        `PaymentMethod` VARCHAR(50) NOT NULL,
        `OrderStatus` VARCHAR(50) NOT NULL DEFAULT 'pending',
        `OrderType` VARCHAR(20) DEFAULT 'ByShop'
    );

CREATE TABLE
    Order_Items (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `OrderID` INT NUll,
        `CakeID` VARCHAR(50) NULL,
        `Quantity` INT NOT NULL,
        `Subtotal` DECIMAL(10, 2) NOT NULL
    );

CREATE TABLE
    custom_orders (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        `userID` int(11) NOT NULL,
        CakeName VARCHAR(255) NULL DEFAULT 'Custom Cake',
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NULL DEFAULT 0,
        discount INT(11) NULL DEFAULT 0,
        description TEXT NOT NULL,
        `OrderDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `OrderStatus` VARCHAR(50) NOT NULL DEFAULT 'pending'
    );

CREATE TABLE
    custom_order_items (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `OrderID` INT NUll,
        `Quantity` INT NOT NULL,
        `Subtotal` DECIMAL(10, 2) NOT NULL,
        Image VARCHAR(100) Null
    );

CREATE TABLE
    Feedback (
        `FeedbackID` VARCHAR(50) PRIMARY KEY,
        `Name` VARCHAR(20) NOT NULL,
        `Email` VARCHAR(40) NOT NULL,
        `FeedbackText` TEXT NOT NULL,
        `FeedbackDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    user_notifications (
        `notID` INT(11) AUTO_INCREMENT,
        `OrderID` INT NULL,
        `userID` INT NOT NULL,
        `notDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `message` VARCHAR(150) NULL,
        `notFrom` VARCHAR(30) NULL,
        PRIMARY KEY(notID, OrderID, userID)
    );

CREATE TABLE
    Sales (
        `SaleID` INT PRIMARY KEY AUTO_INCREMENT,
        `OrderID` INT NULL,
        `CakeID` VARCHAR(50) NULL,
        `Quantity` INT NOT NULL,
        `Subtotal` DECIMAL(10, 2) NOT NULL
    );