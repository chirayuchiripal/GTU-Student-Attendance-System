# Procedure : student_presence_from_master
# Purpose : Returns student presence given a master id. Returns (stud_id,presence,total,percentage)

DROP PROCEDURE IF Exists student_presence_from_master;

DELIMITER //

create procedure student_presence_from_master(IN mst_id BIGINT UNSIGNED)
BEGIN
select division,batchno from Attendance_Master where attd_mst_id = mst_id;
select Attendance.stud_id,CONCAT(stud_name,' ',stud_father_name,' ',stud_surname) as stud_name,stud_rollno,stud_enrolmentno,sum(presence) as presence,count(presence) as total,ROUND((sum(presence) / count(presence))*100,2) as percentage from Attendance 
join Student_Master
on Student_Master.stud_id = Attendance.stud_id
where lec_id in(select lec_id from Lectures where attd_mst_id=mst_id) group by Attendance.stud_id order by stud_rollno ASC;
END//

DELIMITER ;