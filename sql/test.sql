CREATE TABLE user_notifications (
    `notID` INT(11)  AUTO_INCREMENT,
    `OrderID` INT NOT NULL,
    `userID` INT NOT NULL,
    `notDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `message` VARCHAR(150) NULL,
    `notFrom` VARCHAR(30) NULL,
    FOREIGN KEY (`OrderID`) REFERENCES orders(`OrderID`),
    FOREIGN KEY (`userID`) REFERENCES users(`userID`),
    PRIMARY KEY(notID,OrderID,userID)
);
