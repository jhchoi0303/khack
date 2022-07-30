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


$title = $_POST['title'];
$points = $_POST['points'];
$file = $_POST['file'];
$explanation = $_POST['explanation'];
$type = $_POST['type'];
$flag=$_POST['flag'];
$problem_author = $_SESSION['id'];

$query =  "select flag from problem group by flag";
$res = mysqli_query($conn, $query);
$row_index = 1;

while ($row = mysqli_fetch_array($res)) {
            if( $row['flag'] == $flag ){
            	msg('FLAG 값은 중복되면 안됩니다!');
            }
            $row_index++;
}


$query2 =  "select title from problem group by title";
$res2 = mysqli_query($conn, $query2);
$row_index = 1;

while ($row = mysqli_fetch_array($res2)) {
            if( $row['title'] == $title ){
            	msg('제목은 중복되면 안됩니다!');
            }
            $row_index++;
}






echo "insert into problem (title, points, file, explanation, type, flag, problem_author) values('$title', '$points', '$file', '$explanation', '$type', '$flag', '$problem_author')";

$ret = mysqli_query($conn, "insert into problem (title, points, file, explanation, type, flag, problem_author) values('$title', '$points', '$file', '$explanation', '$type', '$flag', '$problem_author')");







if(!$ret)
{
	 mysqli_query($conn, "rollback");
	 s_msg("실패하였습니다. 다시 시도하여 주십시오."); 
     echo "<meta http-equiv='refresh' content='0;url=problem_list.php'>";
}
else
{
	
	mysqli_query($conn, "commit");

    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=problem_list.php'>";
}

?>


