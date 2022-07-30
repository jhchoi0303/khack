<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
session_start();



mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");



$query =  " select id from solves where member_id=1 union select 15 union SELECT 23;";

$r = mysqli_fetch_array(mysqli_query($conn, $query));
print_r($r);


$r = mysqli_fetch_array(mysqli_query($conn, $query));
print_r($r);


?>


