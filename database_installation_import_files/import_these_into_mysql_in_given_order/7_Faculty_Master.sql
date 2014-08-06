# 22/09/2013 - Updated as per new design
create table Faculty_Master
(	faculty_id smallint(5) unsigned auto_increment not null comment 'Primary Key',
	faculty_name varchar(30) not null comment 'Name of the Faculty',
	faculty_father_name varchar(30) comment 'Name of the Father',
	faculty_surname varchar(30) comment 'Surname of the Faculty',
	faculty_designation varchar(30) not null comment 'Designation of the faculty',
	faculty_mail_id varchar(50) comment 'E-mail id of the faculty' COLLATE latin1_general_cs,
	faculty_mobile bigint(10) unsigned not null unique comment 'Mobile number of the faculty',
	faculty_address varchar(100) comment 'Permanent Address of the faculty',
	faculty_status tinyint(1) not null default 1 comment '1=Active 0=Deactive',
	faculty_joining_date date comment 'Joining Date of the Faculty',
	o_id smallint(5) unsigned not null comment 'References Offers_Master(o_id)',
	CONSTRAINT pk_faculty PRIMARY KEY(faculty_id),
	CONSTRAINT fk_dept_faculty FOREIGN KEY(o_id) REFERENCES Offers_Master(o_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'List of Faculties';