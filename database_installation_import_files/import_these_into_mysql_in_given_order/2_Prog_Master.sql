# 17/06/2013 - Updated as per new design
create table Prog_Master
(	prog_id tinyint(3) unsigned auto_increment not null comment 'Primary Key',
	prog_name varchar(50) not null unique comment 'Program Name such as Bachlor of Engineering',
	no_of_sem tinyint unsigned not null comment 'Number of sem in the program',
	prog_short_name varchar(15) comment 'Abbreviation of the Program such as ME,BE',
	PRIMARY KEY(prog_id)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'List of Programmes';