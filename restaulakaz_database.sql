-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 06:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS restaurant_db;
USE restaurant_db;


-- --------------------------------------------------------
-- Table structure for table `user`
-- --------------------------------------------------------

CREATE TABLE `user` (
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `admin`
-- --------------------------------------------------------

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `customer`
-- --------------------------------------------------------

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Phone_Number` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Region_Name` varchar(100) DEFAULT NULL,
  `Street_Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------

CREATE TABLE `orders` (
  `Order_ID` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Total_Amount` decimal(10,2) DEFAULT NULL,
  `Order_Status` varchar(50) DEFAULT NULL,
  `Customer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `restaurant`
-- --------------------------------------------------------

CREATE TABLE `restaurant` (
  `Restaurant_ID` int(11) NOT NULL,
  `Restaurant_Name` varchar(100) DEFAULT NULL,
  `Restaurant_Location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `item`
-- --------------------------------------------------------

CREATE TABLE `item` (
  `Item_ID` int(11) NOT NULL,
  `Item_Name` varchar(100) DEFAULT NULL,
  `Item_Quantity` int(11) DEFAULT NULL,
  `Item_Price` decimal(10,2) DEFAULT NULL,
  `Item_Type` varchar(50) DEFAULT NULL,
  `Item_Image` varchar(255) DEFAULT NULL,
  `Restaurant_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `payment`
-- --------------------------------------------------------

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Payment_Method` varchar(50) DEFAULT NULL,
  `Payment_Time` time DEFAULT NULL,
  `Payment_Date` date DEFAULT NULL,
  `Order_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `review`
-- --------------------------------------------------------

CREATE TABLE `review` (
  `Review_ID` int(11) NOT NULL,
  `Review_Commented` text DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Review_Date` date DEFAULT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Restaurant_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Indexes
-- --------------------------------------------------------

ALTER TABLE `user`
  ADD PRIMARY KEY (`Username`);

ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`),
  ADD KEY `Username` (`Username`);

ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`Restaurant_ID`);

ALTER TABLE `item`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `Restaurant_ID` (`Restaurant_ID`);

ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Order_ID` (`Order_ID`);

ALTER TABLE `review`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Restaurant_ID` (`Restaurant_ID`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `restaurant`
  MODIFY `Restaurant_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `item`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `review`
  MODIFY `Review_ID` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
-- Constraints
-- --------------------------------------------------------

ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `user` (`Username`);

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`);

ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`Restaurant_ID`) REFERENCES `restaurant` (`Restaurant_ID`);

ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `orders` (`Order_ID`);

ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Restaurant_ID`) REFERENCES `restaurant` (`Restaurant_ID`);

COMMIT;

-- --------------------------------------------------------
-- INSERT VALUES
-- --------------------------------------------------------

INSERT INTO `restaurant` (`Restaurant_ID`, `Restaurant_Name`, `Restaurant_Location`) VALUES
(201, 'KFC', 'Mauritius'),
(202, 'Mac', 'Mauritius'),
(203, 'Tilly', 'Mauritius');

INSERT INTO `item` (`Item_ID`, `Item_Name`, `Item_Quantity`, `Item_Price`, `Item_Type`, `Item_Image`, `Restaurant_ID`) VALUES
-- Chinese
(101, 'Chicken Dumpling', 50, 165, 'chinese', 'chinese1.png', 201),
(102, 'Shrimp Fried Rice', 350, 255, 'chinese', 'chinese2.png', 202),
(103, 'Cabbage Spring Rolls', 320, 145, 'chinese', 'chinese3.png', 203),
(104, 'Fried Chicken Bao', 400, 225, 'chinese', 'chinese4.png', 202),
(105, 'Sweet Chilli Chicken', 375, 245, 'chinese', 'chinese5.png', 201),
(106, 'Veg Chow Mein', 120, 230, 'chinese', 'chinese6.png', 203),

-- Seafood
(201, 'Pawn and Mussel', 50, 400, 'seafood', 'sea1.png', 201),
(202, 'Platter for one', 350, 650, 'seafood', 'sea2.png', 202),
(203, 'Fish and Chip', 320, 400, 'seafood', 'sea3.jpeg', 203),
(204, 'Grilled Fish', 400, 300, 'seafood', 'sea4.jpeg', 202),
(205, 'Crab Clusters Soup', 375, 450, 'seafood', 'sea.jpeg', 201),
(206, 'Calamar Frits', 120, 500, 'seafood', 'sea.jpeg', 203),

-- Salads
(301, 'Avocado, Spinach And Arugula Salad', 50, 300, 'salad', 'salad1.jpeg', 201),
(302, 'Avocado Tuna Salad', 350, 300, 'salad', 'salad2.jpeg', 202),
(303, 'Grilled Avocado Salad', 320, 300, 'salad', 'salad3.jpeg', 203),
(304, 'Thai Sweet Potato Salad', 400, 300, 'salad', 'salad4.jpeg', 202),
(305, 'Asian Avocado And Cantaloupe Salad', 375, 300, 'salad', 'salad5.jpeg', 201),
(306, 'Mango Veggie Summer Salad', 120, 300, 'salad', 'salad6.jpeg', 203),

-- Drinks
(401, 'Fuze Tea', 100, 30, 'drink', 'drink1.png', 201),
(402, 'Coca Cola', 100, 30, 'drink', 'drink2.png', 202),
(403, 'Sprite', 100, 30, 'drink', 'drink3.png', 203),
(404, 'Sun Top', 100, 25, 'drink', 'drink4.png', 201),
(405, 'Vital', 100, 25, 'drink', 'drink5.png', 202),
(406, 'Mirinda', 100, 30, 'drink', 'drink6.png', 203),

-- Fast Food
(501, 'Crispy Chicken Bites', 100, 255, 'fast food', 'fast1.png', 201),
(502, 'Smash Burger', 100, 240, 'fast food', 'fast2.png', 202),
(503, 'Tangy Hot Dog', 100, 190, 'fast food', 'fast3.png', 203),
(504, 'Chicken Wrap', 100, 220, 'fast food', 'fast4.png', 201),
(505, 'Loaded Chilli Cheese Fries', 100, 199, 'fast food', 'fast5.png', 202),
(506, 'Onion Rings', 100, 110, 'fast food', 'fast6.png', 203),

-- Italian
(601, 'Margherita', 100, 400, 'italian', 'italian1.png', 201),
(602, 'Spaghetti Bolognese', 100, 350, 'italian', 'italian2.png', 202),
(603, 'Chicken Lasagna', 100, 400, 'italian', 'italian3.png', 203),
(604, 'Carbonara', 100, 400, 'italian', 'italian4.png', 201),
(605, 'Lobster Risotto', 100, 400, 'italian', 'italian5.png', 202),
(606, 'Bruschetta', 100, 120, 'italian', 'italian6.png', 203),

-- Desserts
(701, 'Lemon Tart', 100, 320, 'dessert', 'dessert1.png', 201),
(702, 'Chocolate Cake', 100, 330, 'dessert', 'dessert2.png', 202),
(703, 'Cheesecake', 100, 400, 'dessert', 'dessert3.png', 203),
(704, 'Panna Cotta', 100, 350, 'dessert', 'dessert4.png', 201),
(705, 'French Macaron', 100, 250, 'dessert', 'dessert5.png', 202),
(706, 'Entremets Fraise Coco Verveine', 100, 450, 'dessert', 'dessert6.png', 203);
