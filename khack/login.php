<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  
$conn = dbconnect($host, $dbid, $dbpass, $dbname);

session_start();



mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");




$username = $password = "";
$username_err = $password_err = $login_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    if(empty(trim($_POST["username"]))){
        $username_err = "유저네임을 입력해주세요";
    } else{
        $username = trim($_POST["username"]);
    }
    

    if(empty(trim($_POST["password"]))){
	        $password_err = "비밀번호를 입력해주세요";
    } else{
        $password = trim($_POST["password"]);
    }
    

    if(empty($username_err) && empty($password_err)){
    	
    	$username=trim($_POST["username"]);
    	$sql = "SELECT * FROM member WHERE username = '$username'";
        
        $res2 = mysqli_query($conn, $sql);
        
        
    	
    	$count = mysqli_num_rows($res2);
    	

    	if($count<=0){
        	$login_err = "등록되지 않은 유저네임입니다!";
        }
    	
    	$row = mysqli_fetch_assoc($res2);

    	
    	if(md5($password) == $row['password']){
    			

                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $row['id'];
                            $_SESSION["username"] = $row['username']; 
                            
                            
                            
                            if(!$res2){
                            	mysqli_query($conn, "rollback");
                            	s_msg("실패하였습니다. 다시 시도하여 주십시오."); 
                            	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
                            }
            	
            	
            				mysqli_query($conn, "commit");
            
            	
                            
                            
                            s_msg ('성공적으로 로그인 되었습니다');
                            echo "<meta http-equiv='refresh' content='0;url=main.php'>";
                           	
                        } else{
                           
                            $login_err = "비밀번호가 틀렸습니다.";
                        }
              }
    	}


        
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://unpkg.com/nes.css/css/nes.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">

</head>
<body>
    <div class="container">
    	<div class="nes-container with-title">
    	<div class="small">
        <h2>로그인</h2>
        <p>가입하신 유저네임과 비밀번호로 로그인하세요</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px">
                <label>유저 네임</label>
                <input type="text" name="username" class="nes-input <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span></div>
            </div>    
            <div class="form-group">
            	<div class="nes-field" style="margin-top:10px">
                <label>비밀 번호</label>
                <input type="password" name="password" class="nes-input <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span></div>
            </div>
			<div class="form-group" style="margin-bottom:20px; margin-top:20px;">
                <input type="submit" class="nes-btn is-success" value="로그인">
            </div>
            <p>계정이 없다면? <a href="signup.php">가입 하세요.</a>.</p>
        </form>
        </div></div>
    </div>
</body>
</html>