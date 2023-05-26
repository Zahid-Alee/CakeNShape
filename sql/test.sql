CREATE TABLE
    Feedback (
        `FeedbackID` INT PRIMARY KEY AUTO_INCREMENT,
        `userID` int(11) NOT NULL,
        `FeedbackText` TEXT NOT NULL,
        `FeedbackDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`userID`) REFERENCES users(`userID`)
    );
