# Before Insert Trigger - Faculty_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_faculty_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_faculty_master_INSERT BEFORE INSERT ON Faculty_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Faculty_Master WHERE faculty_mobile=NEW.faculty_mobile LIMIT 1);
IF @cnt<>0 THEN
SET NEW.faculty_id=1;
END IF;
END//

DELIMITER ;