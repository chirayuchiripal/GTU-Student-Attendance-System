# 17/06/2013 - Updated as per new design
create table Student_Master
(	stud_id int unsigned auto_increment not null comment 'Primary Key',
	stud_enrolmentno char(15) not null unique comment 'Student Enrolment Number',
	stud_rollno char(10) not null unique comment 'Student Roll Number',
	stud_name varchar(30) not null comment 'Student Name',
	stud_father_name varchar(30) comment 'Student Father Name',
	stud_surname varchar(30) comment 'Student Surname',
	stud_mail varchar(50) comment 'Student E-Mail Id',
	stud_contact bigint(10) comment 'Student Contact Number',
	stud_parent_contact bigint(10) comment 'Student Parent Contact Number',
	stud_address varchar(100) comment 'Student Permanent Address',
	stud_city varchar(30) comment 'City',
	stud_sem tinyint unsigned not null comment 'Student Current Sem',
	stud_status varchar(1) not null default 'C' comment 'D=Detain L=Left C=Continue A=Alumni',
	o_id smallint(5) unsigned not null comment 'Inst-Prog-Branch of the Student References Offers_Master(o_id)',
	stud_div varchar(1) not null default '' comment 'Division between A-Z',
	stud_batchno varchar(3) not null default '' comment 'Batch Number for Lab',
	PRIMARY KEY(stud_id),
	CONSTRAINT fk_stud FOREIGN KEY(o_id) REFERENCES Offers_Master(o_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Student Details';