<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "workbook_insert.php";



session_start();
$login_id = $_SESSION['id'];

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}



if (array_key_exists("workbook_id", $_GET)) {
    $id = $_GET["workbook_id"];
    $query = "SELECT *, workbook.id as workbook_id, workbook.title as workbook_title, member.id as member_id, problem.id as problem_id, problem.title as problem_title from workbook join workbook_problem,member,problem where workbook.id=workbook_problem.workbook_id and member.id=creator and problem.id=workbook_problem.problem_id and workbook_id=$id;";
    $res = mysqli_query($conn, $query);
    $workbook = mysqli_fetch_array($res);

    if(!$workbook) {
        msg("workbook이 존재하지 않습니다.");
    }
    
    $login_id = $_SESSION['id'];
    $ret = mysqli_query($conn, "select * from workbook where id='$id'");
    $row = mysqli_fetch_assoc($ret);
    
    if($login_id != $row['creator']){
		s_msg('해당 workbook를 등록한 사람이 아니여서 수정하지 못합니다!');
		echo "<meta http-equiv='refresh' content='0;url=workbook_list.php'>";
    }
    
    else{
    $mode = "편집";
    $action = "workbook_modify.php";
    }
   
    
    //echo json_encode($product);
}
?>


    <div class="column">
        <form name="workbook_form" action="<?=$action?>" method="post" class="fullwidth">
           <input type="hidden" name="id" value="<?=$workbook['workbook_id']?>"/>
            <h3>workbook <?php echo $mode; ?></h3>
            
        
			
    				  <p>
    	      <label for="workbook_author">연습문제집 등록자: </label>
            <?=$_SESSION["username"]?>
            
            </p>
            
            <p>
            <label for="workbook_title">연습문제집 제목</label>
            <input  type="text" id="workbook_title" name="workbook_title" value="<?= $workbook['workbook_title'] ?>"/>
            </p>
            <p>
            
            <label for="workbook_type">연습 문제집 난이도 (1~10까지의 정수)</label>
            <input  type="text" id="workbook_difficulty" name="workbook_difficulty" value="<?= $workbook['difficulty'] ?>"/>
            
            </p>
       
            	<p>
            <label for="workbook_prob">연습문제에 문제 추가</label>
            </p>
            <table class="table table-striped table-bordered">
            	
          
            
  
            <?
            
            if (array_key_exists("workbook_id", $_GET)){
            	$query = "select * from workbook join workbook_problem where workbook.id=workbook_problem.workbook_id and workbook.id=$id";
            $res2 = mysqli_query($conn, $query);
            
             $row_index = 0;
             
             $arrayofrows = array();
             while($row = mysqli_fetch_array($res2))
             {
             	array_push($arrayofrows,$row['problem_id']);
             	$row_index ++;
             }
             
             
             $col_index = 0;
             while($col_index<count($arrayofrows)){
             	echo "<td>  <p id='par'></p></td>";
             	echo "<input type='text' name='array[]' value='$arrayofrows[$col_index]' /><br>";
             	$col_index++;
             }
            }
            
            else{
            	echo"<div class='c2'>";
            
            	echo "<input placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' /></br>";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	echo "<input style='margin-bottom:20px;' placeholder='문제 번호를 입력하세요' type='text' name='array[]' value='' />";
            	
            	echo"</div>";
            
        
            }
            
            ?>
         
            
            </table>
            
    
            	</div>
           <p align="center"><button class="nes-btn is-success" onclick="javascript:return validate();"><?=$mode?></button></p>

            </div>
           <script>
           
   
           </script>
           
           
    
        
   

           
            <script>
                function validate() {
                	
        
                
                    if(!document.getElementById("workbook_title").value) {
                        alert ("workbook 제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("problem_id").value == "") {
                        alert ("workbook 번호를 입력해 주십시오"); return false;
                    }
                    
                    else if(document.getElementById("content").value==""){
                    	alert("내용을 입력해주세요"); return false;
                    }
                    else if(document.getElementById("workbook_author").value == "") {
                        alert ("등록자를 입력해 주십시오"); return false;
                    }
                 \
                    
               
                    return true;
                }
                
               
               
            </script>
            

        </form>

<? include("footer.php") ?>