# 22/09/2013 - Normalized - Removed Anomaly
create table Attendance_Master
(	attd_mst_id serial comment 'Primary Key',
	teaches_id smallint(5) unsigned not null comment 'References Teaches(teaches_id)',
	batchno varchar(3) not null default '' comment 'Batch Number for Labs',
	division varchar(1) not null default '' comment 'Division between A-Z',
	ac_id mediumint unsigned not null comment 'References Academic_Calendar(ac_id)',
	CONSTRAINT pk_attd PRIMARY KEY(attd_mst_id),
	CONSTRAINT fk_attd_acd FOREIGN KEY(ac_id) REFERENCES Academic_Calendar(ac_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT fk_attd_tch FOREIGN KEY(teaches_id) REFERENCES Teaches(teaches_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT master_already_exists UNIQUE(teaches_id,batchno,division,ac_id)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Attendance Master';