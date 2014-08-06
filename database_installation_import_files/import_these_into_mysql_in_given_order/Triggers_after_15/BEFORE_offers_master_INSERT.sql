# Before Insert Trigger - Offers_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_offers_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_offers_master_INSERT BEFORE INSERT ON Offers_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Offers_Master WHERE inst_id=NEW.inst_id AND prog_id=NEW.prog_id AND dept_id=NEW.dept_id LIMIT 1);
IF @cnt<>0 THEN
SET NEW.o_id=1;
END IF;
END//

DELIMITER ;