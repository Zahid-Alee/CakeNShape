CREATE TABLE
    `users` (
        `userID` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `role` varchar(10) NOT NULL DEFAULT 'user',
        `password` varchar(200) NOT NULL,
        `email` varchar(255) NOT NULL,
        `address` varchar(255) NOT NULL,
        `phone` varchar(255) NOT NULL,
        `zip` varchar(255) NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE = InnoDB DEFAULT CHARSET = latin1;