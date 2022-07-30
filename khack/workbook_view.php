<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("workbook_id", $_GET)) {
    $id = $_GET["workbook_id"];
    $query = "SELECT *, workbook.id as workbook_id, workbook.title as workbook_title, member.id as member_id, problem.id as problem_id, problem.title as problem_title from workbook join workbook_problem,member,problem where workbook.id=workbook_problem.workbook_id and member.id=creator and problem.id=workbook_problem.problem_id and workbook_id=$id;";
    $res = mysqli_query($conn, $query);
    $workbook = mysqli_fetch_assoc($res);
    if (!$workbook) {
        msg("연습 문제집이 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

       

<div class="column">
	<div class="nes-container with-title">
	 <h2>연습 문제집 정보</h2>
	 
	 <p>
	 	<label for="workbook">연습문제집 번호</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="workbook_id" name="workbook_id" value="<?= $workbook['workbook_id'] ?>"/>
	 <label for="workbook_author">연습문제집 등록자</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="member_id" name="member_id" value="<?= $workbook['username'] ?>"/>
            
            </p>
	 
  

        <p>
            
            
            <label for="workbook_title">연습문제집 제목</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;"t readonly type="text" id="workbook_title" name="workbook_title" value="<?= $workbook['workbook_title'] ?>"/>
            
            
            <label for="workbook_type">연습 문제집 난이도</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="" name="workbook_difficulty" value="<?= $workbook['difficulty'] ?>"/>
            
           
        </p>

        <h3>연습 문제집 문제 목록 </h3>
        <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th >No.</th>
            <th>문제명</th>
            <th>종류</th>
        </tr>
        </thead>
        <tbody>
        <?
        $query2 = "SELECT *, workbook.id as workbook_id, workbook.title as workbook_title, problem.id as problem_id, problem.title as problem_title from workbook join workbook_problem, problem where workbook.id=workbook_problem.workbook_id and problem.id=workbook_problem.problem_id and workbook_id=$id;";
    	$res2 = mysqli_query($conn, $query2);
    
        $row_index = 1;
   
        while ($workbook2 = mysqli_fetch_assoc($res2)) {
            echo "<tr >";
            echo "<td style='width:50px;'>{$workbook2['NO']}</td>";
            echo "<td style='width:400px;'><a href='problem_view.php?problem_id={$workbook2['problem_id']}'>{$workbook2['problem_title']}</a></td>";
            echo "<td>{$workbook2['type']}</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
        </table>
</div>
        </div>

</div>
        



        
        
<? include("footer.php") ?>