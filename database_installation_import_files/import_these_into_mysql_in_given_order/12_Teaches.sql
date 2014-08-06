# 22/09/2013 - Updated as per new design
create table Teaches
(	teaches_id smallint(5) unsigned auto_increment not null comment 'Primary Key',
	faculty_id smallint(5) unsigned not null comment 'References Faculty_Master(faculty_id)',
	syllabus_id smallint(5) unsigned not null comment 'References Syllabus(syllabus_id)',
	type tinyint(1) unsigned not null default 0 COMMENT '0=Lecture 1=Lab',
	CONSTRAINT pk_teaches PRIMARY KEY(teaches_id),
	CONSTRAINT fk_teaches_faculty FOREIGN KEY(faculty_id) REFERENCES Faculty_Master(faculty_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT fk_teaches_syllabus FOREIGN KEY(syllabus_id) REFERENCES Syllabus(syllabus_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT teaches_already_exists UNIQUE(faculty_id,syllabus_id,type)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Faculty & Syllabus Mapping';
