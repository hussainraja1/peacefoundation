-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2019 at 07:09 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peacefoundation`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `Username` varchar(15) NOT NULL,
  `Password` varchar(15) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `membertype` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `Username`, `Password`, `Email`, `membertype`) VALUES
(9, 'individual', '123456', 'jamessmithee@extra.co.uk', 'individual'),
(11, 'school', '123456', 'email@hotmail.com', 'school'),
(12, 'organisation', '123456', 'email@hotmail.com', 'organisation'),
(13, 'admin', 'admin', 'admin@hotmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `AddressID` int(10) NOT NULL,
  `id` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `Suburb` varchar(255) NOT NULL,
  `Country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`AddressID`, `id`, `Address`, `City`, `Suburb`, `Country`) VALUES
(12, 9, 'Mount Albert Street', 'Auckland', 'Mount Albert', 'New Zealand'),
(13, 12, 'Mount wellington', 'Auckland', 'Mount W', 'New Zealand');

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `EmployeeID` int(10) NOT NULL,
  `PrivilegeLevel` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `adminsearch`
--

CREATE TABLE `adminsearch` (
  `EmployeeID` int(10) NOT NULL,
  `SearchID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

CREATE TABLE `credit` (
  `PaymentID` int(10) NOT NULL,
  `CardType` varchar(255) NOT NULL,
  `CardNum` int(12) NOT NULL,
  `CardExpiry` int(4) NOT NULL,
  `CVV` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `directdebit`
--

CREATE TABLE `directdebit` (
  `PaymentID` int(10) NOT NULL,
  `AccountName` varchar(255) NOT NULL,
  `AccountNum` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(10) NOT NULL,
  `id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `EmployeeTitle` varchar(255) NOT NULL,
  `DOB` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `get_address`
--

CREATE TABLE `get_address` (
  `AddressID` int(10) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `InvoiceID` int(10) NOT NULL,
  `PaymentID` int(10) NOT NULL,
  `InvoiceNum` varchar(255) NOT NULL,
  `GSTNum` int(12) NOT NULL,
  `IssueDate` date NOT NULL,
  `DueDate` date NOT NULL,
  `AmountDue` float NOT NULL,
  `GSTRate` float NOT NULL,
  `Subtotal` float NOT NULL,
  `PaymentDesc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nonmember`
--

CREATE TABLE `nonmember` (
  `NonMemberID` int(10) NOT NULL,
  `id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `PhoneNum` varchar(15) NOT NULL,
  `DOB` date NOT NULL,
  `Comments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nonmember`
--

INSERT INTO `nonmember` (`NonMemberID`, `id`, `Title`, `FirstName`, `LastName`, `PhoneNum`, `DOB`, `Comments`) VALUES
(12, 9, 'Mr', 'Volkan', 'Aldikacti', '021258492', '2000-08-13', 'Nothing to comment');

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `OrgID` int(10) NOT NULL,
  `id` int(11) NOT NULL,
  `OrgName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Response` char(1) NOT NULL,
  `Annotations` varchar(255) DEFAULT NULL,
  `OrgMembership` char(1) NOT NULL,
  `SchoolSchoolID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`OrgID`, `id`, `OrgName`, `Email`, `Response`, `Annotations`, `OrgMembership`, `SchoolSchoolID`) VALUES
(1, 12, 'Organsi', 'company@hotmail.com', 'Y', 'No', 'Y', 113);

-- --------------------------------------------------------

--
-- Table structure for table `paidmember`
--

CREATE TABLE `paidmember` (
  `MemberID` int(10) NOT NULL,
  `id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Response` char(1) NOT NULL,
  `Annotations` varchar(255) DEFAULT NULL,
  `MemberStatus` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `EndDate` date DEFAULT NULL,
  `DOB` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(10) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `SchoolID` int(10) NOT NULL,
  `id` int(11) NOT NULL,
  `SchoolName` varchar(255) NOT NULL,
  `TrainedBy` varchar(10) NOT NULL,
  `Annotations` varchar(255) DEFAULT NULL,
  `SchoolType` varchar(15) NOT NULL,
  `PartnershipID` varchar(10) DEFAULT NULL,
  `DecileRating` int(2) NOT NULL,
  `MaoriPercentage` int(3) DEFAULT NULL,
  `FullTraining` date NOT NULL,
  `RevisitTraining` date DEFAULT NULL,
  `PrimaryContact` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Principal` varchar(255) DEFAULT NULL,
  `PrincipalEmail` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Interest` char(1) NOT NULL,
  `EmailSent` date DEFAULT NULL,
  `ReplyDate` date DEFAULT NULL,
  `TrainingBooked` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`SchoolID`, `id`, `SchoolName`, `TrainedBy`, `Annotations`, `SchoolType`, `PartnershipID`, `DecileRating`, `MaoriPercentage`, `FullTraining`, `RevisitTraining`, `PrimaryContact`, `Email`, `Principal`, `PrincipalEmail`, `PhoneNumber`, `Interest`, `EmailSent`, `ReplyDate`, `TrainingBooked`) VALUES
(1, 11, 'Mount albert grammar', 'someone', NULL, 'ab', NULL, 2, NULL, '2019-08-07', NULL, NULL, 'school@hotmail.com', NULL, NULL, '1234512', 'y', NULL, NULL, 'y');

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE `search` (
  `SearchID` int(10) NOT NULL,
  `Query` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `EmlpoyeeID` int(10) NOT NULL,
  `PrivilegeLevel` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressID`),
  ADD KEY `fk_address` (`id`);

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `adminsearch`
--
ALTER TABLE `adminsearch`
  ADD PRIMARY KEY (`EmployeeID`,`SearchID`);

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `directdebit`
--
ALTER TABLE `directdebit`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `fk_empUsername` (`id`);

--
-- Indexes for table `get_address`
--
ALTER TABLE `get_address`
  ADD PRIMARY KEY (`AddressID`,`id`),
  ADD KEY `fk_addUsername` (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`InvoiceID`),
  ADD KEY `fk_invpaymentid` (`PaymentID`);

--
-- Indexes for table `nonmember`
--
ALTER TABLE `nonmember`
  ADD PRIMARY KEY (`NonMemberID`),
  ADD KEY `fk_nonMUsername` (`id`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`OrgID`),
  ADD KEY `fk_orgUsername` (`id`);

--
-- Indexes for table `paidmember`
--
ALTER TABLE `paidmember`
  ADD PRIMARY KEY (`MemberID`),
  ADD KEY `fk_username` (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`,`id`),
  ADD KEY `fk_paymentUsername` (`id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`SchoolID`),
  ADD KEY `fk_schoolUsername` (`id`);

--
-- Indexes for table `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`SearchID`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`EmlpoyeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `AddressID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `EmployeeID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `PaymentID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `directdebit`
--
ALTER TABLE `directdebit`
  MODIFY `PaymentID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `InvoiceID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nonmember`
--
ALTER TABLE `nonmember`
  MODIFY `NonMemberID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `OrgID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paidmember`
--
ALTER TABLE `paidmember`
  MODIFY `MemberID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123457;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `SchoolID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `search`
--
ALTER TABLE `search`
  MODIFY `SearchID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `EmlpoyeeID` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_empUsername` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `get_address`
--
ALTER TABLE `get_address`
  ADD CONSTRAINT `fk_addUsername` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `fk_addressid` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_invpaymentid` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`);

--
-- Constraints for table `nonmember`
--
ALTER TABLE `nonmember`
  ADD CONSTRAINT `fk_nonMUsername` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `organisation`
--
ALTER TABLE `organisation`
  ADD CONSTRAINT `fk_orgUsername` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `paidmember`
--
ALTER TABLE `paidmember`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_paymentUsername` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `fk_schoolUsername` FOREIGN KEY (`id`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
