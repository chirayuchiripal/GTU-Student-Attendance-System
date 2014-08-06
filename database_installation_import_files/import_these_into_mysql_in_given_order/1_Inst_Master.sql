# 22/09/2013 - Updated as per new design
create table Inst_Master
(	inst_id tinyint(3) unsigned auto_increment not null comment 'Primary Key',
	inst_name varchar(255) not null unique comment 'Institute Name',
	inst_code varchar(10) not null unique comment 'Institute Code as per GTU',
	inst_estb_year smallint(4) comment 'Institute Established Year',
	PRIMARY KEY(inst_id)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'List of Institutes';
