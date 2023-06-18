-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2023 at 06:39 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cribs`
--

-- --------------------------------------------------------

--
-- Table structure for table `distances`
--

CREATE TABLE `distances` (
  `Dist_ID` int(11) NOT NULL,
  `Prop_ID` int(11) NOT NULL,
  `Dist_A` double NOT NULL,
  `Dist_B` double NOT NULL,
  `Dist_C` double NOT NULL,
  `Dist_D` double NOT NULL,
  `Dist_E` double NOT NULL,
  `Dist_F` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distances`
--

INSERT INTO `distances` (`Dist_ID`, `Prop_ID`, `Dist_A`, `Dist_B`, `Dist_C`, `Dist_D`, `Dist_E`, `Dist_F`) VALUES
(19, 38, 0.78, 0.29, 1, 0.42, 1.38, 2.02),
(20, 39, 1.54, 1.05, 1.26, 0.68, 0.8, 1.44),
(21, 40, 2.93, 2.44, 2.65, 2.07, 1.66, 0.32),
(22, 41, 3.1, 2.61, 1.52, 2.22, 3.18, 3.82),
(23, 42, 5.15, 4.66, 4.86, 4.28, 4.88, 5.52),
(24, 43, 3.15, 2.65, 3.27, 2.69, 3.29, 3.93),
(25, 44, 1.62, 1.13, 1.34, 0.76, 0.72, 1.36),
(26, 45, 2.68, 2.19, 0.9, 1.6, 2.57, 3.21),
(27, 46, 4.16, 3.67, 5.63, 5.05, 5.65, 6.29),
(28, 47, 1.21, 0.72, 0.93, 0.35, 0.95, 1.59);

-- --------------------------------------------------------

--
-- Table structure for table `landlords`
--

CREATE TABLE `landlords` (
  `Land_ID` int(11) NOT NULL,
  `FName` varchar(30) NOT NULL,
  `LName` varchar(30) NOT NULL,
  `Cell_Number` varchar(30) NOT NULL,
  `Land_Email` varchar(100) NOT NULL,
  `Land_Pass` binary(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `landlords`
--

INSERT INTO `landlords` (`Land_ID`, `FName`, `LName`, `Cell_Number`, `Land_Email`, `Land_Pass`) VALUES
(13, 'Harry', 'Potter', '0678901234', 'harrypotter@gmail.com', 0x2432792431302458363979482e6e5551544379682e6f4d73366c432e4f4a59527257664b796f2f3256534c5a6d456573576b73455845614e6d4a7036),
(14, 'Jon', 'Snow', '0687654321', 'jonsnow@gmail.com', 0x24327924313024716d4f75543176526d2e6f5041434842364c3939487541477263716d5345597637326c4945477a542f644a75633337546879587432),
(15, 'Hermoine', 'Granger', '0678012345', 'hermione.granger@gmail.com', 0x24327924313024614436496d79596b655247717a644b4651515152624f36496a327a36656b45314e66514d43674964503132783044416535626c4f47),
(16, 'Tony', 'Stark', '0667890123', 'tony.stark@gmail.com', 0x2432792431302447544d646e454e707731326a37374859614e745a634f654e746d61324750326b576a6d76723049664671766464636f764a50655753),
(17, 'Daenerys', 'Targaryen', '0676543210', 'daenerys.targaryen@gmail.com', 0x243279243130242e626146334253624d324b583659426f616232484a2e65727965306c4a662e2f5a5751344d683746496b6a366f7370766d4c56662e),
(18, 'Luke', 'Skywalker', '0680123456', 'luke.skywalker@gmail.com', 0x24327924313024536e75736b41484b7352343947576e70374f6c33757557764e70366c4e52784d544f486841746e4e3378376e7654452f5947307275),
(19, 'Katniss', 'Everdeen', '0678901234', 'katniss.everdeen@gmail.com', 0x243279243130247038686f65484c7263415a674543396435734f7a386570676d6e544834747a70627658483447517a67736d6d464744613770576361),
(20, 'Sherlock', 'Holmes', '0665432109', 'sherlock.holmes@gmail.com', 0x24327924313024356837484b354b6f6d7475533478576d6f7277315a65614b4742506149596a4a636f444248754c4c4849724378367a307838684757),
(21, 'Walter', 'White', '0689012345', 'walter.white@gmail.com', 0x24327924313024584853374d34534d6f556b457a722f68332f4439794f4646517178305930303372746d4a734d362f2e66516f6731704f796947502e),
(22, 'Lara', 'Croft', '0667890123', 'lara.croft@gmail.com', 0x2432792431302449776e4c6961646e725a515376794245664f45696865784c43714e73755764657a34725851395669706e7844795176497276394c4b);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `Phot_ID` int(11) NOT NULL,
  `Prop_ID` int(11) NOT NULL,
  `Phot_Data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`Phot_ID`, `Prop_ID`, `Phot_Data`) VALUES
(106, 38, 'uploads/Capture.PNG'),
(107, 38, 'uploads/Capture1.PNG'),
(108, 38, 'uploads/Capture2.PNG'),
(109, 38, 'uploads/Capture3.PNG'),
(110, 39, 'uploads/Capture4.PNG'),
(111, 39, 'uploads/Capture5.PNG'),
(112, 39, 'uploads/Capture6.PNG'),
(113, 40, 'uploads/Capture7.PNG'),
(114, 40, 'uploads/Capture8.PNG'),
(115, 40, 'uploads/Capture9.PNG'),
(116, 40, 'uploads/Capture10.PNG'),
(117, 41, 'uploads/Capture11.PNG'),
(118, 41, 'uploads/Capture12.PNG'),
(119, 41, 'uploads/WhatsApp Image 2023-06-15 at 14.11.24.jpg'),
(120, 42, 'uploads/Capture13.PNG'),
(121, 42, 'uploads/Capture14.PNG'),
(122, 42, 'uploads/Capture15.PNG'),
(123, 43, 'uploads/Capture16.PNG'),
(124, 43, 'uploads/Capture17.PNG'),
(125, 43, 'uploads/Capture18.PNG'),
(126, 43, 'uploads/Capture19.PNG'),
(127, 44, 'uploads/Capture20.PNG'),
(128, 44, 'uploads/Capture21.PNG'),
(129, 44, 'uploads/Capture22.PNG'),
(130, 45, 'uploads/Capture23.PNG'),
(131, 45, 'uploads/Capture24.PNG'),
(132, 45, 'uploads/Capture25.PNG'),
(133, 46, 'uploads/Capture26.PNG'),
(134, 46, 'uploads/Capture27.PNG'),
(135, 46, 'uploads/Capture28.PNG'),
(136, 46, 'uploads/Capture29.PNG'),
(137, 46, 'uploads/Capture30.PNG'),
(138, 47, 'uploads/Capture31.PNG'),
(139, 47, 'uploads/Capture32.PNG'),
(140, 47, 'uploads/Capture33.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `Prop_ID` int(11) NOT NULL,
  `Land_ID` int(11) DEFAULT NULL,
  `Prop_Address` text DEFAULT NULL,
  `Prop_Location` point NOT NULL,
  `Prop_Description` text DEFAULT NULL,
  `Prop_Price` decimal(10,2) DEFAULT NULL,
  `Prop_Avail` date DEFAULT NULL,
  `Prop_Popularity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`Prop_ID`, `Land_ID`, `Prop_Address`, `Prop_Location`, `Prop_Description`, `Prop_Price`, `Prop_Avail`, `Prop_Popularity`) VALUES
(38, 13, '7 Wall Street', 0x00000000010100000084595749c4173b40d141ad00b7b13ac0, '2 Bedroom 1 Bathroom', '5000.00', '2023-06-19', 0),
(39, 13, '7 Bourbon Street', 0x000000000101000000b8354ad0c9183b403df750da72b03ac0, '1 Bedroom 1 Bathroom', '4000.00', '2023-06-21', 0),
(40, 14, '5 Fifth Road', 0x00000000010100000023a5e4ad2e193b408e0f98ccc1ad3ac0, '1 Bedroom 1 Bathroom with Patio', '5999.99', '2023-06-28', 0),
(41, 14, '56 Park Avenue', 0x00000000010100000038817e4c6d133b40102beca772b13ac0, '1 Bedroom 1 Bathroom with Complementary Electrical Engineer', '1499.99', '2023-07-07', 0),
(42, 15, '5 Oxford Street', 0x0000000001010000002223a800e81d3b40057ff4e668b23ac0, '1 Bedroom 1 Bathroom', '5800.00', '2023-06-26', 0),
(43, 15, '99 Abbey Road', 0x000000000101000000baf74f0a3a193b40800fa716b0b53ac0, '1 Bedroom 1 Bathroom', '3500.00', '2023-07-05', 0),
(44, 16, '4 Sunset Boulevard', 0x0000000001010000003f206300c7183b403fc8cd1b43b03ac0, '1 bedroom 1 Bathroom', '3000.00', '2023-08-23', 0),
(45, 16, '62 Lombard Street', 0x00000000010100000042529376b0153b4095bc71ed6db23ac0, '1 Bedroom', '4099.99', '2023-07-25', 0),
(46, 17, '44 Rodeo Drive', 0x0000000001010000000dcb4de07f183b40a74c9ed6e1b73ac0, '2 Bedroom 1 Bathroom', '6000.00', '2023-08-31', 0),
(47, 17, '55 Nelson Road', 0x0000000001010000008573b76b7f183b4058d02c210bb13ac0, '1 Bedroom 1 Bathroom', '7000.00', '2023-07-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Stud_ID` int(11) NOT NULL,
  `FName` varchar(30) NOT NULL,
  `LName` varchar(30) NOT NULL,
  `Stud_Email` varchar(100) NOT NULL,
  `Stud_Pass` binary(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Stud_ID`, `FName`, `LName`, `Stud_Email`, `Stud_Pass`) VALUES
(6, 'Albert', 'Einstein', 'einstein.albert@gmail.com', 0x2432792431302456614f2f442e7879374e6d6f4b4873336a687936714f7634382e4570766547675a2e56554c6352767a7a364f4d65364b656f77414f),
(7, 'Marie', 'Curie', 'curie.marie@gmail.com', 0x24327924313024343568505434765465765634622f53527a583573324f48394c676a714c2e533843486f4a325a656d2e7450564a704b324778304a71),
(8, 'Isaac', 'Newton', 'newton.isaac@gmail.com', 0x24327924313024536244413157647271387137786235487758732e512e6f3379372f724c6c51656345706d6b50664c62686a5366412e36436d575143),
(9, 'Nikola', 'Tesla', 'tesla.nikola@gmail.com', 0x24327924313024796b4d546c56624658433034466e6147715137504a754a3759575a7a72746637764a6d55654c4f4f436e6f6d676167594574336f65),
(10, 'Charles', 'Darwin', 'darwin.charles@gmail.com', 0x24327924313024626532786d47525542597561755762533267715933656c352e4e7a676437686c775555636434326f7a366e36384f6b786b58304479);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `distances`
--
ALTER TABLE `distances`
  ADD PRIMARY KEY (`Dist_ID`),
  ADD KEY `test3` (`Prop_ID`);

--
-- Indexes for table `landlords`
--
ALTER TABLE `landlords`
  ADD PRIMARY KEY (`Land_ID`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`Phot_ID`),
  ADD KEY `test2` (`Prop_ID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`Prop_ID`),
  ADD KEY `test` (`Land_ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Stud_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `distances`
--
ALTER TABLE `distances`
  MODIFY `Dist_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `landlords`
--
ALTER TABLE `landlords`
  MODIFY `Land_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `Phot_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `Prop_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Stud_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `distances`
--
ALTER TABLE `distances`
  ADD CONSTRAINT `test3` FOREIGN KEY (`Prop_ID`) REFERENCES `properties` (`Prop_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `test2` FOREIGN KEY (`Prop_ID`) REFERENCES `properties` (`Prop_ID`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `test` FOREIGN KEY (`Land_ID`) REFERENCES `landlords` (`Land_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
