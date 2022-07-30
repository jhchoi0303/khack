﻿<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");


session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}


$id = $_GET['writeup_id'];
$login_id = $_SESSION['id'];




$ret = mysqli_query($conn, "select * from writeup where id='$id'");
$row = mysqli_fetch_assoc($ret);


if($login_id != $row['writeup_author']){
	s_msg('작성자가 아니여서 지우지 못합니다!');
	echo "<meta http-equiv='refresh' content='0;url=writeup_list.php'>";
}

else{
	$ret = mysqli_query($conn, "delete from writeup where id= $id");
	if(!$ret){
	
	mysqli_query($conn, "rollback");
    msg('삭제할 수 없습니다.');
		
	}
	
	else{
	
	mysqli_query($conn, "commit");
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=writeup_list.php'>";
		
	}
}
?>

