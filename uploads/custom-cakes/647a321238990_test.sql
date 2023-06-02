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
        total DECIMAL(10, 2) NULL,
        PRIMARY KEY (cartID, userID),
        FOREIGN KEY (`userID`) REFERENCES users(`userID`),
        FOREIGN KEY (`CakeID`) REFERENCES cakes(`CakeID`)
    );