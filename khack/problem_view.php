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

          <h2 style='font-size:30px'class="title">문제 제목: <?= $problem['title'] ?></h2>
         
          <div class="nes-table-responsive">
  <table style="position: relative; text-align:center;" class="nes-table is-bordered is-dark">
    <thead>
      <tr>
        <th style='font-size:20px'>문제 번호</th>
        <th style='font-size:20px'>분 류</th>
        <th style='font-size:20px'>점 수</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td style='font-size:20px'><?= $problem['problem_id'] ?></td>
        <td style='font-size:20px'><?= $problem['type'] ?></td>
        <td style='font-size:20px'><?= $problem['points'] ?></td>
      </tr>

    </tbody>
  </table>
</div>

  

 

        <p class="c3">
        <div style="margin-bottom:30px;" class="nes-container is-rounded">
            <div class = "column">
            <label for="problem_explanation" style="font-size: 20px"><i class="nes-icon is-small heart"></i>설명<i class="nes-icon is-small heart"></i></label>
            <textarea class="nes-textarea" cols="100" size="100"style="font-size:15px;" readonly type="text" id="explanation" name="explanation"><?= $problem['explanation'] ?></textarea>
</div>
        </p>

        <p>
            <label for="problem_file" style="font-size: 20px">문제 파일 링크:</label>
          
           <a href="<?= $problem['file'] ?>"><?= $problem['file'] ?></a>
        </p>
</div>
        
        <h2> <i class="snes-logo"></i> Solves </h2>
        
        <?
        $query = "select count(member_id) as solve_count from problem join solves where problem.id = solves.problem_id and problem.id= $id";
        $res = mysqli_query($conn, $query);
        $problem_solve = mysqli_fetch_assoc($res);
        ?>

        <p>
        
            <textarea class="nes-textarea" cols="2" rows="1" readonly id="solve_count" name="solve_count" ><?= $problem_solve['solve_count'] ?>명</textarea>
        </p>

    
        <div id="row">
        
        <h2>해당 문제 관련 Write-up</h2>
        
        <?
        $query = "select writeup.id, writeup.title from writeup join problem where writeup.problem_id=problem.id and problem.id = $id";
        $res = mysqli_query($conn, $query);
   
        ?>
        
       
            
        <?
        $row_index = 1;
        while ($problem_writeup = mysqli_fetch_assoc($res)) {
        	
          
            echo "<a href='writeup_view.php?writeup_id={$problem_writeup['id']}'><p style='font-size: 23px;'>{$problem_writeup['title']}</p></a>";

            $row_index++;
        }
        ?>
           
      </div>
        </div>
   
<? include("footer.php") ?>