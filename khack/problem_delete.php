<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";    
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
 //유틸 함수



$conn = dbconnect($host,$dbid,$dbpass,$dbname);


$id = $_GET['problem_id'];
$login_id = $_SESSION['id'];

$ret = mysqli_query($conn, "select * from problem where id= $id");
$row = mysqli_fetch_assoc($ret);


if($login_id != $row['problem_author']){
	s_msg('작성자가 아니여서 지우지 못합니다!');
}

else{
	

	try {
		$conn->query("delete from problem where id= $id");

	} catch (Exception $e) {
		//uh-oh, maybe a foreign key restraint failed?
		if ($e->getCode() == '1451') {
			s_msg("이미 솔버가 있는 문제라 삭제가 불가능합니다!");
			echo "<meta http-equiv='refresh' content='0;url=problem_list.php'>";
			//yep, it failed.  Do some stuff.
		}
	}
	
}
?>

