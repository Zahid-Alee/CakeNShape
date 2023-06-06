CREATE TABLE
    Feedback (
        `FeedbackID` VARCHAR(50) PRIMARY KEY,
        `userID` int(11) NOT NULL,
        `email`varchar(30) NOT NULL,
        `FeedbackText` TEXT NOT NULL,
        `FeedbackDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`userID`) REFERENCES users(`userID`)
    );