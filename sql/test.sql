CREATE TABLE Sales (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    OrderID INT(11) NOT NULL,
    Quantity INT(11) NOT NULL,
    Subtotal DECIMAL(10, 2) NOT NULL,
    Category VARCHAR(255) NOT NULL
);
