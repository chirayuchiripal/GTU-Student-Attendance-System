# 17/06/2013 - Updated as per new design
create table User_Master
(	user_name varchar(50) not null unique comment 'Primary Key' COLLATE latin1_general_cs,
	email_id varchar(50) not null unique comment 'Email Id of the user' COLLATE latin1_general_cs,
	enc_algo tinyint(3) not null comment 'Hashing/Encryption Algorithm',
	salt_type tinyint(1) not null comment 'Salt type',
	salt varchar(50) not null comment 'Salt',
	user_password varchar(128) not null comment 'Salted hashed password',
	user_status tinyint(1) not null default 1 comment 'Status of User: 1=Unlocked 0=Locked',
	user_creation_date datetime not null comment 'Date when user was created',
	user_update_date timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment 'Last updated on',
	faculty_id smallint(5) unsigned unique comment 'References Faculty_Master(faculty_id)',
	privilege_id tinyint(3) unsigned not null comment 'References Privilege_Master(privilege_id)',
	CONSTRAINT pk_user PRIMARY KEY(user_name),
	CONSTRAINT fk_user FOREIGN KEY(faculty_id) REFERENCES Faculty_Master(faculty_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT fk_priv FOREIGN KEY(privilege_id) REFERENCES Privilege_Master(privilege_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB COLLATE latin1_general_ci COMMENT 'User Accounts Table';