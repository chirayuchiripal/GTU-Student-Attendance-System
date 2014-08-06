# 22/09/2013 - Added as per new design
create table Syllabus
(	syllabus_id smallint(5) unsigned auto_increment not null comment 'Primary Key',
	o_id smallint(5) unsigned not null comment 'References Offers_Master(o_id)',
	sub_id smallint unsigned not null comment 'References Sub_Master(sub_id)',
	sub_offered_sem tinyint unsigned not null comment 'Semester in which subject is offered',
	sub_type varchar(1) not null default 'R' comment 'R=Regular E=Elective',
	CONSTRAINT pk_syl PRIMARY KEY(syllabus_id),
	CONSTRAINT fk_syl_offer FOREIGN KEY(o_id) REFERENCES Offers_Master(o_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT fk_syl_sub FOREIGN KEY(sub_id) REFERENCES Sub_Master(sub_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT syl_already_exists UNIQUE(o_id,sub_id,sub_offered_sem,sub_type)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Subject & Offers_Master Mapping';
