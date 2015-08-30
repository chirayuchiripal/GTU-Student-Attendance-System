SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DELIMITER $$
DROP PROCEDURE IF EXISTS `student_presence_from_master`$$
CREATE PROCEDURE `student_presence_from_master`(IN mst_id BIGINT UNSIGNED)
BEGIN
select division,batchno from Attendance_Master where attd_mst_id = mst_id;
select Attendance.stud_id,CONCAT(stud_name,' ',stud_father_name,' ',stud_surname) as stud_name,stud_rollno,stud_enrolmentno,sum(presence) as presence,count(presence) as total,ROUND((sum(presence) / count(presence))*100,2) as percentage from Attendance 
join Student_Master
on Student_Master.stud_id = Attendance.stud_id
where lec_id in(select lec_id from Lectures where attd_mst_id=mst_id and active = 1) group by Attendance.stud_id order by stud_rollno ASC;
END$$

DELIMITER ;

DROP TABLE IF EXISTS `Academic_Calendar`;
CREATE TABLE IF NOT EXISTS `Academic_Calendar` (
`ac_id` mediumint(8) unsigned NOT NULL COMMENT 'Primary Key',
  `start_date` date NOT NULL COMMENT 'Starting Date',
  `end_date` date NOT NULL COMMENT 'Ending Date',
  `prog_id` tinyint(3) unsigned NOT NULL COMMENT 'References Prog_Master(prog_id)',
  `semester` tinyint(3) unsigned NOT NULL COMMENT 'The Semester for which it is'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Academic Calendar' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_academic_calendar_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_academic_calendar_INSERT` BEFORE INSERT ON `Academic_Calendar`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Academic_Calendar WHERE start_date=NEW.start_date AND end_date=NEW.end_date AND prog_id=NEW.prog_id AND semester=NEW.semester LIMIT 1);
IF @cnt<>0 THEN
SET NEW.ac_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Attendance`;
CREATE TABLE IF NOT EXISTS `Attendance` (
  `lec_id` bigint(20) unsigned NOT NULL COMMENT 'Primary Key & References Lectures(lec_id)',
  `stud_id` int(10) unsigned NOT NULL COMMENT 'Primary Key & References Student_Master(stud_id)',
  `presence` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0=Absent, 1=Present'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Attendance of Students';

DROP TABLE IF EXISTS `Attendance_Master`;
CREATE TABLE IF NOT EXISTS `Attendance_Master` (
`attd_mst_id` bigint(20) unsigned NOT NULL COMMENT 'Primary Key',
  `teaches_id` smallint(5) unsigned NOT NULL COMMENT 'References Teaches(teaches_id)',
  `batchno` varchar(3) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Batch Number for Labs',
  `division` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Division between A-Z',
  `ac_id` mediumint(8) unsigned NOT NULL COMMENT 'References Academic_Calendar(ac_id)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Attendance Master' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_attendance_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_attendance_master_INSERT` BEFORE INSERT ON `Attendance_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Attendance_Master WHERE teaches_id=NEW.teaches_id AND batchno=NEW.batchno AND division=NEW.division AND ac_id=NEW.ac_id LIMIT 1);
IF @cnt<>0 THEN
SET NEW.attd_mst_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Dept_Master`;
CREATE TABLE IF NOT EXISTS `Dept_Master` (
`dept_id` smallint(5) unsigned NOT NULL COMMENT 'Primary Key',
  `dept_name` varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Department Name such as Computer Engineering',
  `dept_code` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Department Code such as 07'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='List of Department/Branches' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_dept_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_dept_master_INSERT` BEFORE INSERT ON `Dept_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Dept_Master WHERE dept_name=NEW.dept_name OR dept_code=NEW.dept_code LIMIT 1);
IF @cnt<>0 THEN
SET NEW.dept_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Faculty_Master`;
CREATE TABLE IF NOT EXISTS `Faculty_Master` (
`faculty_id` smallint(5) unsigned NOT NULL COMMENT 'Primary Key',
  `faculty_name` varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Name of the Faculty',
  `faculty_father_name` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Name of the Father',
  `faculty_surname` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Surname of the Faculty',
  `faculty_designation` varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Designation of the faculty',
  `faculty_mail_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL COMMENT 'E-mail id of the faculty',
  `faculty_mobile` bigint(10) unsigned NOT NULL COMMENT 'Mobile number of the faculty',
  `faculty_address` varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Permanent Address of the faculty',
  `faculty_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active 0=Deactive',
  `faculty_joining_date` date DEFAULT NULL COMMENT 'Joining Date of the Faculty',
  `o_id` smallint(5) unsigned NOT NULL COMMENT 'References Offers_Master(o_id)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='List of Faculties' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_faculty_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_faculty_master_INSERT` BEFORE INSERT ON `Faculty_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Faculty_Master WHERE faculty_mobile=NEW.faculty_mobile LIMIT 1);
IF @cnt<>0 THEN
SET NEW.faculty_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Inst_Master`;
CREATE TABLE IF NOT EXISTS `Inst_Master` (
`inst_id` tinyint(3) unsigned NOT NULL COMMENT 'Primary Key',
  `inst_name` varchar(255) COLLATE latin1_general_ci NOT NULL COMMENT 'Institute Name',
  `inst_code` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Institute Code as per GTU',
  `inst_estb_year` smallint(4) DEFAULT NULL COMMENT 'Institute Established Year'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='List of Institutes' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_inst_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_inst_master_INSERT` BEFORE INSERT ON `Inst_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Inst_Master WHERE inst_name=NEW.inst_name OR inst_code=NEW.inst_code LIMIT 1);
IF @cnt<>0 THEN
SET NEW.inst_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Lectures`;
CREATE TABLE IF NOT EXISTS `Lectures` (
`lec_id` bigint(20) unsigned NOT NULL COMMENT 'Primary Key',
  `lec_date` date NOT NULL COMMENT 'Attendance Date',
  `attd_mst_id` bigint(20) unsigned NOT NULL COMMENT 'References Attendance_Master(attd_mst_id)',
  `active` TINYINT(1) NOT NULL DEFAULT '1',
  `last_updated_on` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last updated on',
  `last_updated_by` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_general_cs NULL DEFAULT NULL COMMENT 'Last updated by'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Lectures Conducted' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `Offers_Master`;
CREATE TABLE IF NOT EXISTS `Offers_Master` (
`o_id` smallint(5) unsigned NOT NULL COMMENT 'Primary Key',
  `inst_id` tinyint(3) unsigned NOT NULL COMMENT 'References Inst_Master(inst_id)',
  `prog_id` tinyint(3) unsigned NOT NULL COMMENT 'References Prog_Master(prog_id)',
  `dept_id` smallint(5) unsigned NOT NULL COMMENT 'References Dept_Master(dept_id)',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1=Active 0=Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Institute-Programme-Department mapping' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_offers_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_offers_master_INSERT` BEFORE INSERT ON `Offers_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Offers_Master WHERE inst_id=NEW.inst_id AND prog_id=NEW.prog_id AND dept_id=NEW.dept_id LIMIT 1);
IF @cnt<>0 THEN
SET NEW.o_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Privilege_Master`;
CREATE TABLE IF NOT EXISTS `Privilege_Master` (
`privilege_id` tinyint(3) unsigned NOT NULL COMMENT 'Primary Key',
  `privilege_name` varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Type of Account: admin,hod',
  `faculty_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Faculty_Master',
  `inst_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Inst_Master',
  `prog_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Prog_Master',
  `dept_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Dept_Master',
  `academic_calendar_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Academic_Calendar',
  `attendance_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Attendance_Master',
  `student_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Student_Master',
  `sub_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Sub_Master',
  `user_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to User_Master',
  `privilege_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Privilege_Master',
  `offers_master_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Offers Relation',
  `syllabus_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Syllabus Relation',
  `teaches_access` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '100' COMMENT 'R/A/M Rights to Teaches Relation',
  `reports` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Access Privileges' AUTO_INCREMENT=2 ;

INSERT INTO `Privilege_Master` (`privilege_id`, `privilege_name`, `faculty_master_access`, `inst_master_access`, `prog_master_access`, `dept_master_access`, `academic_calendar_access`, `attendance_master_access`, `student_master_access`, `sub_master_access`, `user_master_access`, `privilege_master_access`, `offers_master_access`, `syllabus_access`, `teaches_access`, `reports`) VALUES
(1, 'admin', '111', '111', '111', '111', '111', '111', '111', '111', '111', '111', '111', '111', '111', '1');
DROP TRIGGER IF EXISTS `BEFORE_privilege_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_privilege_master_INSERT` BEFORE INSERT ON `Privilege_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Privilege_Master WHERE privilege_name=NEW.privilege_name LIMIT 1);
IF @cnt<>0 THEN
SET NEW.privilege_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Prog_Master`;
CREATE TABLE IF NOT EXISTS `Prog_Master` (
`prog_id` tinyint(3) unsigned NOT NULL COMMENT 'Primary Key',
  `prog_name` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'Program Name such as Bachlor of Engineering',
  `no_of_sem` tinyint(3) unsigned NOT NULL COMMENT 'Number of sem in the program',
  `prog_short_name` varchar(15) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Abbreviation of the Program such as ME,BE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='List of Programmes' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_prog_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_prog_master_INSERT` BEFORE INSERT ON `Prog_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Prog_Master WHERE prog_name=NEW.prog_name LIMIT 1);
IF @cnt<>0 THEN
SET NEW.prog_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Student_Master`;
CREATE TABLE IF NOT EXISTS `Student_Master` (
`stud_id` int(10) unsigned NOT NULL COMMENT 'Primary Key',
  `stud_enrolmentno` char(15) COLLATE latin1_general_ci NOT NULL COMMENT 'Student Enrolment Number',
  `stud_rollno` char(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Student Roll Number',
  `stud_name` varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Student Name',
  `stud_father_name` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Student Father Name',
  `stud_surname` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Student Surname',
  `stud_mail` varchar(50) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Student E-Mail Id',
  `stud_contact` bigint(10) DEFAULT NULL COMMENT 'Student Contact Number',
  `stud_parent_contact` bigint(10) DEFAULT NULL COMMENT 'Student Parent Contact Number',
  `stud_address` varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Student Permanent Address',
  `stud_city` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'City',
  `stud_sem` tinyint(3) unsigned NOT NULL COMMENT 'Student Current Sem',
  `stud_status` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'C' COMMENT 'D=Detain L=Left C=Continue A=Alumni',
  `o_id` smallint(5) unsigned NOT NULL COMMENT 'Inst-Prog-Branch of the Student References Offers_Master(o_id)',
  `stud_div` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Division between A-Z',
  `stud_batchno` varchar(3) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Batch Number for Lab'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Student Details' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_student_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_student_master_INSERT` BEFORE INSERT ON `Student_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Student_Master WHERE stud_enrolmentno=NEW.stud_enrolmentno OR stud_rollno=NEW.stud_rollno LIMIT 1);
IF @cnt<>0 THEN
SET NEW.stud_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Sub_Master`;
CREATE TABLE IF NOT EXISTS `Sub_Master` (
`sub_id` smallint(5) unsigned NOT NULL COMMENT 'Primary Key',
  `sub_code` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Subject Code as per GTU',
  `sub_name` varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Subject Name',
  `sub_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active 0=Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='List of Subjects' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_sub_master_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_sub_master_INSERT` BEFORE INSERT ON `Sub_Master`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Sub_Master WHERE sub_code=NEW.sub_code LIMIT 1);
IF @cnt<>0 THEN
SET NEW.sub_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Syllabus`;
CREATE TABLE IF NOT EXISTS `Syllabus` (
`syllabus_id` smallint(5) unsigned NOT NULL COMMENT 'Primary Key',
  `o_id` smallint(5) unsigned NOT NULL COMMENT 'References Offers_Master(o_id)',
  `sub_id` smallint(5) unsigned NOT NULL COMMENT 'References Sub_Master(sub_id)',
  `sub_offered_sem` tinyint(3) unsigned NOT NULL COMMENT 'Semester in which subject is offered',
  `sub_type` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'R' COMMENT 'R=Regular E=Elective'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Subject & Offers_Master Mapping' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_syllabus_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_syllabus_INSERT` BEFORE INSERT ON `Syllabus`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Syllabus WHERE sub_id=NEW.sub_id AND o_id=NEW.o_id AND sub_offered_sem=NEW.sub_offered_sem AND sub_type=NEW.sub_type LIMIT 1);
IF @cnt<>0 THEN
SET NEW.syllabus_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `Teaches`;
CREATE TABLE IF NOT EXISTS `Teaches` (
`teaches_id` smallint(5) unsigned NOT NULL COMMENT 'Primary Key',
  `faculty_id` smallint(5) unsigned NOT NULL COMMENT 'References Faculty_Master(faculty_id)',
  `syllabus_id` smallint(5) unsigned NOT NULL COMMENT 'References Syllabus(syllabus_id)',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0=Lecture 1=Lab'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Faculty & Syllabus Mapping' AUTO_INCREMENT=1 ;
DROP TRIGGER IF EXISTS `BEFORE_teaches_INSERT`;
DELIMITER //
CREATE TRIGGER `BEFORE_teaches_INSERT` BEFORE INSERT ON `Teaches`
 FOR EACH ROW BEGIN
SET @cnt=(SELECT count(*) FROM Teaches WHERE faculty_id=NEW.faculty_id AND syllabus_id=NEW.syllabus_id AND type=NEW.type LIMIT 1);
IF @cnt<>0 THEN
SET NEW.teaches_id=1;
END IF;
END
//
DELIMITER ;

DROP TABLE IF EXISTS `User_Master`;
CREATE TABLE IF NOT EXISTS `User_Master` (
  `user_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'Primary Key',
  `email_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL COMMENT 'Email Id of the user',
  `enc_algo` tinyint(3) NOT NULL COMMENT 'Hashing/Encryption Algorithm',
  `salt_type` tinyint(1) NOT NULL COMMENT 'Salt type',
  `salt` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'Salt',
  `user_password` varchar(128) COLLATE latin1_general_ci NOT NULL COMMENT 'Salted hashed password',
  `user_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Status of User: 1=Unlocked 0=Locked',
  `user_creation_date` datetime NOT NULL COMMENT 'Date when user was created',
  `user_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last updated on',
  `faculty_id` smallint(5) unsigned DEFAULT NULL COMMENT 'References Faculty_Master(faculty_id)',
  `privilege_id` tinyint(3) unsigned NOT NULL COMMENT 'References Privilege_Master(privilege_id)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='User Accounts Table';

INSERT INTO `User_Master` (`user_name`, `email_id`, `enc_algo`, `salt_type`, `salt`, `user_password`, `user_status`, `user_creation_date`, `user_update_date`, `faculty_id`, `privilege_id`) VALUES
('admin', 'admin@salam.com', 1, 1, '1024823780535d64ce7fd332.53283497', '9eb62f5887240a9bd354d1a8a5d7d5ff863158184282c655c5334b7cf500e40b81cd46f7c6d808fb13b03c2bb04bfba0b55896f9c98931fab39cb2bd34b5c10e', 1, '2014-04-28 01:43:02', '2014-04-27 20:13:02', NULL, 1),
('developer', 'chirayu.chiripal@gmail.com', 1, 1, '5502270520611a146ed63.60627028', '5bfa6548ed74bfe9bb8396e52d10222ca274eb8376a2b24d323a7a5a7cd5c368f1f1c2163cca172a6f836d727c7a77fa4e7ced9ff0a53caf120071f15604ed75', 0, '2013-09-22 00:00:00', '2014-02-07 11:32:25', NULL, 1);


ALTER TABLE `Academic_Calendar`
 ADD PRIMARY KEY (`ac_id`), ADD UNIQUE KEY `acd_already_exists` (`start_date`,`end_date`,`prog_id`,`semester`), ADD KEY `fk_acd` (`prog_id`);

ALTER TABLE `Attendance`
 ADD PRIMARY KEY (`lec_id`,`stud_id`), ADD KEY `fk_abs_stu` (`stud_id`);

ALTER TABLE `Attendance_Master`
 ADD PRIMARY KEY (`attd_mst_id`), ADD UNIQUE KEY `attd_mst_id` (`attd_mst_id`), ADD UNIQUE KEY `master_already_exists` (`teaches_id`,`batchno`,`division`,`ac_id`), ADD KEY `fk_attd_acd` (`ac_id`);

ALTER TABLE `Dept_Master`
 ADD PRIMARY KEY (`dept_id`), ADD UNIQUE KEY `dept_name` (`dept_name`), ADD UNIQUE KEY `dept_code` (`dept_code`);

ALTER TABLE `Faculty_Master`
 ADD PRIMARY KEY (`faculty_id`), ADD UNIQUE KEY `faculty_mobile` (`faculty_mobile`), ADD KEY `fk_dept_faculty` (`o_id`);

ALTER TABLE `Inst_Master`
 ADD PRIMARY KEY (`inst_id`), ADD UNIQUE KEY `inst_name` (`inst_name`), ADD UNIQUE KEY `inst_code` (`inst_code`);

ALTER TABLE `Lectures`
 ADD PRIMARY KEY (`lec_id`), ADD UNIQUE KEY `lec_id` (`lec_id`), ADD KEY `fk_lec_mst` (`attd_mst_id`);

ALTER TABLE `Offers_Master`
 ADD PRIMARY KEY (`o_id`), ADD UNIQUE KEY `om_already_exists` (`inst_id`,`prog_id`,`dept_id`), ADD KEY `fk_om_prog` (`prog_id`), ADD KEY `fk_om_dept` (`dept_id`);

ALTER TABLE `Privilege_Master`
 ADD PRIMARY KEY (`privilege_id`), ADD UNIQUE KEY `privilege_name` (`privilege_name`);

ALTER TABLE `Prog_Master`
 ADD PRIMARY KEY (`prog_id`), ADD UNIQUE KEY `prog_name` (`prog_name`);

ALTER TABLE `Student_Master`
 ADD PRIMARY KEY (`stud_id`), ADD UNIQUE KEY `stud_enrolmentno` (`stud_enrolmentno`), ADD UNIQUE KEY `stud_rollno` (`stud_rollno`), ADD KEY `fk_stud` (`o_id`);

ALTER TABLE `Sub_Master`
 ADD PRIMARY KEY (`sub_id`), ADD UNIQUE KEY `sub_code` (`sub_code`);

ALTER TABLE `Syllabus`
 ADD PRIMARY KEY (`syllabus_id`), ADD UNIQUE KEY `syl_already_exists` (`o_id`,`sub_id`,`sub_offered_sem`,`sub_type`), ADD KEY `fk_syl_sub` (`sub_id`);

ALTER TABLE `Teaches`
 ADD PRIMARY KEY (`teaches_id`), ADD UNIQUE KEY `teaches_already_exists` (`faculty_id`,`syllabus_id`,`type`), ADD KEY `fk_teaches_syllabus` (`syllabus_id`);

ALTER TABLE `User_Master`
 ADD PRIMARY KEY (`user_name`), ADD UNIQUE KEY `user_name` (`user_name`), ADD UNIQUE KEY `email_id` (`email_id`), ADD UNIQUE KEY `faculty_id` (`faculty_id`), ADD KEY `fk_priv` (`privilege_id`);


ALTER TABLE `Academic_Calendar`
MODIFY `ac_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Attendance_Master`
MODIFY `attd_mst_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Dept_Master`
MODIFY `dept_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Faculty_Master`
MODIFY `faculty_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Inst_Master`
MODIFY `inst_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Lectures`
MODIFY `lec_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Offers_Master`
MODIFY `o_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Privilege_Master`
MODIFY `privilege_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',AUTO_INCREMENT=2;
ALTER TABLE `Prog_Master`
MODIFY `prog_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Student_Master`
MODIFY `stud_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Sub_Master`
MODIFY `sub_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Syllabus`
MODIFY `syllabus_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
ALTER TABLE `Teaches`
MODIFY `teaches_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

ALTER TABLE `Academic_Calendar`
ADD CONSTRAINT `fk_acd` FOREIGN KEY (`prog_id`) REFERENCES `Prog_Master` (`prog_id`);

ALTER TABLE `Attendance`
ADD CONSTRAINT `fk_abs_lec` FOREIGN KEY (`lec_id`) REFERENCES `Lectures` (`lec_id`),
ADD CONSTRAINT `fk_abs_stu` FOREIGN KEY (`stud_id`) REFERENCES `Student_Master` (`stud_id`);

ALTER TABLE `Attendance_Master`
ADD CONSTRAINT `fk_attd_acd` FOREIGN KEY (`ac_id`) REFERENCES `Academic_Calendar` (`ac_id`),
ADD CONSTRAINT `fk_attd_tch` FOREIGN KEY (`teaches_id`) REFERENCES `Teaches` (`teaches_id`);

ALTER TABLE `Faculty_Master`
ADD CONSTRAINT `fk_dept_faculty` FOREIGN KEY (`o_id`) REFERENCES `Offers_Master` (`o_id`);

ALTER TABLE `Lectures`
ADD CONSTRAINT `fk_lec_mst` FOREIGN KEY (`attd_mst_id`) REFERENCES `Attendance_Master` (`attd_mst_id`);

ALTER TABLE `Offers_Master`
ADD CONSTRAINT `fk_om_dept` FOREIGN KEY (`dept_id`) REFERENCES `Dept_Master` (`dept_id`),
ADD CONSTRAINT `fk_om_inst` FOREIGN KEY (`inst_id`) REFERENCES `Inst_Master` (`inst_id`),
ADD CONSTRAINT `fk_om_prog` FOREIGN KEY (`prog_id`) REFERENCES `Prog_Master` (`prog_id`);

ALTER TABLE `Student_Master`
ADD CONSTRAINT `fk_stud` FOREIGN KEY (`o_id`) REFERENCES `Offers_Master` (`o_id`);

ALTER TABLE `Syllabus`
ADD CONSTRAINT `fk_syl_offer` FOREIGN KEY (`o_id`) REFERENCES `Offers_Master` (`o_id`),
ADD CONSTRAINT `fk_syl_sub` FOREIGN KEY (`sub_id`) REFERENCES `Sub_Master` (`sub_id`);

ALTER TABLE `Teaches`
ADD CONSTRAINT `fk_teaches_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `Faculty_Master` (`faculty_id`),
ADD CONSTRAINT `fk_teaches_syllabus` FOREIGN KEY (`syllabus_id`) REFERENCES `Syllabus` (`syllabus_id`);

ALTER TABLE `User_Master`
ADD CONSTRAINT `fk_priv` FOREIGN KEY (`privilege_id`) REFERENCES `Privilege_Master` (`privilege_id`),
ADD CONSTRAINT `fk_user` FOREIGN KEY (`faculty_id`) REFERENCES `Faculty_Master` (`faculty_id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
