<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
session_start();
mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}

$login_id = $_SESSION['id'];
$workbook_title = $_POST['workbook_title'];
$workbook_difficulty = $_POST['workbook_difficulty'];


$ret = mysqli_query($conn, "INSERT into workbook (title, difficulty,creator) values ('$workbook_title', '$workbook_difficulty','$login_id')");


$workbook_id= mysqli_query($conn, " select max(id) as workbook_id from workbook;");
$workbook_id = mysqli_fetch_array($workbook_id);
$workbook_id=$workbook_id['workbook_id'];
//$ret = mysqli_query($conn, "update workbook set title ='$workboook_title', content ='$workboook_difficulty' where id = '$workbook_id'");

foreach ($_POST['array'] as $key => $value) {
	
	$key=$key+1;
	$query =  " select DISTINCT(id) from problem;";
	$res = mysqli_query($conn, $query);
	
	if(!$ret){
	 mysqli_query($conn, "rollback");
	 s_msg("실패하였습니다. 다시 시도하여 주십시오."); 
     echo "<meta http-equiv='refresh' content='0;url=workbook_list.php'>";
		
	}

	
	$total_rows = mysqli_num_rows($res);
	$row_index=1;
	
	while ($row = mysqli_fetch_array($res)) {
            if( $row['id'] == $value ){
            	break;
            }
            $row_index++;
            
            if($row_index>$total_rows){
            	msg('입력하신 문제 번호는 존재하지 않는 문제입니다');
            	break;
            }
		
	}
	
	$sql .= "INSERT into workbook_problem (NO, problem_id,workbook_id) values ('$key', '$value','$workbook_id');";
	



}


if (mysqli_multi_query($conn, $sql)) {
  do {
    // Store first result set
    if ($result = mysqli_store_result($conn)) {
      while ($row = mysqli_fetch_row($result)) {
        printf("%s\n", $row[0]);
      }
      mysqli_free_result($result);
    }
    // if there are more result-sets, the print a divider
    if (mysqli_more_results($conn)) {
       printf("-------------\n");
    }
     //Prepare next result set
  } while (mysqli_next_result($conn));
}


s_msg ('성공적으로 수정 되었습니다');
echo "<meta http-equiv='refresh' content='0;url=workbook_list.php'>";






mysqli_close($conn);




?>