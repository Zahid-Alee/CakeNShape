

CREATE TABLE  Order_Items (
        `OrderID` INT ,
        `CakeID` VARCHAR(50) NOT NULL,
        `Quantity` INT NOT NULL,
        `Subtotal` DECIMAL(10, 2) NOT NULL,
        PRIMARY KEY (`OrderID`, `CakeID`),
        FOREIGN KEY (`OrderID`) REFERENCES Orders(`OrderID`),
        FOREIGN KEY (`CakeID`) REFERENCES Cakes(`CakeID`)
    );