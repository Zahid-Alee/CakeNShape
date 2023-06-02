CREATE TABLE
    Order_Items (
        `id` INT PRIMARY KEY AUTO_INCREMENT ,
        `OrderID` INT NUll ,
        `CakeID` VARCHAR(50)  NULL,
        `Quantity` INT NOT NULL,
        `Subtotal` DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (`OrderID`) REFERENCES Orders(`OrderID`),
        FOREIGN KEY (`CakeID`) REFERENCES Cakes(`CakeID`)
    );  