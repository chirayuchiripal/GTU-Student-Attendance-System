# Before Insert Trigger - Prog_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_prog_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_prog_master_INSERT BEFORE INSERT ON Prog_Master
FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Prog_Master WHERE prog_name=NEW.prog_name LIMIT 1);
IF @cnt<>0 THEN
SET NEW.prog_id=1;
END IF;
END//

DELIMITER ;



# test
## Removed/Deprecated
#BEGIN
#SET @cnt=(SELECT count(*) FROM prog_master WHERE prog_name=NEW.prog_name LIMIT 1);
#IF @cnt<>0 THEN
#SET @MSG = CONCAT('Programme Name: ',NEW.prog_name,' already exists!!');
#SIGNAL SQLSTATE '45000' SET message_text = @msg;
#END IF;
#END