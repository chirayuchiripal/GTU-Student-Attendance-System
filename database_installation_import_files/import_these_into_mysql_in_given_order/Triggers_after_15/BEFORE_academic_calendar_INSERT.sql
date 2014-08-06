# Before Insert Trigger - Academic_Calendar : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_academic_calendar_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_academic_calendar_INSERT BEFORE INSERT ON Academic_Calendar FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Academic_Calendar WHERE start_date=NEW.start_date AND end_date=NEW.end_date AND prog_id=NEW.prog_id AND semester=NEW.semester LIMIT 1);
IF @cnt<>0 THEN
SET NEW.ac_id=1;
END IF;
END//

DELIMITER ;