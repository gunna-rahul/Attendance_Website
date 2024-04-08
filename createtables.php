<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . "/attendanceapp/database/database.php";
function clearTable($dbo, $tabName)
{
  $c = "delete from :tabname";
  $s = $dbo->conn->prepare($c);
  try {
    $s->execute([":tabname" => $tabName]);
  } catch (PDOException $oo) {
  }
}

$dbo = new Database();
$c = "create table student_details
(
    id int auto_increment primary key,
    roll_no varchar(20) unique,
    name varchar(50)
)";
$s = $dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>student_details created");
} catch (PDOException $o) {
    echo("<br>student_details not created");
}

$c = "create table course_details
(
    id int auto_increment primary key,
    code varchar(20) unique,
    title varchar(50),
    credit int
)";
$s = $dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>course_details created");
} catch (PDOException $o) {
    echo("<br>course_details not created");
}

$c = "create table faculty_details
(
    id int auto_increment primary key,
    user_name varchar(20) unique,
    name varchar(100),
    password varchar(50)
)";
$s = $dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>faculty_details created");
} catch (PDOException $o) {
    echo("<br>faculty_details not created");
}

$c = "create table session_details
(
    id int auto_increment primary key,
    year int,
    term varchar(50),
    unique(year,term)
)";
$s = $dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>session_details created");
} catch (PDOException $o) {
    echo("<br>session_details not created");
}

$c = "create table course_registration
(
    student_id int,
    course_id int,
    session_id int,
    primary key (student_id,course_id,session_id)
)";
$s = $dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>course_registration created");
} catch (PDOException $o) {
    echo("<br>course_registration not created");
}

$c = "create table course_allotment
(
   faculty_id int,
   course_id int,
   session_id int, 
   primary key (faculty_id,course_id,session_id)
)";
$s = $dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>course_allotment created");
} catch (PDOException $o) {
    echo("<br>course_allotment not created");
}

$c = "create table attendance_details
(
    faculty_id int,
    course_id int,
    session_id int,
    student_id int,
    on_date date,
    status varchar(10),
    primary key (faculty_id,course_id,session_id,on_date,student_id)
)";
$s = $dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>attendance_details created");
} catch (PDOException $o) {
    echo("<br>attendance_details not created");
}

$c = "insert into student_details
(id,roll_no,name)
values
(1,'RA2111003011462','SIDHARTH SINGH'),
(2,'RA2111003011463','PADMARAJU NIKHIL VARDHAN RAJU'),
(3,'RA2111003011464','MOHIT AGLAWE'),
(4,'RA2111003011465','HAARISH RAMALINGAM'),
(5,'RA2111003011467','ANSHUMAN CHOUDHARY'),
(6,'RA2111003011468','SAI TEJA MUKUNDAM'),
(7,'RA2111003011469','IDAMAKANTI VENKATESWAR REDDY'),
(8,'RA2111003011470','DHRUV AGRAWAL'),
(9,'RA2111003011471','SIDDHARTH RAI'),
(10,'RA2111003011473','YADATI GOUTHAM KUMAR REDDY'),
(11,'RA2111003011474','ANIKET RAJ SINGH'),
(12,'RA2111003011475','VIKRAM S'),
(13,'RA2111003011476','KHUSH PARIKH'),
(14,'RA2111003011477','JUHI RASTOGI'),
(15,'RA2111003011478','ANJHANA M'),
(16,'RA2111003011479','SHAILESH RAJ'),
(17,'RA2111003011480','MUHAMMED HAFIZ S'),
(18,'RA2111003011481','GUNNA RAHUL'),
(19,'RA2111003011482','SENEEN SAKINA KHAN'),
(20,'RA2111003011483','AAKARSH SHARMA'),
(21,'RA2111003011484','UTKARSH MISHRA'),
(22,'RA2111003011485','JOESAM DINESH C'),
(23,'RA2111003011487','MOHAMED ZIYADH'),
(24,'RA2111003011488','SHRINIDHI S')";

$s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

$c = "insert into faculty_details
(id,user_name,password,name)
values
(1,'sksrm','123','Dr.Sree Kumar'),
(2,'vpsrm','123','Dr.Vinod Paul'),
(3,'sasrm','123','Dr.Sibi Amaran'),
(4,'rksrm','123','Dr.Raj Kamal'),
(5,'snsrm','123','Dr.Sankara Narayanan'),
(6,'dssrm','123','Dr.Debanjan Sarkar')";

$s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

$c = "insert into session_details
(id,year,term)
values
(1,2024,'6th SEMESTER'),
(2,2024,'7th SEMESTER')";

$s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

$c = "insert into course_details
(id,title,code,credit)
values
  (1,'Database Management Systems','18CSC303J',4),
  (2,'Compiler Design','18CSC304J',4),
  (3,'Artificial Intelligence','18CSC305J',4),
  (4,'iOS App Development Skills','18CSE311L',3),
  (5,'Wireless Sensor Networks','18CSE451T',3),
  (6,'5G Technology - An Overview','18ECO127T',3)";

  $s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

//if any record already there in the table delete them
clearTable($dbo, "course_registration");
$c = "insert into course_registration
  (student_id,course_id,session_id)
  values
  (:sid,:cid,:sessid)";
$s = $dbo->conn->prepare($c);
//iterate over all the 24 students
//for each of them chose max 3 random courses, from 1 to 6

for ($i = 1; $i <= 24; $i++) {
  for ($j = 0; $j < 3; $j++) {
    $cid = rand(1, 6);
    //insert the selected course into course_registration table for 
    //session 1 and student_id $i
    try {
      $s->execute([":sid" => $i, ":cid" => $cid, ":sessid" => 1]);
    } catch (PDOException $pe) {
    }

    //repeat for session 2
    $cid = rand(1, 6);
    //insert the selected course into course_registration table for 
    //session 2 and student_id $i
    try {
      $s->execute([":sid" => $i, ":cid" => $cid, ":sessid" => 2]);
    } catch (PDOException $pe) {
    }
  }
}


//if any record already there in the table delete them
clearTable($dbo, "course_allotment");
$c = "insert into course_allotment
  (faculty_id,course_id,session_id)
  values
  (:fid,:cid,:sessid)";
$s = $dbo->conn->prepare($c);
//iterate over all the 6 teachers
//for each of them chose max 2 random courses, from 1 to 6

for ($i = 1; $i <= 6; $i++) {
  for ($j = 0; $j < 2; $j++) {
    $cid = rand(1, 6);
    //insert the selected course into course_allotment table for 
    //session 1 and fac_id $i
    try {
      $s->execute([":fid" => $i, ":cid" => $cid, ":sessid" => 1]);
    } catch (PDOException $pe) {
    }

    //repeat for session 2
    $cid = rand(1, 6);
    //insert the selected course into course_allotment table for 
    //session 2 and student_id $i
    try {
      $s->execute([":fid" => $i, ":cid" => $cid, ":sessid" => 2]);
    } catch (PDOException $pe) {
    }
  }
}





?>
