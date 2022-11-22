/*
 Navicat Premium Data Transfer

 Source Server         : LocalHost
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : website

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 22/11/2022 22:27:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for check_log
-- ----------------------------
DROP TABLE IF EXISTS `check_log`;
CREATE TABLE `check_log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `faculty_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `days` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `record_start` time NULL DEFAULT NULL,
  `record_end` time NULL DEFAULT NULL,
  `record_days` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `input_start` time NULL DEFAULT NULL,
  `input_end` time NULL DEFAULT NULL,
  `session` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of check_log
-- ----------------------------

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Subject_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `unit_lec` int NOT NULL,
  `unit_lab` int NOT NULL,
  `Faculty_id` int NULL DEFAULT NULL,
  `Room_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `Lab_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sem_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `Lec_start` time NULL DEFAULT NULL,
  `Lec_end` time NULL DEFAULT NULL,
  `Lab_start` time NULL DEFAULT NULL,
  `Lab_end` time NULL DEFAULT NULL,
  `Lab_day` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `Lec_day` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `students_count` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` int NOT NULL COMMENT '1 = Disabled / 2 = Active',
  `date_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES (1, '0', 0, 0, 10000, '0', '0', '1', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '0', '0', '0', 1, '2022-11-21 15:07:11');
INSERT INTO `class` VALUES (2, '0', 0, 0, 10001, '0', '0', '1', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '0', '0', '0', 1, '2022-11-21 15:07:11');
INSERT INTO `class` VALUES (3, '0', 0, 0, 10000, '0', '0', '1', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '0', '0', '0', 1, '2022-11-21 15:08:23');
INSERT INTO `class` VALUES (4, '0', 0, 0, 10000, '0', '0', '1', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '0', '0', '0', 1, '2022-11-21 15:09:10');
INSERT INTO `class` VALUES (5, '8', 3, 3, 10003, '2', '1', '1', '13:00:00', '14:00:00', '14:00:00', '15:30:00', 'MTH', 'MTH', '10', 0, '2022-11-21 15:27:41');
INSERT INTO `class` VALUES (6, '27', 3, 3, 10004, '2', '1', '1', '16:00:00', '17:00:00', '17:00:00', '18:30:00', 'MTH', 'MTH', '20', 0, '2022-11-21 15:29:12');
INSERT INTO `class` VALUES (7, '7', 3, 3, 10005, '3', '3', '1', '21:30:00', '22:30:00', '10:30:00', '12:00:00', 'MTH', 'MTH', '0', 0, '2022-11-21 15:31:55');
INSERT INTO `class` VALUES (8, '0', 0, 0, 10006, '0', '0', '1', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '0', '0', NULL, 0, '2022-11-21 15:33:53');
INSERT INTO `class` VALUES (9, '0', 0, 0, 10007, '0', '0', '1', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '0', '0', NULL, 0, '2022-11-21 15:34:48');
INSERT INTO `class` VALUES (10, '1', 3, 0, 10003, '2', '0', '1', '09:30:00', '11:00:00', '00:00:00', '00:00:00', '0', 'TF', '7', 0, '2022-11-21 17:00:34');
INSERT INTO `class` VALUES (11, '6', 3, 3, 10003, '2', '1', '1', '18:30:00', '19:30:00', '18:00:00', '19:30:00', 'TF', 'MTH', '5', 0, '2022-11-21 17:10:01');
INSERT INTO `class` VALUES (12, '10', 3, 3, 10003, '2', '1', '1', '13:00:00', '15:00:00', '15:00:00', '18:00:00', 'WED', 'WED', '15', 0, '2022-11-21 17:19:58');
INSERT INTO `class` VALUES (13, '11', 3, 0, 10003, '2', '0', '1', '21:30:00', '22:30:00', '00:00:00', '00:00:00', '0', 'MTH', '9', 0, '2022-11-21 17:29:44');
INSERT INTO `class` VALUES (14, '3', 3, 0, 10003, '2', '0', '1', '08:00:00', '09:30:00', '00:00:00', '00:00:00', '0', 'TF', '6', 0, '2022-11-21 17:31:56');
INSERT INTO `class` VALUES (15, '20', 3, 0, 10003, '2', '0', '1', '08:00:00', '12:00:00', '00:00:00', '00:00:00', '0', 'SAT', '0', 0, '2022-11-21 17:36:12');
INSERT INTO `class` VALUES (16, '2', 3, 3, 10005, '3', '3', '1', '13:00:00', '14:00:00', '14:00:00', '15:30:00', 'MTH', 'MTH', '9', 0, '2022-11-21 17:42:11');
INSERT INTO `class` VALUES (17, '5', 3, 3, 10005, '3', '1', '1', '15:30:00', '16:30:00', '16:30:00', '18:00:00', 'MTH', 'MTH', '8', 0, '2022-11-21 17:48:14');

-- ----------------------------
-- Table structure for faculty
-- ----------------------------
DROP TABLE IF EXISTS `faculty`;
CREATE TABLE `faculty`  (
  `Faculty_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `FirstName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `LastName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `MiddleInitial` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `PhoneNum` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` int NOT NULL COMMENT '1 = Disabled / 0 = Active',
  `date_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`Faculty_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10008 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of faculty
-- ----------------------------
INSERT INTO `faculty` VALUES (10000, 'Jane', 'NotME', 'D0e', '1234567890', 'Unahan Sa Amoa (U.S.A)', 1, '2022-10-19 20:50:05');
INSERT INTO `faculty` VALUES (10001, 'Jason', 'NotME', 'D0e', '1234567890', 'Australian Dollar (AUD)', 1, '2022-10-19 20:50:59');
INSERT INTO `faculty` VALUES (10003, 'Jun Kelvin', 'Tocson', 'D', '09548763289', 'Iligan City', 0, '2022-11-21 15:27:41');
INSERT INTO `faculty` VALUES (10004, 'Albert', 'Yabo', 'A', '09632147854', 'Iligan City', 0, '2022-11-21 15:29:10');
INSERT INTO `faculty` VALUES (10005, 'Jonathan', 'Canete', 'V', '09587963214', 'Iligan City', 0, '2022-11-21 15:31:55');
INSERT INTO `faculty` VALUES (10006, 'Joselito', 'Aban', 'L', '095478945617', 'Iligan City', 0, '2022-11-21 15:33:53');
INSERT INTO `faculty` VALUES (10007, 'Charmie', 'Jariol', 'M', '09632874189', 'Iligan City', 0, '2022-11-21 15:34:48');

-- ----------------------------
-- Table structure for request_log
-- ----------------------------
DROP TABLE IF EXISTS `request_log`;
CREATE TABLE `request_log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `request_id` int NOT NULL,
  `request_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `request_session` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `request_expiration` datetime NULL DEFAULT NULL,
  `request_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of request_log
-- ----------------------------
INSERT INTO `request_log` VALUES (1, 1, '12U02jG2sR120o1bA21VN', '20221122101', '2022-11-22 22:11:51', '2022-11-22 21:47:53');
INSERT INTO `request_log` VALUES (2, 1, 'QjZ22R021kYi2C0YY2112', '20221122102', '2022-11-22 22:18:52', '2022-11-22 22:18:17');
INSERT INTO `request_log` VALUES (3, 1, 'b1G222yN12zA1sJ3O00M2', '20221122103', '2022-11-23 22:20:22', '2022-11-22 22:20:22');

-- ----------------------------
-- Table structure for room
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Room_no` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `building` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of room
-- ----------------------------
INSERT INTO `room` VALUES (1, 'Lab - B', 'C Building', '2022-10-13 20:22:45');
INSERT INTO `room` VALUES (2, 'Google Meet', 'Online Class', '2022-10-13 20:22:54');
INSERT INTO `room` VALUES (3, 'Lab - A', 'C Building', '2022-10-13 23:13:15');

-- ----------------------------
-- Table structure for semester
-- ----------------------------
DROP TABLE IF EXISTS `semester`;
CREATE TABLE `semester`  (
  `Sem_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Sem_no` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `Sem_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `School_year` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`Sem_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of semester
-- ----------------------------
INSERT INTO `semester` VALUES (1, '1', '2022-2023 1st Semester', '2022-2023', '2022-11-21 15:07:11');

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Course_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `offer_no` int NOT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `units` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES (1, 'CS304', 165579, 'Trends, Issues, Seminars and Field Trips in IT', '3', '2022-09-14 10:30:42');
INSERT INTO `subject` VALUES (2, 'ELECT 3', 165576, 'Integrative Programing', '3', '2022-09-14 10:31:43');
INSERT INTO `subject` VALUES (3, 'RCIT', 165578, 'Research Communication in IT', '3', '2022-09-14 10:32:24');
INSERT INTO `subject` VALUES (4, 'NET 101', 165581, 'Network Design and Management', '3', '2022-09-30 10:54:48');
INSERT INTO `subject` VALUES (5, 'CS 303', 165577, 'System Analysis and Design', '3', '2022-10-20 21:44:41');
INSERT INTO `subject` VALUES (6, 'CS 310', 165575, 'System Integration and Architecture 1', '3', '2022-10-20 21:49:02');
INSERT INTO `subject` VALUES (7, 'CS 401', 165583, 'IT Project Management', '3', '2022-10-20 21:51:13');
INSERT INTO `subject` VALUES (8, 'CS 412', 165585, 'Information Assurance and Security', '3', '2022-10-20 21:52:20');
INSERT INTO `subject` VALUES (9, 'CAP 102', 165584, 'Capstone Project and Research 2 - Implementation', '3', '2022-10-20 21:53:32');
INSERT INTO `subject` VALUES (10, 'ELEC 4', 165586, 'System Integration and Architecture 2', '3', '2022-10-20 21:54:59');
INSERT INTO `subject` VALUES (11, 'IT101', 165558, 'Information Technology Fundamentals and Intro. to Computing', '3', '2022-10-24 16:20:27');
INSERT INTO `subject` VALUES (12, 'IT102', 165560, 'Computer Programming', '3', '2022-10-24 16:21:09');
INSERT INTO `subject` VALUES (13, 'QSS', 165569, 'Quality Standard and Safety', '3', '2022-10-27 17:14:47');
INSERT INTO `subject` VALUES (14, 'CS201', 165567, 'Data Structure and Algorithm', '3', '2022-10-27 17:15:54');
INSERT INTO `subject` VALUES (15, 'Free Elec 3', 166151, 'Free Elective 3', '3', '2022-10-27 17:16:54');
INSERT INTO `subject` VALUES (16, 'PEVE', 166179, 'Professional Ethics and Values Education-Requested', '3', '2022-10-27 17:19:08');
INSERT INTO `subject` VALUES (17, 'GE Elec 1', 165696, 'Living in the IT Era', '3', '2022-10-27 17:22:11');
INSERT INTO `subject` VALUES (18, 'ELEC1', 165571, 'Object-oriented & Event Driven Progamming', '3', '2022-10-27 17:25:10');
INSERT INTO `subject` VALUES (19, 'Free Elec 1', 165573, 'Platform Technologies', '3', '2022-10-27 17:26:10');
INSERT INTO `subject` VALUES (20, 'IT Era Elec 2', 165813, 'Living in the IT Era', '3', '2022-10-27 17:28:17');
INSERT INTO `subject` VALUES (21, 'Free Elec 2', 166180, 'Free Elective 2', '3', '2022-10-27 17:30:21');
INSERT INTO `subject` VALUES (22, 'CS 311', 165580, 'Fundamentals of Database System', '3', '2022-10-27 17:32:45');
INSERT INTO `subject` VALUES (23, 'CS 403', 166182, 'Management Information System', '3', '2022-10-27 17:34:19');
INSERT INTO `subject` VALUES (24, 'IT Era Elec1', 165955, 'Living in the IT Era', '3', '2022-10-27 17:35:59');
INSERT INTO `subject` VALUES (25, 'COMP1', 166053, 'Computer Application & E-commerce', '3', '2022-10-27 17:38:24');
INSERT INTO `subject` VALUES (26, 'COMP2', 166056, 'Database System', '3', '2022-10-27 17:39:09');
INSERT INTO `subject` VALUES (27, 'CS 206', 165570, 'Logic Design and Switching Theory', '3', '2022-10-27 17:42:52');
INSERT INTO `subject` VALUES (28, 'TTL 2', 165896, 'Technology for Teaching & Learning on the Elementary Grade', '3', '2022-11-13 20:59:18');
INSERT INTO `subject` VALUES (29, 'TTL 1', 165873, 'Technology for Teaching & Learning 1', '3', '2022-11-13 21:00:04');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `f_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `l_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `dob` date NULL DEFAULT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `contact_num` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `user_type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'Dean', 'Admin', 'Admin', '1992-11-23', 'giovanetinggas@gmail.com', '09112626010', '123', 'dean', '2022-10-01 18:05:18');

SET FOREIGN_KEY_CHECKS = 1;
