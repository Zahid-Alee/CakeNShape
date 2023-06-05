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
        `Image` VARCHAR(200) NOT NULL,
        FOREIGN KEY (`CategoryID`) REFERENCES Categories(`CategoryID`)
    );