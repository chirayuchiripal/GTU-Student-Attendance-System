# 22/09/2013 - Updated as per new design
create table Sub_Master
(	sub_id smallint unsigned auto_increment not null comment 'Primary Key',
	sub_code varchar(10) not null unique comment 'Subject Code as per GTU',
	sub_name varchar(30) not null comment 'Subject Name',
	sub_status tinyint(1) not null default 1 comment '1=Active 0=Deactive',
	PRIMARY KEY(sub_id)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'List of Subjects';