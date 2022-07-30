<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수


session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "flag_check.php";

?>
    <div class="container">
        <form name="problem_form" action="<?=$action?>" method="post" class="fullwidth">
              <p>
           
                
                <div style="background-color:#212529; padding: 1rem;" class="nes-field is-inline">    
                <label for="flag" style="color:#fff;" >플래그를 입력해주세요</label>
                <input type="text"  class="nes-input is-dark" placeholder="" id="flag" name="flag" value="" />
                <button class=class="nes-input is-dark" style="margin-left: 20px; height: 50px; width:50px;"onclick="javascript:return validate();"><?=$mode?></button></div>
            </p>
            
        
        </form>
            
            <script>
                function validate() {
          
                    if(document.getElementById("flag").value == "") {
                        alert ("flag를 입력해 주십시오"); return false
                    }
                    return true;
                }
                
               
               
            </script>
            

        </form>
    </div>
<? include("footer.php") ?>