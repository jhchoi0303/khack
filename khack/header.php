<?php


session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
?>


<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>K-Hack</title>
    <meta charset="UTF-8">
    <link href="https://unpkg.com/nes.css/css/nes.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/blocks.css/dist/blocks.min.css" />
    <link href="styles.css" rel="stylesheet" />
    <script src="jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
</head>
<body>
	
	
	
	
<form action="problem_list.php" method="post">
    <div class='navbar fixed'>
        <div class='m'>
        	<label for="default_select"></label>
        	<div class="nes-select">
        		<select onchange="if(this.value) location.href=(this.value);">
        			<option value="main.php" >메뉴를 선택하세요...</option>
        			<option value="main.php">홈</option>
        			<option value="problem_list.php">문제 목록</option>
        			<option value="writeup_list.php">풀이 목록</option>
        			<option value="flag_submit.php">플래그 제출하기</option>
        			<option value="lecture_list.php">강의</option>
        			<option value="ranking_list.php">랭킹</option>
        			</select>
        			</div>

          <button style="margin-left:20px; margin-right:10px; width:150px;" type="button" class="nes-btn is-primary" onclick="location.href='logout.php'"> <?php echo htmlspecialchars($_SESSION["username"]); ?>  </br> 로그아웃 </button>
          <a class="nes-btn" href="reset_pw.php">비밀번호 재설정</a>

        </div>
    </div>
</form>


