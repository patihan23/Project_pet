-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 05:55 PM
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

INSERT INTO `history_v` (`ID_HV`, `HV_date`, `next_Hv_date`, `ID_VC`, `ID_OFF`, `ID_P`) VALUES
(11, '2023-01-20', '2024-01-20', 2, 1, 2),
(12, '2024-07-20', '2024-06-13', 1, 2, 21),
(13, '2024-07-12', '2025-05-20', 1, 1, 2),
(14, '2024-07-01', '2025-07-01', 17, 1, 20),
(15, '2024-07-04', '2024-07-31', 1, 1, 2),
(16, '2024-07-01', '2025-01-21', 1, 2, 2),
(17, '2024-07-21', '2025-01-21', 1, 3, 2),
(18, '2024-07-21', '2025-01-21', 1, 1, 22),
(19, '2024-07-21', '2025-05-21', 1, 2, 22),
(20, '2024-07-21', '2025-09-30', 1, 1, 23),
(21, '2024-07-01', '2025-09-25', 1, 1, 22),
(22, '2024-07-01', '2024-07-15', 1, 2, 19);

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

INSERT INTO `official` (`ID_OFF`, `User`, `Pass`, `Off_name`, `num`, `email`, `pst`, `user_role`, `profile_image`) VALUES
(1, 'kew', '1234', 'นาย ปฏิหาริย์ สุวรรณี', '0823392743', 'lnwqqq@outlook.com', 'แอดมิน', 'admin', '../profile/669e7fc6296219.26344834.jpg'),
(2, 'ying', '1234', 'นรินทร์ทิพย์ พระทอง', '0864186548', 'ying@daw', 'admin', 'admin', '../profile/6699e8840d5785.83582743.jpg'),
(3, 'gift', '1234', 'ชฏาพร ก่ำพิมาย', '0816548648', 'gift@fgawed', 'แอดมิน', 'admin', '../profile/6699e887e4f3e7.09723091.jpg'),
(4, 'test', '1234', '1234', '0515646848', 'twadwa@dawd', 'test', 'user', '../profile/669e8064bc3944.17056224.jpg');

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
  `weight` varchar(10) NOT NULL COMMENT 'น้ำหนัก(กรัม)',
  `p_old` date NOT NULL COMMENT 'อายุสัตว์เลี้ยง',
  `ID_PO` int(11) NOT NULL COMMENT 'รหัสเจ้าของ',
  `year_added` year(4) DEFAULT NULL COMMENT 'ปีที่เพิ่ม\r\nปีที่เพิ่ม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`ID_P`, `Type_pet`, `Breed`, `Pet_name`, `Gender`, `color`, `weight`, `p_old`, `ID_PO`, `year_added`) VALUES
(2, 1, 'บีเกิล', 'บีเกิล', 1, 'ดำ', '5000', '2024-07-02', 1, '2024'),
(3, 2, 'แมว', 'แมวสีดำ', 2, 'ดำ', '3000', '0000-00-00', 2, '2024'),
(4, 1, 'ลาบราดอร์', 'ราดอร์', 1, 'น้ำตาล', '4500', '0000-00-00', 3, '2024'),
(5, 2, 'สก็อตติช', 'มิวส์', 2, 'เทา', '4000', '0000-00-00', 4, '2024'),
(6, 1, 'ชิวาวา', 'ชิวาวา', 1, 'ขาว', '6000', '0000-00-00', 5, '2024'),
(7, 2, 'เปอร์เซีย', 'แจ็กสัน', 1, 'ดำ', '3500', '0000-00-00', 6, '2024'),
(8, 1, 'บีเกิล', 'บีเกิล', 2, 'ดำ', '4800', '0000-00-00', 7, '2024'),
(9, 2, 'แมวไทย', 'ตากล้อง', 1, 'ขาว', '3800', '0000-00-00', 8, '2024'),
(10, 1, 'พุดเดิล', 'ปุ้มปุ้ย', 1, 'น้ำตาล', '5200', '0000-00-00', 9, '2024'),
(11, 2, 'สก็อตติช', 'สก็อตติช', 2, 'เทา', '4200', '0000-00-00', 10, '2023'),
(12, 1, 'ชิวาวา', 'ชิวาวา', 1, 'ขาว', '5800', '0000-00-00', 11, '2024'),
(13, 2, 'เปอร์เซีย', 'แมวแจ็กสัน', 1, 'ดำ', '3700', '0000-00-00', 12, '2023'),
(14, 1, 'บีเกิล', 'บีเกิล', 1, 'ดำ', '4900', '0000-00-00', 13, '2024'),
(15, 2, 'แมวไทย', 'ทอร์ที', 2, 'ขาว', '3900', '0000-00-00', 14, '2023'),
(16, 1, 'ลาบราดอร์', 'โรส', 1, 'น้ำตาล', '5300', '0000-00-00', 15, '2024'),
(17, 2, 'สก็อตติช', 'มิสเตอร์', 1, 'เทา', '4300', '0000-00-00', 16, '2023'),
(18, 1, 'ชิวาวา', 'เฟี๊ยะ', 2, 'ขาว', '5900', '0000-00-00', 17, '2024'),
(19, 2, 'เปอร์เซีย', 'แจ็กสัน', 1, 'ดำ', '3600', '0000-00-00', 18, '2023'),
(20, 1, 'บีเกิล', 'บีเกิล', 1, 'ดำ', '5000', '0000-00-00', 19, '2024'),
(21, 2, 'แมวไทย', 'เรน', 2, 'ขาว', '4000', '0000-00-00', 20, '2023'),
(22, 1, 'ลาบราดอร์', 'ลาบราดอร์', 1, 'น้ำตาล', '', '0000-00-00', 21, '2023'),
(23, 1, 'สก็อตติช', 'ซาฟาเลีย', 1, 'เทา', '4400', '2567-07-01', 22, '2023'),
(24, 1, 'ชิวาวา', 'ชิวาวา', 2, 'ขาว', '6000', '0000-00-00', 23, '2023'),
(27, 1, '122', 'test', 1, 'test', '1000', '2566-01-23', 1, '2023'),
(28, 1, 'ไทย', 'เทสปี', 1, 'ดำ', '100', '2024-07-01', 1, '2024');

-- --------------------------------------------------------

--
-- Table structure for table `pet_own`
--

CREATE TABLE `pet_own` (
  `ID_PO` int(11) NOT NULL COMMENT 'รหัสเจ้าของ',
  `Po_name` varchar(40) NOT NULL COMMENT 'ชื่อ-สกุลเจ้าของ',
  `ID` varchar(13) NOT NULL COMMENT 'เบอร์มือถือ',
  `Hno` varchar(25) NOT NULL COMMENT 'บ้านเลขที่',
  `Moo` varchar(25) NOT NULL COMMENT 'หมู่ที่',
  `tb` varchar(25) NOT NULL COMMENT 'ตำบล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_own`
--

INSERT INTO `pet_own` (`ID_PO`, `Po_name`, `ID`, `Hno`, `Moo`, `tb`) VALUES
(1, 'นางสมหญิง จิตสมหมาย', '082392847', '348/2', '11', 'ในเมือง'),
(2, 'นายสมชาย ใจดี', '092384756', '123', '5', 'ในเมือง'),
(3, 'นางสุดา สวยงาม', '083746928', '456', '3', 'ในเมือง'),
(4, 'นายวิทยา ประสิทธิ์', '073649281', '789', '7', 'ในเมือง'),
(5, 'นางมานี ชาวบ้าน', '062837495', '101', '2', 'ในเมือง'),
(6, 'นายวิทวัส สุขใจ', '052938476', '234', '1', 'ในเมือง'),
(7, 'นายสมพงษ์ รักษาพิภพ', '042837465', '567', '4', 'ในเมือง'),
(8, 'นางสุภาพร อ่อนใจ', '032947568', '890', '6', 'ในเมือง'),
(9, 'นายทวี ธรรมดี', '022837495', '123', '3', 'ในเมือง'),
(10, 'นางเพ็ญศรี ราตรี', '012938475', '456', '5', 'ในเมือง'),
(11, 'นายอนุชา ชาญชัย', '102938475', '789', '2', 'ในเมือง'),
(12, 'นางสาวรัชนี จริงใจ', '202837495', '101', '7', 'ในเมือง'),
(13, 'นายสมปอง สุขสมใจ', '302938475', '234', '4', 'ในเมือง'),
(14, 'นางสุดารัตน์ อ่อนดี', '402837495', '567', '1', 'ในเมือง'),
(15, 'นายธนพล พุ่มพวง', '502938475', '890', '6', 'ในเมือง'),
(16, 'นางพัชรา สวยงาม', '602837495', '123', '5', 'ในเมือง'),
(17, 'นายเกริก ดีใจ', '702938475', '456', '3', 'ในเมือง'),
(18, 'นางทิพย์ทรัพย์ บุญมี', '802837495', '789', '2', 'ในเมือง'),
(19, 'นายสมชาติ ใจเพียง', '902938475', '101', '7', 'ในเมือง'),
(20, 'นางสมศรี ช่างสมชื่น', '1234567891', '234', '4', 'ในเมือง'),
(21, 'นายวิชัย มีดี', '1102837495', '567', '1', 'ในเมือง'),
(22, 'นางสาวจิราพร หงษ์ดี', '1202837495', '890', '6', 'ในเมือง'),
(23, 'นายประสิทธิ์ สุขสมบูรณ์', '1302837495', '123', '5', 'ในเมือง'),
(24, 'นางสุพรรณ สุขสมุทร', '1402837495', '456', '3', 'ในเมือง'),
(25, 'นายสมเกียรติ หล่อหน้า', '1502837495', '789', '2', 'ในเมือง'),
(26, 'นางภาณุมาศ ดีใจ', '1602837495', '101', '7', 'ในเมือง'),
(27, 'นายพงษ์พิสิฐ รักษาสุข', '1702837495', '234', '4', 'ในเมือง'),
(28, 'นางสาววรรณรทิพย์ มีสุข', '1802837495', '567', '1', 'ในเมือง'),
(30, 'eee', '0824687687', '123', '11', '11');

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
  `V_storage` varchar(40) NOT NULL COMMENT 'การจัดเก็บวัคซีน',
  `Expiration_date` date NOT NULL COMMENT 'วันที่หมดอายุ',
  `Dosage` int(10) NOT NULL COMMENT 'จำนวนที่มี'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`ID_VC`, `V_name`, `V_storage`, `Expiration_date`, `Dosage`) VALUES
(1, 'วัคซีนพิษสุนัขบ้า', 'แช่เย็น', '2023-01-08', 100),
(2, 'วัคซีนโรคหัด', 'แช่เย็น', '2023-01-15', 50),
(3, 'วัคซีนพิษสุนัขบ้า', 'แช่เย็น', '2025-09-20', 100),
(4, 'วัคซีนโรคหัด', 'แช่เย็น', '2025-07-30', 50),
(5, 'วัคซีนโรคไข้หวัดใหญ่', 'แช่เย็น', '2025-10-05', 80),
(6, 'วัคซีนโรคไข้หวัดใหญ่', 'แช่เย็น', '2025-09-15', 80),
(7, 'วัคซีนพิษสุนัขบ้า', 'แช่เย็น', '2025-08-25', 100),
(8, 'วัคซีนโรคหัด', 'แช่เย็น', '2025-09-10', 50),
(9, 'วัคซีนโรคไข้หวัดใหญ่', 'แช่เย็น', '2025-07-25', 80),
(10, 'วัคซีนโรคหัด', 'แช่เย็น', '2025-08-05', 50),
(11, 'วัคซีนพิษสุนัขบ้า', 'แช่เย็น', '2025-09-30', 100),
(12, 'วัคซีนโรคไข้หวัดใหญ่', 'แช่เย็น', '2025-10-10', 80),
(13, 'วัคซีนพิษสุนัขบ้า', 'แช่เย็น', '2025-07-20', 100),
(14, 'วัคซีนโรคหัด', 'แช่เย็น', '2025-08-20', 50),
(17, 'test', '123', '2024-07-31', 100);

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
  MODIFY `ID_HV` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการฉีดวัคซีน', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `official`
--
ALTER TABLE `official`
  MODIFY `ID_OFF` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าหน้าที่', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `ID_P` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสัตว์เลี้ยง', AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pet_own`
--
ALTER TABLE `pet_own`
  MODIFY `ID_PO` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าของ', AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sterilization`
--
ALTER TABLE `sterilization`
  MODIFY `ID_S` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการทำหมัน';

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `ID_VC` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสวัคซีน', AUTO_INCREMENT=20;

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
