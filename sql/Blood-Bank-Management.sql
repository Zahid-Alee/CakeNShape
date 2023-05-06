CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `password` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `blood_requests` (
  `request_id` varchar(100) PRIMARY KEY,
  `hospital_name` varchar(255) NOT NULL,
  `blood_group` varchar(3) NOT NULL,
  `quantity` int(11) NOT NULL,
  `request_date` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `request_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `location` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL
  
);

CREATE TABLE `blood_donation` (
  `donation_id` varchar(100) PRIMARY KEY NOT NULL,
  `donation_date` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_donated_date` date NOT NULL,
  `blood_group` varchar(3) NOT NULL,
  `quantity` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `donor_name` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `email` varchar(255),
  `age` int(11) NOT NULL,
  `request_status` varchar(20) NOT NULL DEFAULT 'Pending'

);
CREATE TABLE `blood_stock` (
  `stock_id` varchar(100) PRIMARY KEY,
  `blood_group` varchar(3) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL
);

