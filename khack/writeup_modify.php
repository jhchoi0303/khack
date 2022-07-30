<?php
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




$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$writeup_author = $_POST['writeup_author'];
$problem_id = $_POST['problem_id'];






$query =  " select DISTINCT(id) from problem;";
$res = mysqli_query($conn, $query);
$total_rows = mysqli_num_rows($res);

$row_index=1;
while ($row = mysqli_fetch_array($res)) {
            if( $row['id'] == $problem_id ){
            	break;
            }
            $row_index++;
            
            if($row_index>$total_rows){
            	msg('입력하신 문제 번호는 존재하지 않는 문제입니다');
            	break;
            }
}





$ret = mysqli_query($conn, "update writeup set title ='$title', content ='$content', problem_id='$problem_id' where id = '$id'");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    msg('예상치 못한 에러가 발생했습니다! : '.mysqli_error($conn));
}
else
{
	
	mysqli_query($conn, "commit");

    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=writeup_list.php'>";
}


?>

