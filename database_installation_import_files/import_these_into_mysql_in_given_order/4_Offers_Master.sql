# 22/09/2013 - Added as per new design
create table Offers_Master
(	o_id smallint(5) unsigned auto_increment not null comment 'Primary Key',
	inst_id tinyint(3) unsigned not null comment 'References Inst_Master(inst_id)',
	prog_id tinyint(3) unsigned not null comment 'References Prog_Master(prog_id)',
	dept_id smallint(5) unsigned not null comment 'References Dept_Master(dept_id)',
	active tinyint(1) unsigned not null default 1 COMMENT '1=Active 0=Deactive',
	CONSTRAINT pk_om PRIMARY KEY(o_id),
	CONSTRAINT fk_om_inst FOREIGN KEY(inst_id) REFERENCES Inst_Master(inst_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT fk_om_prog FOREIGN KEY(prog_id) REFERENCES Prog_Master(prog_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT fk_om_dept FOREIGN KEY(dept_id) REFERENCES Dept_Master(dept_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT om_already_exists UNIQUE(inst_id,prog_id,dept_id)
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'Institute-Programme-Department mapping';