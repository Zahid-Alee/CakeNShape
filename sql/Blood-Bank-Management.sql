CREATE DATABASE cake_shop;

USE cake_shop;

CREATE TABLE `users` (
  `userID` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `password` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Categories (
  `CategoryID` VARCHAR(30) PRIMARY KEY NOT NULL ,
  `CategoryName` VARCHAR(50) NOT NULL
);

CREATE TABLE Cakes (
  `CakeID` VARCHAR(50) PRIMARY KEY NOT NULL ,
  `CakeName` VARCHAR(100) NOT NULL,
  `CategoryID` VARCHAR(30),
  `MaterialUsed` VARCHAR(100) NOT NULL,
  `Flavor` VARCHAR(50) NOT NULL,
  `Weight` INT NOT NULL,
  `Price` DECIMAL(10,2) NOT NULL,
 `Image` LONGBLOB NOT NULL,
  FOREIGN KEY (`CategoryID`) REFERENCES Categories(`CategoryID`)
);

CREATE TABLE Orders (
  `OrderID` VARCHAR(50) PRIMARY KEY NOT NULL,
  `userID` int(11) NOT NULL,
  `OrderDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DeliveryDate` DATETIME NOT NULL,
  `PaymentMethod` VARCHAR(50) NOT NULL,
  `OrderStatus` VARCHAR(50) NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES users(`userID`)
);

CREATE TABLE Order_Items (
  `OrderID` VARCHAR(50) NOT NULL,
  `CakeID` VARCHAR(50) NOT NULL,
  `Quantity` INT NOT NULL,
  `Subtotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`OrderID`, `CakeID`),
  FOREIGN KEY (`OrderID`) REFERENCES Orders(`OrderID`),
  FOREIGN KEY (`CakeID`) REFERENCES Cakes(`CakeID`)
);

CREATE TABLE Feedback (
  `FeedbackID` VARCHAR(50) PRIMARY KEY ,
  `userID` int(11) NOT NULL,
  `FeedbackText` TEXT NOT NULL,
  `FeedbackDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`userID`) REFERENCES users(`userID`)
);

