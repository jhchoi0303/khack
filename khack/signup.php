<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php"; 
 
$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");
// Define variables and initialize with empty values
$username = $password = $confirm_password = $gender =$comments =$name = "";
$username_err = $name_err = $gender_err = $password_err = $comment_err= $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        msg("유저네임에는 숫자, 언더바, 문자만 들어갑니다.");
    } else{
        // Prepare a select statement
        $username=trim($_POST["username"]);
        $sql = "SELECT * FROM member WHERE username = '$username'";
        
        $res = mysqli_query($conn, $sql);
        
        $count = mysqli_num_rows($res);

        if($count>0){
        	msg("이미 등록돼 있는 유저네임입니다!");
        }
    }
    
    if(empty(trim($_POST["name"]))){
        $name_err = "이름을 입력해주세요";
    }
        
     if(empty(trim($_POST["comments"]))){
        $comment_err = "코멘트를 입력해주세요.";
    }
    
        
    if(empty(trim($_POST["gender"]))){
        $gender_err = "성별을 입력해주세요";
    }
    elseif(preg_match('M', trim($_POST["gender"])) || preg_match('W', trim($_POST["gender"]))){
        msg("성별은 M 또는 W 입니다!");
    }
      
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "비밀번호를 입력해주세요";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "비밀번호는 최소 6글자 입니다.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "비밀번호를 확인해주세요";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "비밀번호가 맞지 않습니다.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        
        
        $password= trim($_POST["password"]);
        $hash = md5($password);
        
        
        $username= $_POST["username"];
        $gender= $_POST["gender"];
        $name= $_POST["name"];
        $comments= $_POST["comments"];
        
        $currentTimeinSeconds = time();

        $currentDate = date('Y-m-d', $currentTimeinSeconds);
        
        $sql ="insert into member (username, password, name, gender, signup_date, comments) values('$username','$hash','$name','$gender','$currentDate', '$comments')";
               
        $ret = mysqli_query($conn, $sql);
        
        if(!$ret){
        	mysqli_query($conn, "rollback");
        	msg('Query Error : '.mysqli_error($conn));
        	
        }
       
        else
        {
        	mysqli_query($conn, "commit");
        	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
        	
        }
    }
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://unpkg.com/nes.css/css/nes.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
    
</head>
<body>
    <div class="container">
    	<div class="nes-container with-title">
    <div class="small">
        <h2>회원가입</h2>
        <p>다음을 다 입력해주세요.</p>
        <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px">
                <label>유저 네임</label>
                <input style="width:200px" type="text" name="username" class="nes-input <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span></div>
            </div>
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px">
                <label>이름</label>
                <input style="width:200px" type="text" name="name" class="nes-input <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span></div>
            </div>
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px">
                <label>성별 (M / W) </label>
                <input style="width:80px" type="text" name="gender" class="nes-input <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $gender; ?>">
                <span class="invalid-feedback"><?php echo $gender_err; ?></span></div>
            </div>
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px">
                <label>코멘트</label>
                <input style="width:400px" type="text" name="comments" class="nes-input <?php echo (!empty($comment_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $comments; ?>">
                <span class="invalid-feedback"><?php echo $comment_err; ?></span></div>
            </div>
            <div class="form-group">
            <div class="nes-field" style="margin-top:10px">
                <label>비밀번호 (6자리 이상)</label>
                <input style="width:300px"type="password" name="password" class="nes-input <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span></div>
            </div>
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px; margin-bottom: 30px">
                <label>비밀번호 재입력</label>
                <input style="width:300px"type="password" name="confirm_password" class="nes-input <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span></div>
                
            </div>
           
            <div class="form-group" style="margin-bottom:20px;">
                <input type="submit" class="nes-btn is-success" value="확인">
                <input type="reset" class="nes-btn" value="초기화">
            </div>
            <p>계정이 이미 있다고요? <a href="login.php">여기로 로그인 하세요</a>.</p>
        </form></div></div>
    </div>    
</body>
</html>