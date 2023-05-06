CREATE TABLE `blood_stock` (
  `stock_id` varchar(100) PRIMARY KEY,
  `blood_group` varchar(3) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL
);