# Before Insert Trigger - Sub_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_sub_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_sub_master_INSERT BEFORE INSERT ON Sub_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Sub_Master WHERE sub_code=NEW.sub_code LIMIT 1);
IF @cnt<>0 THEN
SET NEW.sub_id=1;
END IF;
END//

DELIMITER ;