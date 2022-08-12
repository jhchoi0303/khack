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



if (array_key_exists("writeup_id", $_GET)) {
    $id = $_GET["writeup_id"];
    $query = "select *, problem.title as problem_title, writeup.id as writeup_id, writeup.title as writeup_title from writeup join member, problem where writeup.writeup_author=member.id and writeup.problem_id=problem.id and writeup.id= $id";
    $res = mysqli_query($conn, $query);
    $writeup = mysqli_fetch_assoc($res);
    if (!$writeup) {
        msg("writeup이 존재하지 않습니다.");
    }
    
}
?>
   
    	
    	
    <div class ="column">
    
    	
    	<div style="margin-top:50px;"class="nes-container with-title">
        <h2 style='font-size:30px'class="title">문제 '<?= $writeup['title'] ?>'에 대한 Writeup</h2>

        
        <p>
            <label for="problem_info">
            	<a href='problem_view.php?problem_id=<?= $writeup['id'] ?>'>☞ 문제 url (클릭) </a>
            </label>
            
        </p>

    	
<div class="nes-container with-title">
        <h2 style="margin-bottom:10px;"><i class="nes-icon is-middle like"></i> Writeup 본문</h2>
        <div class="nes-table-responsive">
        <table style="position: relative; text-align:center;" class="nes-table is-bordered is-dark">
    <thead>
      <tr>
        <td style="height: 1px; width:20%; color:#FFFFFF">Writeup 번호</td>
        <td style="height: 1px; width:80%; color:#FFFFFF"><?= $writeup['writeup_id'] ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height: 1px; width:20%; color:#FFFFFF">작성자</td>
        <td style="height: 1px; width:80%; color:#FFFFFF"><?= $writeup['username'] ?></td>
      </tr>
      <tr>
        <td style="height: 1px; width:20%; color:#FFFFFF">writeup 제목</td>
        <td style="height: 1px; width:80%; color:#FFFFFF"><?= $writeup['writeup_title'] ?></td>
      </tr>
    </tbody>
  </table>
</div>

<div style="margin-bottom:30px; margin-top:30px;" class="nes-container is-rounded">
            <div class = "column">
            <label for="problem_explanation" style="font-size: 20px"><i class="nes-icon is-small heart"></i>Writeup 내용<i class="nes-icon is-small heart"></i></label>
            <textarea class="nes-textarea" cols="100" size="100" style="font-size:15px;" readonly type="text" id="explanation" name="explanation"><?= $writeup['content'] ?></textarea>
</div>



    </div>
   
        
        <p> 
        <label for="other_title"> <h3>'<?=$writeup['problem_title']?>' 문제에 관한 다른 Writeup</h3> </label>
        </p>
        
        <?
        $query = "select writeup.id, writeup.title from writeup join problem where problem_id =(select problem_id from writeup join problem where writeup.problem_id=problem.id and writeup.id = $id) group by writeup.id";
        $res = mysqli_query($conn, $query);
   
       
        $row_index = 1;
        while ($problem_writeup = mysqli_fetch_assoc($res)) {
        	
        if($problem_writeup['id']!=$id){
        
            echo "<tr>";
            echo "<td><a href='writeup_view.php?writeup_id={$problem_writeup['id']}'><p style='margin-left:10px; font-size: 23px;'>{$problem_writeup['title']}</p></a></td>";
            echo "<td>{$row['type']}</td>";
            echo "</tr>";
            $row_index++;
            
        	}
        }
        ?>
        
        </div>       
    </div>
<? include("footer.php") ?>