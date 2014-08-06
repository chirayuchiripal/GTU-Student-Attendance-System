# Before Insert Trigger - Privilege_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_privilege_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_privilege_master_INSERT BEFORE INSERT ON Privilege_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Privilege_Master WHERE privilege_name=NEW.privilege_name LIMIT 1);
IF @cnt<>0 THEN
SET NEW.privilege_id=1;
END IF;
END//

DELIMITER ;