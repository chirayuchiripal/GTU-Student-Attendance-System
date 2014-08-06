# 22/09/2013 : Added New Table
create table Lectures
(	lec_id serial comment 'Primary Key',
	lec_date date not null comment 'Attendance Date',
	attd_mst_id bigint unsigned not null comment 'References Attendance_Master(attd_mst_id)',
	CONSTRAINT pk_lec PRIMARY KEY(lec_id),
	CONSTRAINT fk_lec_mst FOREIGN KEY(attd_mst_id) REFERENCES Attendance_Master(attd_mst_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Lectures Conducted';