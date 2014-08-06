# 17/06/2013 - Updated as per new design
create table Academic_Calendar
(	ac_id mediumint unsigned auto_increment not null comment 'Primary Key',
	start_date date not null comment 'Starting Date',
	end_date date not null comment 'Ending Date',
	prog_id tinyint(3) unsigned not null comment 'References Prog_Master(prog_id)',
	semester tinyint unsigned not null comment 'The Semester for which it is',
	PRIMARY KEY(ac_id),
	CONSTRAINT fk_acd FOREIGN KEY(prog_id) REFERENCES Prog_Master(prog_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT acd_already_exists UNIQUE(start_date,end_date,prog_id,semester)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Academic Calendar';