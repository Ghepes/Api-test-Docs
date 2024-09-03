-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2021 at 01:59 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `AddressId` int(11) NOT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `AptNumber` varchar(50) DEFAULT NULL,
  `HouseNumber` varchar(50) DEFAULT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `ZipCode` varchar(50) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `StateName` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `Contact` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`AddressId`, `CustomerId`, `AptNumber`, `HouseNumber`, `Street`, `ZipCode`, `City`, `StateName`, `Country`, `Contact`) VALUES
(1, 1, '2', 'A', 'Mystic Ave', '02130', 'Boston', 'MA', 'USA', '4578985623'),
(2, 5, '5', 'B', 'Smith Street', '05614', 'Ney York City', 'NY', 'USA', '7458965874'),
(3, 2, '2', '3', 'Johnson Ave', '02135', 'Virginia', 'VI', 'USA', '7548965865'),
(4, 6, '3', 'A', 'Tremont Street', '75486', 'Seattle', 'WA', 'USA', '8547625698'),
(5, 3, '5', '1', 'Parker Ave', '02478', 'Atlanta', 'GE', 'USA', '1245785478'),
(6, 4, '1', '3', 'Highlands Street', '41253', 'Boston', 'MA', 'USA', '2536987458'),
(7, 8, '2', 'B', 'Brooks Ave', '02153', 'Florida', 'FL', 'USA', '7548658965'),
(8, 7, '3', 'A', 'Harvard Street', '04258', 'Boston', 'MA', 'USA', '2586589654'),
(9, 9, '2', 'B', 'Johnson Ave', '03521', 'Boston', 'MA', 'USA', '7589621587'),
(10, 10, '2', '2', 'Midland Ave', '01425', 'Newyork', 'NY', 'USA', '8659745896');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartId` int(11) NOT NULL,
  `DateCreated` date DEFAULT NULL,
  `CustomerId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartId`, `DateCreated`, `CustomerId`) VALUES
(1, '0000-00-00', 1),
(2, '0000-00-00', 1),
(3, '0000-00-00', 1),
(4, '0000-00-00', 5),
(5, '0000-00-00', 2),
(6, '0000-00-00', 6),
(7, '0000-00-00', 3),
(8, '0000-00-00', 4),
(9, '0000-00-00', 8),
(10, '0000-00-00', 7),
(11, '0000-00-00', 9),
(12, '0000-00-00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `cartdetail`
--

CREATE TABLE `cartdetail` (
  `CartId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cartdetail`
--

INSERT INTO `cartdetail` (`CartId`, `ProductId`) VALUES
(1, 45),
(1, 50),
(1, 52),
(2, 51),
(3, 47),
(3, 48),
(3, 49),
(3, 50),
(4, 46),
(5, 48),
(5, 49),
(6, 48),
(7, 51),
(8, 52),
(9, 50),
(10, 46),
(11, 48),
(12, 49);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerId` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Phone` bigint(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Password` varchar(250) NOT NULL DEFAULT 'TEST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerId`, `FirstName`, `LastName`, `Phone`, `Email`, `DateOfBirth`, `Password`) VALUES
(1, 'Jennifer', 'Johnson', 4578985623, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(2, 'Natalie', 'Robinson', 7548965865, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(3, 'John', 'Ferguson', 1245785478, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(4, 'Samuel', 'Patterson', 2536987458, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(5, 'Jasmine', 'James', 7458965874, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(6, 'Patricia', 'Hamilton', 8547625698, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(7, 'Michael', 'Hensley', 2586589654, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(8, 'Elijah', 'Fisher', 7548658965, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(9, 'Justin', 'Wright', 7589621587, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(10, 'Paula', 'Reyes', 8659745896, NULL, '0000-00-00', '033bd94b1168d7e4f0d644c3c95e35bf'),
(11, 'Nishant', 'Verma', 999999999, 'test@email.com', '2000-12-20', 'cc03e747a6afbbcbf8be7668acfebee5');

-- --------------------------------------------------------

--
-- Table structure for table `deliverypartner`
--

CREATE TABLE `deliverypartner` (
  `DeliveryPartnerId` int(11) NOT NULL,
  `AptNumber` varchar(5) DEFAULT NULL,
  `HouseNumber` varchar(5) DEFAULT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `Zipcode` varchar(5) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `StateName` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `Contact` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deliverypartner`
--

INSERT INTO `deliverypartner` (`DeliveryPartnerId`, `AptNumber`, `HouseNumber`, `Street`, `Zipcode`, `City`, `StateName`, `Country`, `Contact`) VALUES
(1, '21', 'A', 'Mystic Ave', '02130', 'Boston', 'MA', 'USA', '7458622214'),
(2, '5', 'B', 'Smith Street', '05614', 'Ney York City', 'NY', 'USA', '7563214455'),
(3, '23', '3', 'Johnson Ave', '02135', 'Virginia', 'VI', 'USA', '7755214455'),
(4, '31', 'A', 'Tremont Street', '75486', 'Seattle', 'WA', 'USA', '9875566214'),
(5, '5', '1', 'Parker Ave', '02478', 'Atlanta', 'GE', 'USA', '8875448862'),
(6, '14', '3', 'Highlands Street', '41253', 'Boston', 'MA', 'USA', '745862144'),
(7, '23', 'B', 'Brooks Ave', '02153', 'Florida', 'FL', 'USA', '7754112248'),
(8, '3', 'A', 'Harvard Street', '04258', 'Boston', 'MA', 'USA', '7548221144'),
(9, '23', 'B', 'Johnson Ave', '03521', 'Boston', 'MA', 'USA', '8975462142'),
(10, '21', '2', 'Midland Ave', '01425', 'Newyork', 'NY', 'USA', '8955447541');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `ProductName` varchar(50) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitCost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderId` int(11) NOT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `PaymentId` int(11) NOT NULL,
  `DateCreated` date DEFAULT NULL,
  `DateShipped` date NOT NULL,
  `ShippingId` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentId` int(11) NOT NULL,
  `PaymentType` varchar(50) NOT NULL,
  `PaymentTotal` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `CVV` int(11) NOT NULL,
  `CardNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductCategoryID` int(11) DEFAULT NULL,
  `ProductSubCategoryID` int(11) DEFAULT NULL,
  `ProductName` varchar(50) NOT NULL,
  `Price` int(11) NOT NULL,
  `Manufacturer` varchar(50) NOT NULL,
  `ProductDimension` varchar(50) NOT NULL,
  `ProductWeight` decimal(10,0) NOT NULL,
  `SellerID` int(11) DEFAULT NULL,
  `SellerName` varchar(50) NOT NULL,
  `Rating` varchar(50) NOT NULL,
  `DateOfManufacture` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductCategoryID`, `ProductSubCategoryID`, `ProductName`, `Price`, `Manufacturer`, `ProductDimension`, `ProductWeight`, `SellerID`, `SellerName`, `Rating`, `DateOfManufacture`) VALUES
(1, 1, 1, 'Basketball Adult Size', 100, 'JD Sports', '11*10*9', '900', 1, 'Amazon', '0', '0000-00-00'),
(2, 2, 3, 'Apple iphone 7', 1000, 'Apple', '5*4*6', '140', 2, 'BestBuy', '0', '0000-00-00'),
(3, 3, 10, 'Queen Bedframe', 500, 'Wayfair', '11*10*9', '1000', 3, 'Target', '0', '0000-00-00'),
(4, 4, 8, 'Becoming by Michelle Obama', 50, 'Penguin', '3*4*5', '10', 1, 'Amazon', '0', '0000-00-00'),
(5, 2, 3, 'Samsung Galaxy S15', 1000, 'Samsung', '5*4*6', '140', 2, 'BestBuy', '0', '0000-00-00'),
(6, 5, 5, 'Adidas Running Shoes', 100, 'Adidas', '8*9*10', '100', 3, 'Target', '0', '0000-00-00'),
(7, 6, 7, 'Nike Fleece Jacket', 200, 'Nike', '11*10*9', '200', 4, 'Nike', '0', '0000-00-00'),
(8, 1, 2, 'Adidas Shoe', 30, 'Adidas', '14*15*16', '10', 5, 'Adidas', '0', '0000-00-00'),
(9, 4, 9, 'The Alchemist by Paulo Coelho', 100, 'Penguin', '3*4*5', '10', 1, 'Amazon', '0', '0000-00-00'),
(10, 5, 6, 'Nike Hiking Shoes', 150, 'Nike', '8*9*10', '100', 3, 'Target', '0', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `ProductCategoryID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`ProductCategoryID`, `Name`) VALUES
(1, 'Sports'),
(2, 'Electronics'),
(3, 'Furniture'),
(4, 'Books'),
(5, 'Shoes'),
(6, 'Apparel'),
(7, 'Healthcare'),
(8, 'Accessories'),
(9, 'Cooking'),
(10, 'Network Components');

-- --------------------------------------------------------

--
-- Table structure for table `productsubcategory`
--

CREATE TABLE `productsubcategory` (
  `ProductSubCategoryID` int(11) NOT NULL,
  `ProductCategoryID` int(11) DEFAULT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productsubcategory`
--

INSERT INTO `productsubcategory` (`ProductSubCategoryID`, `ProductCategoryID`, `Name`) VALUES
(1, 1, 'Basketball'),
(2, 1, 'Football'),
(3, 2, 'Mobile'),
(4, 2, 'Laptops'),
(5, 5, 'Sneakers'),
(6, 5, 'Boots'),
(7, 6, 'Jackets'),
(8, 4, 'Biography'),
(9, 4, 'Fiction'),
(10, 3, 'Bedroom');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `ReturnId` int(11) NOT NULL,
  `CustomerId` int(11) NOT NULL,
  `DeliveryPartnerId` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `ReturnDate` date NOT NULL,
  `Description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewId` int(11) NOT NULL,
  `Rating` varchar(50) DEFAULT NULL,
  `Comments` varchar(50) DEFAULT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`ReviewId`, `Rating`, `Comments`, `CustomerId`, `ProductId`) VALUES
(1, '1', 'Not good', 1, 45),
(2, '2', 'Not the best value for the price', 5, 46),
(3, '4', 'Best one out in the market', 5, 48),
(4, '5', 'This is a great buy if you are on budget', 8, 48),
(5, '4', 'This product does the work', 10, 51),
(6, '3', 'Not great not terrible', 2, 48),
(7, '5', 'One of the best products I bought', 5, 45),
(8, '2', 'Worst', 9, 46),
(9, '5', 'Product of the year', 1, 48),
(10, '1', 'This is an imitation product', 2, 45);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `SellerID` int(11) NOT NULL,
  `SellerName` varchar(50) NOT NULL,
  `AptNumber` varchar(5) NOT NULL,
  `HouseNumber` varchar(5) NOT NULL,
  `Street` varchar(50) NOT NULL,
  `City` varchar(20) NOT NULL,
  `StateName` varchar(50) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Zipcode` varchar(6) NOT NULL,
  `Contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`SellerID`, `SellerName`, `AptNumber`, `HouseNumber`, `Street`, `City`, `StateName`, `Country`, `Zipcode`, `Contact`) VALUES
(1, 'Amazon', '3D', '115', 'Northampton', 'Boston', 'Massachusetts', 'USA', '02119', '6126780987'),
(2, 'BestBuy', '1A', '100', 'Washington', 'San Fransisco', 'Massachusetts', 'USA', '019203', '4567890987'),
(3, 'Target', '2B', '120', 'Newport', 'Los Angeles', 'Massachusetts', 'USA', '076576', '6176058923'),
(4, 'Nike', '3C', '134', 'Dudley', 'Boston', 'Massachusetts', 'USA', '02118', '3214567890'),
(5, 'Adidas', '4E', '178', 'Clinton', 'Seattle', 'Massachusetts', 'USA', '456789', '8907654321'),
(6, 'Flipkart', '5F', '345', 'Willow Ave', 'Portland', 'Massachusetts', 'USA', '034567', '5647890321'),
(7, 'Myntra', '6G', '789', 'Hoboken Ave', 'Jersey City', 'Massachusetts', 'USA', '067890', '4321567890'),
(8, 'Under Armour', '7F', '356', 'Palisade', 'Chicago', 'Massachusetts', 'USA', '054456', '7823451698'),
(9, '5th Avenue', '8I', '234', 'Warwick', 'New york', 'Massachusetts', 'USA', '034234', '3114567890'),
(10, 'Crossword', '9J', '111', 'Hammond', 'Boston', 'Massachusetts', 'USA', '02120', '6176061633');

-- --------------------------------------------------------

--
-- Table structure for table `shippinginfo`
--

CREATE TABLE `shippinginfo` (
  `ShippingId` int(11) NOT NULL,
  `DeliveryPartnerId` int(11) DEFAULT NULL,
  `ShippingCost` decimal(10,2) DEFAULT NULL,
  `ShippingType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shippinginfo`
--

INSERT INTO `shippinginfo` (`ShippingId`, `DeliveryPartnerId`, `ShippingCost`, `ShippingType`) VALUES
(1, 1, '45.20', 'AIR'),
(2, 1, '52.45', 'ROAD'),
(3, 1, '50.74', 'PALLET'),
(4, 2, '51.85', 'EXPEDITED'),
(5, 3, '47.12', 'EXPEDITED'),
(6, 3, '48.42', 'NOT PRIORITY'),
(7, 3, '49.00', 'AIR'),
(8, 3, '50.41', 'PALLET'),
(9, 4, '46.42', 'PRIORITY'),
(10, 5, '48.75', 'AIR'),
(11, 5, '49.42', 'ROAD'),
(12, 6, '48.85', 'NOT PRIORITY'),
(13, 7, '51.23', 'AIR'),
(14, 8, '52.86', 'ROAD'),
(15, 9, '50.25', 'PALLET'),
(16, 10, '46.42', 'EXPEDITED');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `WarehouseId` int(11) NOT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `Zipcode` int(11) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `StateName` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `Contact` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`WarehouseId`, `Street`, `Zipcode`, `City`, `StateName`, `Country`, `Contact`) VALUES
(1, 'Main Street', 25325, 'Boston', NULL, 'USA', '7452365898'),
(2, 'I-901', 45215, 'New York City', NULL, 'USA', '7755412586'),
(3, 'I-94', 47856, 'Virginia', NULL, 'USA', '5632558874'),
(4, 'I-32', 23658, 'Ohio', NULL, 'USA', '7584225586'),
(5, 'Boston Turnpike', 74123, 'Maryland', NULL, 'USA', '9985745586'),
(6, 'I-53', 75321, 'Maine', NULL, 'USA', '4258652147');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressId`),
  ADD KEY `FK_Address_Customer` (`CustomerId`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartId`),
  ADD KEY `FK_Cart_Customer` (`CustomerId`);

--
-- Indexes for table `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD PRIMARY KEY (`CartId`,`ProductId`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerId`);

--
-- Indexes for table `deliverypartner`
--
ALTER TABLE `deliverypartner`
  ADD PRIMARY KEY (`DeliveryPartnerId`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderId`,`ProductId`),
  ADD KEY `FK_OrderDetails_Product` (`ProductId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderId`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `FK_Product_Category` (`ProductCategoryID`),
  ADD KEY `FK_Product_SubCategory` (`ProductSubCategoryID`),
  ADD KEY `FK_Product_Seller` (`SellerID`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`ProductCategoryID`);

--
-- Indexes for table `productsubcategory`
--
ALTER TABLE `productsubcategory`
  ADD PRIMARY KEY (`ProductSubCategoryID`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`ReturnId`),
  ADD KEY `FK_Return_Customer` (`CustomerId`),
  ADD KEY `FK_Return_Delivery` (`DeliveryPartnerId`),
  ADD KEY `FK_Return_Product` (`ProductId`),
  ADD KEY `FK_Order_Return` (`OrderId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewId`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`SellerID`);

--
-- Indexes for table `shippinginfo`
--
ALTER TABLE `shippinginfo`
  ADD PRIMARY KEY (`ShippingId`),
  ADD KEY `FK_Shopping_Delivery` (`DeliveryPartnerId`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`WarehouseId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `AddressId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cartdetail`
--
ALTER TABLE `cartdetail`
  MODIFY `CartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `deliverypartner`
--
ALTER TABLE `deliverypartner`
  MODIFY `DeliveryPartnerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `productcategory`
--
ALTER TABLE `productcategory`
  MODIFY `ProductCategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `productsubcategory`
--
ALTER TABLE `productsubcategory`
  MODIFY `ProductSubCategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `ReturnId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `SellerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shippinginfo`
--
ALTER TABLE `shippinginfo`
  MODIFY `ShippingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `WarehouseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_Address_Customer` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_Cart_Customer` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`);

--
-- Constraints for table `cartdetail`
--
ALTER TABLE `cartdetail`
  ADD CONSTRAINT `FK_CART_DETAILS` FOREIGN KEY (`CartId`) REFERENCES `cart` (`CartId`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `FK_OrderDetails_Product` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Order_ID` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_Product_Category` FOREIGN KEY (`ProductCategoryID`) REFERENCES `productcategory` (`ProductCategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Product_Seller` FOREIGN KEY (`SellerID`) REFERENCES `seller` (`SellerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Product_SubCategory` FOREIGN KEY (`ProductSubCategoryID`) REFERENCES `productsubcategory` (`ProductSubCategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `FK_Order_Return` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Return_Customer` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Return_Delivery` FOREIGN KEY (`DeliveryPartnerId`) REFERENCES `deliverypartner` (`DeliveryPartnerId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Return_Product` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shippinginfo`
--
ALTER TABLE `shippinginfo`
  ADD CONSTRAINT `FK_Shopping_Delivery` FOREIGN KEY (`DeliveryPartnerId`) REFERENCES `deliverypartner` (`DeliveryPartnerId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
