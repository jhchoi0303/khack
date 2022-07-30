<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
 


$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");


$id = $_POST['id'];
$title = $_POST['title'];
$explanation = $_POST['explanation'];
$type = $_POST['type'];
$file = $_POST['file'];
$points = $_POST['points'];
$flag=$_POST['flag'];



$ret = mysqli_query($conn, "update problem set title ='$title', explanation ='$explanation', flag='$flag',type ='$type', file='$file', points='$points' where id = '$id'");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    msg('예상치 못한 에러가 발생했습니다! : '.mysqli_error($conn));
}
else
{
	
	mysqli_query($conn, "commit");

    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=problem_list.php'>";
}

?>

