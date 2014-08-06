# Before Insert Trigger - Syllabus : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_syllabus_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_syllabus_INSERT BEFORE INSERT ON Syllabus FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Syllabus WHERE sub_id=NEW.sub_id AND o_id=NEW.o_id AND sub_offered_sem=NEW.sub_offered_sem AND sub_type=NEW.sub_type LIMIT 1);
IF @cnt<>0 THEN
SET NEW.syllabus_id=1;
END IF;
END//

DELIMITER ;