CREATE TABLE
    user_notifications (
        `notID` INT(11) PRIMARY KEY AUTO_INCREMENT,
        `OrderID` INT NOT NULL,
        `notDate` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `message` VARCHAR(150) NULL,
        `notFor` VARCHAR(30) NULL,
    
        FOREIGN KEY (`OrderID`) REFERENCES orders(`OrderID`)
    );