<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
 //유틸 함수


$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");

$mode = "입력";
$action = "problem_insert.php";

if (array_key_exists("problem_id", $_GET)) {
    $id = $_GET["problem_id"];
    $query = "select * , problem.id as problem_id from problem join member where member.id=problem.problem_author and problem.id= $id";
    $res = mysqli_query($conn, $query);
    $problem = mysqli_fetch_array($res);

    if(!$problem) {
        msg("문제가 존재하지 않습니다.");
    }
    $mode = "수정";
    
    $login_id = $_SESSION['id'];
    $ret = mysqli_query($conn, "select * from problem where id='$id'");
    
    if(!$ret){
            		 mysqli_query($conn, "rollback");
            		 s_msg("실패하였습니다. 다시 시도하여 주십시오."); 
            		 echo "<meta http-equiv='refresh' content='0;url=problem_form.php'>";
            		
            	}
            	
            	
    mysqli_query($conn, "commit");
    
    $row = mysqli_fetch_assoc($ret);
    
    if($login_id != $row['problem_author']){
		s_msg('작성자가 아니여서 수정하지 못합니다!');
		echo "<meta http-equiv='refresh' content='0;url=problem_list.php'>";
    }
    
    else{
    	
    	$action = "problem_modify.php";
    }

    
    
    
   
    
    //echo json_encode($product);
}



?>
<div class= "container2">
    <div class="wrapper block" style="padding: 100px; width:100%; height:60%">
        <form name="problem_form" action="<?=$action?>" method="post" class="fullwidth">
           <input type="hidden" name="id" value="<?=$problem['problem_id']?>"/>
            <h3>문제 정보 <?php echo $mode; ?></h3>
            <p>
                <label for="type">해킹문제 분류</label>
                <div class="nes-select is-warning">
                <select name="type" id="type">
                    <option value="-1">선택해 주십시오.</option>
                    <option value="Reversing">리버싱</option>
                    <option value="Web Hack">웹 해킹</option>
                    <option value="Pwnable">시스템 해킹</option>
                    <option value="Forensics">디지털 포렌식</option>
                    <option value="Crypto">암호학</option>
                    <option value="Etc">기타</option>
                </select>
</div>
            </p>
            <p>
                <label for="title">문제 제목</label>
                <input class="nes-input" type="text" placeholder="문제 제목 입력" id="title" name="title" value="<?=$problem['title']?>"/>
            </p>
            
           
          	<p>
                <label for="file">문제 파일 링크</label>
                <input class="nes-input" type="text" placeholder="파일 링크 입력" id="file" name="file" rows="10" value="<?=$problem['file']?>"/></input>
            </p>
            
            <p>
                <label for="explanation">문제 설명</label>
                <textarea class="nes-textarea" style="width:100%;" placeholder="문제 설명 입력" id="explanation" name="explanation" cols= "11" rows="10"><?=$problem['explanation']?></textarea>
            </p>
            <p>
                <label for="points">문제 배점</label>
                <input class="nes-input" type="text" placeholder="정수로 입력" id="points" name="points" value="<?=$problem['points']?>" />
            </p>
            
            <p>
                <label for="flag">정답(flag)을 입력해주세요 (최소 10자인 문자열)</label>
                <input class="nes-input" type="text" placeholder=" 길이가 최소 10인 문자열로 입력" id="flag" name="flag" value="<?=$problem['flag']?>" />
            </p>
            
             <p>
                <label for="problem_author">문제 출제자:</label>
                <?=$_SESSION["username"]?>
            </p>
            
      

            <p align="center"><button class="nes-btn is-success" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
          
        
                    if(document.getElementById("type").value == "-1") {
                        alert ("문제 분류를 선택해 주십시오"); return false;
                    }
                    else if(!document.getElementById("title").value) {
                        alert ("문제 제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("explanation").value == "") {
                        alert ("문제 설명을 입력해 주십시오"); return false;
                    }
                    
                    else if(document.getElementById("flag").value==""){
                    	alert("flag를 입력해주세요"); return false;
                    }
                    else if(document.getElementById("points").value == "") {
                        alert ("문제 배점을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("points").value> 200){
                        	alert("문제 배점이 너무 커요!"); return false;
                    }
                    else if(document.getElementById("points").value < 0){
                        	alert("문제 배점이 너무 작습니다!"); return false;
                    }
                    else if(document.getElementById('flag').value.length<10){
                    	alert("flag 길이는 최소 10자입니다!"); return false;
                    }
                    
               
                    return true;
                }
                
               
               
            </script>
            

        </form>
    </div>
            </div>
<? include("footer.php") ?>