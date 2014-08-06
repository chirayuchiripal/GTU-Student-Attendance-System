# 05/04/2014 - Updated as per new Design
create table Attendance
(	lec_id bigint unsigned not null comment 'Primary Key & References Lectures(lec_id)',
	stud_id int unsigned not null comment 'Primary Key & References Student_Master(stud_id)',
	presence tinyint(1) unsigned not null default 0 comment '0=Absent, 1=Present',
	CONSTRAINT pk_abs PRIMARY KEY(lec_id,stud_id),
	CONSTRAINT fk_abs_stu FOREIGN KEY(stud_id) REFERENCES Student_Master(stud_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT fk_abs_lec FOREIGN KEY(lec_id) REFERENCES Lectures(lec_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Attendance of Students';