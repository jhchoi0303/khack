
<html lang='ko'>
  
  
  <head>
  <link href="https://unpkg.com/nes.css/css/nes.css" rel="stylesheet" />
  <link href="styles.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">

  </head>
  
  
  <body>
  <div class = "container">
  <div class="nes-container with-title" style="width:500px; height: 500px ; margin: 0 auto;">
      <p class="title" style="font-size: 30px;">Welcome to K-Hack!</p>
  <div class="intro"> 
   <div class="question">
       <p>K-HACK가 처음이신가요?</p>
   <label>
       <input type="radio" class="nes-radio" name="answer" value="yes" checked />
       <span>Yes</span>
       </label>
     <label>
       <input type="radio" class="nes-radio" name="answer" value="No" />
       <span>No</span>
  </label>
  </div>
  <div class="options">
  <button class="nes-btn is-success" onclick="location.href='signup.php'" >Signup</button>
 </div>
 <p style="font-size:20px; margin-top:30px;">계정이 이미 있다고요? <a href="login.php">여기로 로그인 하세요</a>.</p>
   </div>
 </div>
 
</div>
  
  </body>
  </html>
<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  echo "<meta http-equiv='refresh' content='0;url=login.php'>";
  exit;
}

// Check if the user is logged in, if not then redirect him to login page

?>


</html>  
  
  
