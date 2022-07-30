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
    
    	
    	<div class="nes-container with-title" style="margin-bottom: 100px;">
    		<span style="font-size:150%" class="title">문제 정보</span> 
    	<p>
            <label for="problem_title">문제 제목</label>
            <input  size="50" style="text-align:center; border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="problem_title" name="problem_title" value="<?= $writeup['problem_title'] ?>"/>
        </p>
        
        
        <p>
            <label for="problem_info">
            	<a href='problem_view.php?problem_id=<?= $writeup['id'] ?>'>문제 url (클릭) </a>
            </label>
            
        </p>
    	</div>
    	
<div class="nes-container with-title">
        <h2 style="margin-bottom:10px;">writeup 본문</h2>

        <p>
            <label for="writeup_id">writeup 번호</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="writeup_id" name="writeup_id" value="<?= $writeup['writeup_id'] ?>"/>
        </p>
        
        

        <p>
            <label for="writeup_author">작성자</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="member_id" name="member_id" value="<?= $writeup['username'] ?>"/>
            
            
            <label for="title">writeup 제목</label>
            <input  size="8" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly type="text" id="title" name="title" value="<?= $writeup['writeup_title'] ?>"/>
            
            </p>
 
<p class="c3">
 
            <label for="content">설명</label>
            <textarea  size="100" style="margin-left:20px;" readonly type="text" id="content" name="content" ><?= $writeup['content'] ?></textarea>
        </p>

    </div>
        
        
        <p> 
        <label for="other_title"> <h3>Other Write-ups for <?=$writeup['problem_title']?></h3> </label>
        </p>
        
        <?
        $query = "select writeup.id, writeup.title from writeup join problem where problem_id =(select problem_id from writeup join problem where writeup.problem_id=problem.id and writeup.id = $id) group by writeup.id";
        $res = mysqli_query($conn, $query);
   
       
        $row_index = 1;
        while ($problem_writeup = mysqli_fetch_assoc($res)) {
        	
        if($problem_writeup['id']!=$id){
        
            echo "<tr>";
            echo "<td><a href='writeup_view.php?writeup_id={$problem_writeup['id']}'>{$problem_writeup['title']}</a></td>";
            echo "<td>{$row['type']}</td>";
            echo "</tr>";
            $row_index++;
            
        	}
        }
        ?>
        
        
    </div>
<? include("footer.php") ?>