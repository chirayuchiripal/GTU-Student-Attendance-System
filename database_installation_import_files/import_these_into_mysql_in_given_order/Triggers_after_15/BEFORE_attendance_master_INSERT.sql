# Before Insert Trigger - Attendance_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_attendance_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_attendance_master_INSERT BEFORE INSERT ON Attendance_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Attendance_Master WHERE teaches_id=NEW.teaches_id AND batchno=NEW.batchno AND division=NEW.division AND ac_id=NEW.ac_id LIMIT 1);
IF @cnt<>0 THEN
SET NEW.attd_mst_id=1;
END IF;
END//

DELIMITER ;