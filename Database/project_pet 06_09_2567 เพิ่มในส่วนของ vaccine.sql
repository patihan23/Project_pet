-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2024 at 07:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_pet`
--

-- --------------------------------------------------------

--
-- Table structure for table `history_v`
--

CREATE TABLE `history_v` (
  `ID_HV` int(11) NOT NULL COMMENT 'รหัสการฉีดวัคซีน',
  `HV_date` date NOT NULL COMMENT 'วันที่ฉีดวัคซีน',
  `next_Hv_date` date NOT NULL COMMENT 'วันที่ฉีดวัคซีนครั้งถัดไป',
  `ID_VC` int(11) NOT NULL COMMENT 'รหัสวัคซีน',
  `ID_OFF` int(11) NOT NULL COMMENT 'รหัสเจ้าหน้าที่',
  `ID_P` int(11) NOT NULL COMMENT 'รหัสสัตว์เลี้ยง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_v`
--




-- --------------------------------------------------------

--
-- Table structure for table `official`
--

CREATE TABLE `official` (
  `ID_OFF` int(11) NOT NULL COMMENT 'รหัสเจ้าหน้าที่',
  `User` varchar(40) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `Pass` varchar(40) NOT NULL COMMENT 'รหัสผ่าน',
  `Off_name` varchar(40) NOT NULL COMMENT 'ชื่อ-สกุลเจ้าหน้าที่',
  `num` varchar(10) NOT NULL COMMENT 'เบอร์โทร',
  `email` varchar(30) NOT NULL COMMENT 'อีเมล์',
  `pst` varchar(40) NOT NULL COMMENT 'ตำแหน่ง',
  `user_role` varchar(40) NOT NULL COMMENT 'หน้าที่',
  `profile_image` varchar(255) DEFAULT NULL COMMENT 'รูปภาพ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `official`
--



-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `ID_P` int(11) NOT NULL COMMENT 'รหัสสัตว์เลี้ยง',
  `Type_pet` int(11) NOT NULL COMMENT 'ประเภทสัตว์เลี้ยง{1: สุนัข, 2: แมว}',
  `Breed` varchar(40) NOT NULL COMMENT 'สายพันธุ์',
  `Pet_name` varchar(40) NOT NULL COMMENT 'ชื่อสัตว์เลี้ยง',
  `Gender` int(11) NOT NULL COMMENT 'เพศสัตว์เลี้ยง{1: เพศผู้, 2: เพศเมีย}',
  `color` varchar(10) NOT NULL COMMENT 'สีสัตว์เลี้ยง',
  `weight` varchar(10) NOT NULL COMMENT 'น้ำหนัก(กิโลกรัม)',
  `p_old` date NOT NULL COMMENT 'อายุสัตว์เลี้ยง',
  `ID_PO` int(11) NOT NULL COMMENT 'รหัสเจ้าของ',
  `year_added` year(4) DEFAULT NULL COMMENT 'ปีที่เพิ่ม\r\nปีที่เพิ่ม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--




-- --------------------------------------------------------

--
-- Table structure for table `pet_own`
--

CREATE TABLE `pet_own` (
  `ID_PO` int(11) NOT NULL COMMENT 'รหัสเจ้าของ',
  `Po_name` varchar(40) NOT NULL COMMENT 'ชื่อ-สกุลเจ้าของ',
  `ID` varchar(13) NOT NULL COMMENT 'บัตรประจำตัวประชาชน',
  `Hno` varchar(25) NOT NULL COMMENT 'บ้านเลขที่',
  `Moo` varchar(25) NOT NULL COMMENT 'หมู่ที่',
  `tb` varchar(25) NOT NULL COMMENT 'ตำบล',
  `cat` varchar(5) NOT NULL COMMENT 'จำนวนแมว',
  `dog` varchar(5) NOT NULL COMMENT 'จำนวนหมา',
  `date_add` date NOT NULL COMMENT 'วันเดือนปีที่เก็บข้อมูล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_own`
--




-- --------------------------------------------------------

--
-- Table structure for table `sterilization`
--

CREATE TABLE `sterilization` (
  `ID_S` int(11) NOT NULL COMMENT 'รหัสการทำหมัน',
  `S_date` date NOT NULL COMMENT 'วันที่ทำหมัน',
  `ID_OFF` int(11) NOT NULL COMMENT 'รหัสเจ้าหน้าที่',
  `ID_P` int(11) NOT NULL COMMENT 'รหัสสัตว์เลี้ยง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `ID_VC` int(11) NOT NULL COMMENT 'รหัสวัคซีน',
  `V_name` varchar(40) NOT NULL COMMENT 'ชื่อวัคซีน',
  `V_info` varchar(40) NOT NULL COMMENT 'รายละเอียดวัคซีน',
  `V_storage` varchar(40) NOT NULL COMMENT 'การจัดเก็บวัคซีน',
  `Expiration_date` date NOT NULL COMMENT 'วันที่หมดอายุ',
  `Dosage` int(10) NOT NULL COMMENT 'จำนวนที่มี'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_v`
--
ALTER TABLE `history_v`
  ADD PRIMARY KEY (`ID_HV`),
  ADD KEY `ID_VC` (`ID_VC`),
  ADD KEY `ID_OFF` (`ID_OFF`),
  ADD KEY `ID_P` (`ID_P`);

--
-- Indexes for table `official`
--
ALTER TABLE `official`
  ADD PRIMARY KEY (`ID_OFF`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`ID_P`),
  ADD KEY `ID_PO` (`ID_PO`);

--
-- Indexes for table `pet_own`
--
ALTER TABLE `pet_own`
  ADD PRIMARY KEY (`ID_PO`);

--
-- Indexes for table `sterilization`
--
ALTER TABLE `sterilization`
  ADD PRIMARY KEY (`ID_S`),
  ADD KEY `ID_OFF` (`ID_OFF`),
  ADD KEY `ID_P` (`ID_P`);

--
-- Indexes for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD PRIMARY KEY (`ID_VC`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_v`
--
ALTER TABLE `history_v`
  MODIFY `ID_HV` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการฉีดวัคซีน';

--
-- AUTO_INCREMENT for table `official`
--
ALTER TABLE `official`
  MODIFY `ID_OFF` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าหน้าที่';

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `ID_P` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสัตว์เลี้ยง';

--
-- AUTO_INCREMENT for table `pet_own`
--
ALTER TABLE `pet_own`
  MODIFY `ID_PO` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าของ';

--
-- AUTO_INCREMENT for table `sterilization`
--
ALTER TABLE `sterilization`
  MODIFY `ID_S` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการทำหมัน';

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `ID_VC` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสวัคซีน';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_v`
--
ALTER TABLE `history_v`
  ADD CONSTRAINT `history_v_ibfk_1` FOREIGN KEY (`ID_OFF`) REFERENCES `official` (`ID_OFF`),
  ADD CONSTRAINT `history_v_ibfk_2` FOREIGN KEY (`ID_P`) REFERENCES `pet` (`ID_P`),
  ADD CONSTRAINT `history_v_ibfk_3` FOREIGN KEY (`ID_VC`) REFERENCES `vaccine` (`ID_VC`);

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `pet_ibfk_1` FOREIGN KEY (`ID_PO`) REFERENCES `pet_own` (`ID_PO`);

--
-- Constraints for table `sterilization`
--
ALTER TABLE `sterilization`
  ADD CONSTRAINT `sterilization_ibfk_1` FOREIGN KEY (`ID_OFF`) REFERENCES `official` (`ID_OFF`),
  ADD CONSTRAINT `sterilization_ibfk_2` FOREIGN KEY (`ID_P`) REFERENCES `pet` (`ID_P`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
