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


$flag = $_POST['flag'];
$login_id = $_SESSION['id'];

$points = $_POST['points'];

$flag=$_POST['flag'];


$query =  "select * from problem";
$res = mysqli_query($conn, $query);
$row_index = 1;

while ($row = mysqli_fetch_array($res)) {
            if( $row['flag'] == $flag ){
            	
            	$prob_id=$row['id'];
            	$member_id= $_SESSION['id'];

            	
            	 $select_query = "select * from solves where member_id=$member_id and problem_id=$prob_id";
            	 $result_set = mysqli_query($conn, $select_query);
            	 $count = mysqli_num_rows($result_set);
            	 
    
            	if($count>0)
            	{
            		msg("이미 해결하신 문제의 플래그입니다!");
            	}
            	
            	$ret = mysqli_query($conn, "insert into solves (member_id, problem_id, solve_date) values('$member_id','$prob_id',now())");
            	
            	if(!$ret){
            		 mysqli_query($conn, "rollback");
            		 s_msg("실패하였습니다. 다시 시도하여 주십시오."); 
            		 echo "<meta http-equiv='refresh' content='0;url=flag_submit.php'>";
            		
            	}
            	
            	
            	mysqli_query($conn, "commit");
            	msg($row['title']. " 해결되었습니다! " .$row['points'] ." pts 획득! ");
            	

            }
            $row_index++;
}


s_msg ('틀린 플래그입니다!');
echo "<meta http-equiv='refresh' content='0;url=flag_submit.php'>";


?>


