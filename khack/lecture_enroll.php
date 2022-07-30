<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수



$conn = dbconnect($host,$dbid,$dbpass,$dbname);
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}

mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");

$lecture_id = $_POST['lecture_id'];
$student_id= $_SESSION['id'];



$select_query = "select * from lecture_enrollment where student_id=$student_id and lecture_id=$lecture_id";
$result_set = mysqli_query($conn, $select_query);
$count = mysqli_num_rows($result_set);
            	 
    
	if($count>0){
		msg("이미 수강 등록하신 강의입니다!");
	}
	else{
        $ret = mysqli_query($conn, "INSERT into lecture_enrollment (student_id, lecture_id) values ('$student_id', '$lecture_id')");
        if(!$ret){
            		 mysqli_query($conn, "rollback");
            		 s_msg("실패하였습니다. 다시 시도하여 주십시오."); 
            		 echo "<meta http-equiv='refresh' content='0;url=lecture_list.php'>";
            		
            	}
            	
            	
        mysqli_query($conn, "commit");
         s_msg ('성공적으로 수강등록 되었습니다');
         echo "<meta http-equiv='refresh' content='0;url=lecture_list.php'>";
		
	}
            	





?>