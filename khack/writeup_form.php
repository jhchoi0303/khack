<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php"; 
//유틸 함수
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "writeup_insert.php";

if (array_key_exists("writeup_id", $_GET)) {
    $id = $_GET["writeup_id"];
    $query = "select *, problem.title as problem_title, member.id as member_id,writeup.id as writeup_id, writeup.title as writeup_title from writeup join member, problem where writeup.writeup_author=member.id and writeup.problem_id=problem.id and writeup.id= $id";
    $res = mysqli_query($conn, $query);
    $writeup = mysqli_fetch_array($res);

    if(!$writeup) {
        msg("writeup이 존재하지 않습니다.");
    }
    
    $login_id = $_SESSION['id'];
    $ret = mysqli_query($conn, "select * from writeup where id='$id'");
    $row = mysqli_fetch_assoc($ret);
    
    if($login_id != $row['writeup_author']){
		s_msg('writeup 작성자가 아니여서 수정하지 못합니다!');
		echo "<meta http-equiv='refresh' content='0;url=writeup_list.php'>";
    }
    
    else{
    $mode = "수정";
    $action = "writeup_modify.php";
    }
   
    
    //echo json_encode($product);
}



?>
    <div class="column" style="padding-top:10px;">
    <div class="wrapper block" style="width: 40%; height: 700px; display: inline-block; padding: 50px;">
        <form name="writeup_form" action="<?=$action?>" method="post" class="fullwidth">
           <input type="hidden" name="id" value="<?=$writeup['writeup_id']?>"/>
            <h3>writeup 내용<?php echo $mode; ?></h3>
            
            <p>
                <label for="title">writeup 제목</label>
                <input class="nes-input" type="text" placeholder="문제 제목 입력" id="title" name="title" value="<?=$writeup['writeup_title']?>"/>
            </p>
            
            <p>
                <label for="problem_id">문제 정보 (문제 번호)</label>
                <input class="nes-input" type="text" placeholder="문제 번호 입력" id="problem_id" name="problem_id" value="<?=$writeup['problem_id']?>"/>
            </p>
            
            
            <p>
                <label for="content">writeup 본문</label>
               
                </p>
                <p>
                <textarea class="nes-textarea" placeholder="writeup 본문  입력" id="content" name="content"  cols="40" style="height:100px; width=500px;"><?=$writeup['content']?></textarea>
            </p>
            
            
              <p>
                <label for="writeup_author">writeup 작성자:</label> 
                <?=$_SESSION["username"]?>
            </p>
            


            <p align="center"><button class="nes-btn is-success" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
          
        
                
                    if(!document.getElementById("title").value) {
                        alert ("writeup 제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("problem_id").value == "") {
                        alert ("문제 번호를 입력해 주십시오"); return false;
                    }
                    
                    else if(document.getElementById("content").value==""){
                    	alert("내용을 입력해주세요"); return false;
                    }
                    else if(document.getElementById("writeup_author").value == "0") {
                        alert ("작성자를 입력해 주십시오"); return false;
                    }
                 \
                    
               
                    return true;
                }
                
               
               
            </script>
            

        </form>
    </div>
            </div>
<? include("footer.php") ?>