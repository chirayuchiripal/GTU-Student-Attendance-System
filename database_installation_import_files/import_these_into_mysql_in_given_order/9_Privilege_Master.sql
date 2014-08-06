# 10/08/2013 - Updated Names as per Tables
create table Privilege_Master
(	privilege_id tinyint(3) unsigned auto_increment not null comment 'Primary Key',
	privilege_name varchar(30) not null unique comment 'Type of Account: admin,hod',
	faculty_master_access char(3) not null default '100' comment 'R/A/M Rights to Faculty_Master',
	inst_master_access char(3) not null default '100' comment 'R/A/M Rights to Inst_Master',
	prog_master_access char(3) not null default '100' comment 'R/A/M Rights to Prog_Master',
	dept_master_access char(3) not null default '100' comment 'R/A/M Rights to Dept_Master',
	academic_calendar_access char(3) not null default '100' comment 'R/A/M Rights to Academic_Calendar',
	attendance_master_access char(3) not null default '100' comment 'R/A/M Rights to Attendance_Master',
	student_master_access char(3) not null default '100' comment 'R/A/M Rights to Student_Master',
	sub_master_access char(3) not null default '100' comment 'R/A/M Rights to Sub_Master',
	user_master_access char(3) not null default '100' comment 'R/A/M Rights to User_Master',
	privilege_master_access char(3) not null default '100' comment 'R/A/M Rights to Privilege_Master',
	offers_master_access char(3) not null default '100' comment 'R/A/M Rights to Offers Relation',
	syllabus_access char(3) not null default '100' comment 'R/A/M Rights to Syllabus Relation',
	teaches_access char(3) not null default '100' comment 'R/A/M Rights to Teaches Relation',
	PRIMARY KEY(privilege_id)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Access Privileges';