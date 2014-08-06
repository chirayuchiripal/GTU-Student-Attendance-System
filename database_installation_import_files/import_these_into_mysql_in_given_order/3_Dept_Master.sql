# 22/09/2013 - Updated as per new design
create table Dept_Master
(	dept_id smallint(5) unsigned auto_increment not null comment 'Primary Key',
	dept_name varchar(100) not null unique comment 'Department Name such as Computer Engineering',
	dept_code varchar(10) not null unique comment 'Department Code such as 07',
	PRIMARY KEY(dept_id)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'List of Department/Branches';