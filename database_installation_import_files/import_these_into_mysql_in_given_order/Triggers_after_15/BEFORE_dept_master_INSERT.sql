# Before Insert Trigger - Dept_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_dept_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_dept_master_INSERT BEFORE INSERT ON Dept_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Dept_Master WHERE dept_name=NEW.dept_name OR dept_code=NEW.dept_code LIMIT 1);
IF @cnt<>0 THEN
SET NEW.dept_id=1;
END IF;
END//

DELIMITER ;