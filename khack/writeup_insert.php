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

$title = $_POST['title'];
$content = $_POST['content'];
$writeup_author = $_POST['writeup_author'];
$problem_id = $_POST['problem_id'];
$writeup_author = $_SESSION['id'];

$login_id = $_SESSION['id'];


$query =  "select title from writeup group by title";
$res = mysqli_query($conn, $query);
$row_index = 1;

while ($row = mysqli_fetch_array($res)) {
            if( $row['title'] == $title ){
            	msg('도배를 금지하기 위해 제목은 중복되면 안됩니다!');
            }
            $row_index++;
}






$query2 =  " select DISTINCT(id) from problem;";
$res2 = mysqli_query($conn, $query2);
$total_rows = mysqli_num_rows($res2);

$row_index=1;
while ($row = mysqli_fetch_array($res2)) {
            if( $row['id'] == $problem_id ){
            	break;
            }
            $row_index++;
            
            if($row_index>$total_rows){
            	msg('입력하신 문제 번호는 존재하지 않는 문제입니다');
            	break;
            }
}




$ret = mysqli_query($conn, "select * from solves where problem_id='$problem_id'");
$total_rows = mysqli_num_rows($ret);


$row_index=1;
while($row = mysqli_fetch_assoc($ret)){
	if($login_id == $row['member_id']){
		
		$ret = mysqli_query($conn, "insert into writeup (title, content, writeup_author, problem_id) values('$title', '$content', '$writeup_author', '$problem_id')");
		if(!$ret){
	
		mysqli_query($conn, "rollback");
    	msg('삭제할 수 없습니다.');
		
		}
	
	else{
	
		mysqli_query($conn, "commit");
    	s_msg ('성공적으로 삭제 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=writeup_list.php'>";
		
	}
		break;
	}
	$row_index++;
	
	 if($row_index>$total_rows){
            s_msg('아직 solve하지 못한 문제라 writeup을 작성 못합니다!');
            echo "<meta http-equiv='refresh' content='0;url=writeup_list.php'>";
            	break;
            }
	
	
}










?>


