# Before Insert Trigger - Student_Master : To check duplicate record
# Purpose : Avoid Gaps in Auto-Increment to avoid it getting exhausted and force it to be consecutive


DROP TRIGGER IF EXISTS BEFORE_student_master_INSERT;

DELIMITER //

CREATE TRIGGER BEFORE_student_master_INSERT BEFORE INSERT ON Student_Master FOR EACH ROW 
BEGIN
SET @cnt=(SELECT count(*) FROM Student_Master WHERE stud_enrolmentno=NEW.stud_enrolmentno OR stud_rollno=NEW.stud_rollno LIMIT 1);
IF @cnt<>0 THEN
SET NEW.stud_id=1;
END IF;
END//

DELIMITER ;