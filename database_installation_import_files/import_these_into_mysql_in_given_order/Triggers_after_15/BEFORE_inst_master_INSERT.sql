# Before Insert Trigger - Inst_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_inst_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_inst_master_INSERT BEFORE INSERT ON Inst_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Inst_Master WHERE inst_name=NEW.inst_name OR inst_code=NEW.inst_code LIMIT 1);
IF @cnt<>0 THEN
SET NEW.inst_id=1;
END IF;
END//

DELIMITER ;