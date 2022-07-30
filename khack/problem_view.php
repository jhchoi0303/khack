<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);



session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
 



if (array_key_exists("problem_id", $_GET)) {
    $id = $_GET["problem_id"];
    $query = "select * , problem.id as problem_id from problem join member where member.id=problem.problem_author and problem.id= $id";
    $res = mysqli_query($conn, $query);
    $problem = mysqli_fetch_assoc($res);
    if (!$problem) {
        msg("문제가 존재하지 않습니다.");
    }
}
?>
   
   
   <div class="column">
  <div style="margin-top:50px;"class="nes-container with-title">
          <h2 style='font-size:30px'class="title">문제 정보 상세 보기</h2>
         
       

  

        <p>
            
            
            <label for="problem_title">문제 제목</label>
            <input size="20" style="margin-right:80px; border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="problem_title" name="problem_title" value="<?= $problem['title'] ?>"/>
            
               <label for="problem_title">문제 번호</label>
            <input size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="problem_title" name="problem_title" value="<?= $problem['problem_id'] ?>"/>
         </p>
         <p>
            
            <label for="problem_type">종류</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="problem_type" name="problem_type" value="<?= $problem['type'] ?>"/>
            
             <label for="problem_points">점수</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="points" name="points" value="<?= $problem['points'] ?>"/>
        </p>

        <p class="c3">
            <label for="problem_explanation" style="margin-right:100px;">설명</label>
            <textarea cols="100" size="100"style="font-size:15px;" readonly type="text" id="explanation" name="explanation"><?= $problem['explanation'] ?></textarea>
        </p>

        <p>
            <label for="problem_file">문제 파일</label>
          
           <a href="<?= $problem['file'] ?>"><?= $problem['file'] ?></a>
        </p>
        
        
        <h2> Solves </h2>
        
        <?
        $query = "select count(member_id) as solve_count from problem join solves where problem.id = solves.problem_id and problem.id= $id";
        $res = mysqli_query($conn, $query);
        $problem_solve = mysqli_fetch_assoc($res);
        ?>

        <p>
        
            <textarea style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" cols="2" rows="1" readonly id="solve_count" name="solve_count" ><?= $problem_solve['solve_count'] ?>명</textarea>
        </p>

    
        <div id="row">
        
        <h2> Write-up</h2>
        
        <?
        $query = "select writeup.id, writeup.title from writeup join problem where writeup.problem_id=problem.id and problem.id = $id";
        $res = mysqli_query($conn, $query);
   
        ?>
        
       
            
        <?
        $row_index = 1;
        while ($problem_writeup = mysqli_fetch_assoc($res)) {
        	
          
            echo "<a href='writeup_view.php?writeup_id={$problem_writeup['id']}'>{$problem_writeup['title']}</a>";
             echo "</br>";

            $row_index++;
        }
        ?>
           
      </div>
        </div>
   
<? include("footer.php") ?>