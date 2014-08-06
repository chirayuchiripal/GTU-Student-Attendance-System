# Before Insert Trigger - Teaches : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_teaches_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_teaches_INSERT BEFORE INSERT ON Teaches FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Teaches WHERE faculty_id=NEW.faculty_id AND syllabus_id=NEW.syllabus_id AND type=NEW.type LIMIT 1);
IF @cnt<>0 THEN
SET NEW.teaches_id=1;
END IF;
END//

DELIMITER ;