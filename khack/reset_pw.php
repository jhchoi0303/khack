<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  
$conn = dbconnect($host, $dbid, $dbpass, $dbname);
// Include config file
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "새 비밀번호를 입력해주세요";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "비밀번호는 최소 6글자 입니다.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "비밀번호를 확인해주세요";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "비밀번호가 맞지 않습니다.";
        }
    }
    
    
	$id = $_SESSION["id"];
	$new_hash = md5($new_password);
	
	$ret = mysqli_query($conn, "update member set password ='$new_hash' where id = '$id'");
        
        if(!$ret){
        	echo mysqli_error($conn);
        	msg('Query Error : '.mysqli_error($conn));
        	
        }
       
        else
        {
        	s_msg ('성공적으로 바꼈습니다. 다시 로그인 해주세요!');
        	session_destroy();  
        	
        	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        	
    }
        
  
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://unpkg.com/nes.css/css/nes.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
  

</head>
<body>
    <div class="container">
    	<div class="nes-container with-title">
    		<div class="small">
        <h2>비밀번호 재설정하기</h2>
        <p>비밀번호를 재설정하려면 다음을 입력하세요!</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
            		<div class="nes-field" style="margin-top:10px">
                <label>새 비밀번호</label>
                <input type="password" name="new_password" class="nes-input <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span></div>
            </div>
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px">
                <label>비밀번호 재입력</label>
                <input type="password" name="confirm_password" class="nes-input <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span></div>
            </div>
            <div class="form-group" style="margin-top:40px;">
                <div class="form-group" style="margin-bottom:20px;">
                <input type="submit" class="nes-btn is-success" value="확인">
                <input type="reset" class="nes-btn" onclick= "location.href='main.php'" value="돌아가기">
            </div>
            
            
            </div>
        </form>
    </div></div>   
</body>
</html>