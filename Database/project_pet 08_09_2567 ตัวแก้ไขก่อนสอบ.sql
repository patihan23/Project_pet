-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2024 at 07:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
(1, '2024-11-10', '2025-11-09', 1, 5, 1),
(2, '2024-11-10', '2025-11-09', 1, 1, 2),
(3, '2023-01-10', '2024-01-09', 1, 5, 3),
(4, '2025-09-08', '2026-09-08', 1, 1, 1);

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
(1, 'kew', '1234', 'ปฏิหาริย์ สุวรรณี', '0823392743', 'lnwqqq@outlook.com', 'Admin', 'admin', '../profile/66dc91eb769923.89134308.png'),
(2, 'gift', '1234', 'นางสาวชฎาพร ก่ำพิมาย', '0879612658', 'chadaporn.km@rmuti.ac.th', 'Admin', 'admin', '../profile/66dc75cbd91451.92680113.png'),
(3, 'ying', '1234', 'นางสาวนรินทร์ทิพย์ พระทอง', '0957840776', 'narinthip.ph@rmuti.ac.th', 'Admin', 'admin', '../profile/66dc7606f1a372.39423682.png'),
(4, 'admin', '11111', 'นายอาทิตย์ แสงทอง', '0812345678', 'admin01@example.com', 'เจ้าหน้าที่', 'user', '../profile/66dc762e72c356.49343124.png'),
(5, 'vet', '22222', 'นายกิตติพงษ์ จันทร์สุข', '0823456789', 'vet01@example.com', 'เจ้าหน้าที่', 'user', '../profile/66dc764b4506f3.02481416.png'),
(6, 'officer', '33333', 'นางสาวศิริพร เพ็ญแสง', '0834567890', 'officer01@example.com', 'สัตวแพทย์', 'user', '../profile/66dc766fe72fb4.25320976.png');

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
  `status` varchar(3) NOT NULL COMMENT 'สถานะ 1 คือตาย 2 คือ อยู่',
  `ID_PO` int(11) NOT NULL COMMENT 'รหัสเจ้าของ',
  `year_added` year(4) DEFAULT NULL COMMENT 'ปีที่เพิ่ม\r\nปีที่เพิ่ม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`ID_P`, `Type_pet`, `Breed`, `Pet_name`, `Gender`, `color`, `weight`, `p_old`, `status`, `ID_PO`, `year_added`) VALUES
(1, 1, 'พุดเดิ้ล', 'โบโบ้', 1, 'ขาว', '5', '2020-05-10', '2', 10, '2024'),
(2, 2, 'เปอร์เซีย', 'มีมี้', 2, 'เทา', '3', '2021-01-10', '1', 14, '2024'),
(3, 1, 'ชิบะอินุ', 'ชิโร่', 1, 'น้ำตาล - ข', '28', '2019-12-30', '2', 6, '2024'),
(4, 2, 'เปอร์เซีย', 'ดอลล่า', 2, 'น้ำตาล', '4', '2021-01-06', '1', 12, '2024'),
(5, 2, 'อเมริกันช็อตแฮร์', 'ข้าวปั้น', 1, 'เทา', '4', '2020-10-20', '1', 7, '2024'),
(6, 1, 'พุดเดิ้ล', 'มะลิ', 2, 'ขาว', '6', '2019-06-18', '2', 3, '2022'),
(7, 2, 'เปอร์เซีย', 'ฟูฟู', 1, 'เทา', '2', '2022-04-12', '1', 11, '2022'),
(8, 1, 'ชิบะอินุ', 'ซากุระ', 2, 'น้ำตาล - ข', '5', '2018-10-25', '2', 8, '2022'),
(9, 2, 'เปอร์เซีย', 'ป๊อบปี้', 1, 'น้ำตาล', '3', '2021-02-16', '1', 18, '2022'),
(10, 2, 'อเมริกันช็อตแฮร์', 'โมจิ', 2, 'เทา', '4', '2020-09-25', '1', 16, '2022'),

(11, 1, 'พุดเดิ้ล', 'ซูซี่', 2, 'ขาว', '5', '2020-07-20', '2', 9, '2023'),
(12, 2, 'เปอร์เซีย', 'โรลลี่', 1, 'เทา', '3', '2021-05-11', '1', 4, '2023'),
(13, 1, 'ชิบะอินุ', 'ริกะ', 2, 'น้ำตาล - ข', '4', '2019-11-22', '2', 15, '2023'),
(14, 2, 'เปอร์เซีย', 'มิกกี้', 1, 'น้ำตาล', '2', '2021-03-30', '1', 5, '2023'),
(15, 2, 'อเมริกันช็อตแฮร์', 'โอโตะ', 2, 'เทา', '3', '2020-11-10', '1', 21, '2023'),

(16, 1, 'พุดเดิ้ล', 'นัทสึ', 1, 'ขาว', '4', '2019-08-30', '2', 20, '2023'),
(17, 2, 'เปอร์เซีย', 'โคล่า', 2, 'เทา', '2', '2022-03-12', '1', 13, '2024'),
(18, 1, 'ชิบะอินุ', 'ซาโต้', 1, 'น้ำตาล - ข', '7', '2017-06-28', '2', 17, '2024'),
(19, 2, 'เปอร์เซีย', 'มาร์ชเมลโล่', 2, 'น้ำตาล', '5', '2020-12-10', '1', 2, '2024'),
(20, 2, 'อเมริกันช็อตแฮร์', 'ดราก้อน', 1, 'เทา', '6', '2019-07-18', '1', 19, '2024'),

(21, 1, 'พุดเดิ้ล', 'กะทิ', 1, 'ขาว', '5', '2020-05-15', '2', 6, '2022'),
(22, 2, 'เปอร์เซีย', 'ปีโป้', 2, 'เทา', '4', '2019-12-23', '1', 17, '2022'),
(23, 1, 'ชิบะอินุ', 'โซระ', 1, 'น้ำตาล - ข', '6', '2018-02-20', '2', 1, '2022'),
(24, 2, 'เปอร์เซีย', 'โบโบ้', 2, 'น้ำตาล', '3', '2021-01-10', '1', 12, '2022'),
(25, 2, 'อเมริกันช็อตแฮร์', 'เครป', 1, 'เทา', '2', '2022-06-19', '1', 21, '2022'),

(26, 1, 'พุดเดิ้ล', 'พาสต้า', 2, 'ขาว', '7', '2017-09-22', '2', 18, '2023'),
(27, 2, 'เปอร์เซีย', 'บูบู้', 2, 'เทา', '3', '2021-04-25', '1', 10, '2023'),
(28, 1, 'ชิบะอินุ', 'มารุ', 1, 'น้ำตาล - ข', '4', '2019-03-01', '2', 14, '2023'),
(29, 2, 'เปอร์เซีย', 'ดอลล่า', 2, 'น้ำตาล', '2', '2021-01-06', '1', 3, '2023'),
(30, 2, 'อเมริกันช็อตแฮร์', 'เค้ก', 1, 'เทา', '5', '2020-10-15', '1', 7, '2023'),

(31, 1, 'พุดเดิ้ล', 'ครีม', 1, 'ขาว', '6', '2019-01-11', '2', 5, '2024'),
(32, 2, 'เปอร์เซีย', 'ลาเต้', 2, 'เทา', '3', '2021-09-12', '1', 16, '2024'),
(33, 1, 'ชิบะอินุ', 'ชิโร่', 1, 'น้ำตาล - ข', '6', '2018-12-14', '2', 9, '2024'),
(34, 2, 'เปอร์เซีย', 'โฟโต้', 2, 'น้ำตาล', '4', '2020-04-25', '1', 18, '2024'),
(35, 2, 'อเมริกันช็อตแฮร์', 'ขนม', 2, 'เทา', '3', '2021-03-10', '1', 2, '2024'),

(36, 1, 'พุดเดิ้ล', 'ตังเม', 1, 'ขาว', '5', '2020-01-25', '2', 6, '2022'),
(37, 2, 'เปอร์เซีย', 'ชาช่า', 1, 'เทา', '2', '2022-08-15', '1', 21, '2022'),
(38, 1, 'ชิบะอินุ', 'รันรัน', 2, 'น้ำตาล - ข', '4', '2019-03-05', '2', 10, '2022'),
(39, 2, 'เปอร์เซีย', 'ปูเป้', 2, 'น้ำตาล', '3', '2021-01-28', '1', 17, '2022'),
(40, 2, 'อเมริกันช็อตแฮร์', 'ฟูกี้', 1, 'เทา', '5', '2020-10-12', '1', 12, '2022'),

(41, 1, 'พุดเดิ้ล', 'โกโก้', 1, 'ขาว', '6', '2019-08-10', '2', 3, '2023');


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

INSERT INTO `pet_own` (`ID_PO`, `Po_name`, `ID`, `Hno`, `Moo`, `tb`, `cat`, `dog`, `date_add`) VALUES
(1, 'นางสาวนรินทร์ทิพย์ พระทอง', '1234567890124', '78', '1', 'โบสถ์', '', '', '2024-09-07'),
(2, 'นายชาติชาย นามดี', '9012345678902', '132', '2', 'โบสถ์', '', '', '2024-09-07'),
(3, 'นางสาวพรทิพย์ น้อยดี', '1234567890123', '62', '4', 'โบสถ์', '', '', '2024-09-07'),
(4, 'นายสมชาย ใจดี', '3456789012345', '125', '7', 'โบสถ์', '', '', '2024-09-07'),
(5, 'นางสาวสุดารัตน์ อินทร์ทอง', '2345678901234', '15', '6', 'โบสถ์', '', '', '2024-09-07'),
(6, 'นางสาววรัญญา ใจงาม', '5678901234567', '45', '8', 'โบสถ์', '', '', '2022-09-07'),
(7, 'นายวุฒิชัย เก่งดี', '6789012345678', '87', '3', 'โบสถ์', '', '', '2022-09-07'),
(8, 'นางสาวกมลทิพย์ สวยดี', '7890123456789', '96', '5', 'โบสถ์', '', '', '2022-09-07'),
(9, 'นายธนชัย น้อยงาม', '8901234567890', '38', '4', 'โบสถ์', '', '', '2022-09-07'),
(10, 'นางสาวชลธิชา แสนดี', '9012345678901', '58', '2', 'โบสถ์', '', '', '2022-09-07'),

(11, 'นางสาวสุภาพร ศรีสุข', '0123456789012', '73', '1', 'โบสถ์', '', '', '2023-09-07'),
(12, 'นายสมพงษ์ เจริญดี', '2345678901234', '112', '6', 'โบสถ์', '', '', '2023-09-07'),
(13, 'นางสาวปิยะดา จันทร์งาม', '3456789012345', '60', '7', 'โบสถ์', '', '', '2023-09-07'),
(14, 'นายธีระชัย สุขดี', '4567890123456', '83', '9', 'โบสถ์', '', '', '2023-09-07'),
(15, 'นางสาวชุติมา นิลทอง', '5678901234567', '51', '5', 'โบสถ์', '', '', '2023-09-07'),

(16, 'นายศิริชัย เพชรดี', '6789012345678', '49', '3', 'โบสถ์', '', '', '2024-09-07'),
(17, 'นางสาวอรพรรณ อินทอง', '7890123456789', '62', '5', 'โบสถ์', '', '', '2024-09-07'),
(18, 'นายปกรณ์ สินดี', '8901234567890', '75', '8', 'โบสถ์', '', '', '2024-09-07'),
(19, 'นางสาวจารุวรรณ สวยงาม', '9012345678901', '89', '9', 'โบสถ์', '', '', '2024-09-07'),
(20, 'นายบุญชัย เจริญทรัพย์', '0123456789012', '110', '7', 'โบสถ์', '', '', '2024-09-07'),
(21, 'นางสาวสุดาพร สง่างาม', '1234567890123', '99', '4', 'โบสถ์', '', '', '2024-09-07');


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

INSERT INTO `vaccine` (`ID_VC`, `V_name`, `V_info`, `V_storage`, `Expiration_date`, `Dosage`) VALUES
(1, 'RabiesVax', 'ป้องกันพิษสุนัขบ้า', 'เก็บในที่เย็นอุณหภูมิ 2-8°C', '2025-12-15', 50),
(2, 'RabiesVax', 'ป้องกันพิษสุนัขบ้า', 'เก็บในที่เย็นอุณหภูมิ 2-8°C', '2024-11-15', 50),
(3, 'RabiesVax', 'ป้องกันพิษสุนัขบ้า', 'เก็บในที่เย็นอุณหภูมิ 2-8°C', '2023-12-15', 50);

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
  MODIFY `ID_HV` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการฉีดวัคซีน', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `official`
--
ALTER TABLE `official`
  MODIFY `ID_OFF` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าหน้าที่', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `ID_P` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสัตว์เลี้ยง', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pet_own`
--
ALTER TABLE `pet_own`
  MODIFY `ID_PO` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าของ', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sterilization`
--
ALTER TABLE `sterilization`
  MODIFY `ID_S` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการทำหมัน';

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `ID_VC` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสวัคซีน', AUTO_INCREMENT=4;

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
