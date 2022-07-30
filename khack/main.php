<?php include ("header.php"); ?>

    <div class = "container">
    	
    	
    	<div class = "column">
    	<div class = "row">
    	<div class="BigTitle">
    	<h2># About</h2>
    	<section class="nes-container is-dark">
    		<section class="message-list">
    			<section class="message -left">
    
        <!-- Balloon -->
        <div class="nes-balloon from-left is-dark">
        	<p>이 웹사이트는 어떤 용도인가요?</p>
        	</div>
      </section>

      <section class="message -right"style="text-align: right;">
        <!-- Balloon -->
        <div class="nes-balloon from-right is-dark" style="text-align:left;">
          <p>해킹 문제 연습사이트 입니다. "워게임" 사이트라고도 하죠.</p>
        </div>
        <i class="nes-bcrikko"></i>
        </div>
        
        
        <div class= "column">
        <div class="BigTitle">
    	<h3># How?</h3>
   <div class="lists">
  <ul class="nes-list is-disc">
    <li>문제 목록에서 문제를 고른다. </li>
    <li>문제를 읽고 문제 파일을 분석한다음 플래그(정답)을 찾는다.</li>
    <li>플래그 제출하기에서 플래그를 제출한다.</li>
    <li>정답이면 점수를 획득한다!</li>
  </ul>
</div>
        </div>
        
        <div class="BigTitle">
        	
        <div class="nes-container with-title is-centered">
  <p class="title">초보자들을 위한 팁</p>
  <p>워게임에는 리버싱 (역공학), 포너블 (시스템 해킹), 웹 해킹, 포렌식, 암호학 등이 있습니다.</p>
</div>
      </div>  
        
        </div>    
        </div>
        
      
        <div class="row">
        	<div class="column">
        	
        		<hr>
       
      <h1># Functions</h1>
        	<div class = "BigTitle">
        		<div class="nes-table-responsive">
  <table class="nes-table is-bordered is-centered">
    <thead>
      <tr>
        <th>워게임</th>
        <th>연습문제집 </th>
        <th>라잇업</th>
        <th>강의</th>
   
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>사용자들이 추가한 문제를 풀 수 있어요!</td>
        <td>연습문제집을 직접 등록 할 수 있어요!</td>
        <td>문제를 어떻게 풀었는지 풀이를 공유할 수 있어요!</td>
        <td>관련 강의를 들을 수 있어요!</td>
      </tr>
      <tr>
        <td>직접 문제를 추가할 수 있어요!</td>
        <td>다른 사람들의 연습 문제집을 볼 수 있어요!</td>
        <td>다른 사람들의 풀이를 볼 수 있어요!</td>
        <td>강의 수강등록을 할 수 있어요!</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
</div>
        		
<div class= "BigTitle" height="200px;"><h2># Recent Solvers</h2>
<div class="nes-container is-dark with-title" style="display:inline-block; height:500px;">
  <?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$query = "select * from ( select username, member.id as members from member) t1 join ( select member_id, problem_id, solve_date, title, points ,problem_author, solves.id as id from solves join problem on problem_id = problem.id order by id desc limit 5) t2 on t1.members = t2.member_id;";
$res = mysqli_query($conn, $query);


        $row_index = 1;
   
        while ($recent_solves = mysqli_fetch_assoc($res)) {
        	echo "<div style='border-radius: 10px; width:100%; margin-bottom:20px; padding:10px; display: inline-block; background-color:#108DE0 ; opacity: 0.8;'>";
            echo "{$recent_solves['username']}이(가) ' {$recent_solves['title']} ' 문제를 풀었습니다";
            $time_gap = time()-strtotime($recent_solves['solve_date']);
            
            $s= $time_gap%60;
            $m= floor(($time_gap%3600)/60);
            $h= floor(($time_gap%86400)/3600);
            $d = floor(($time_gap%2592000)/86400);
            $M = floor($time_gap/2592000);
            
            if($time_gap>86400){
            	echo "<p style='float: right; color: white;'>$d 일 전 </p>";
            }else if($time_gap>3600){
            	echo "<p style='float: right; color: white;'>$h 시간 전</p>";
            } else if($time_gap>60){
            	echo "<p style='float: right; color: white;'>$m 분 전</p>";
            } else if($time_gap>1){
            	echo "<p style='float: right; color: white;'>$s 초 전</p>";
            }echo"</div>";
            $row_index++;
            
        }
        ?>

</div>
    </div>
        </div> 
        </div>      
      </section>
    </section>
  </section>
</section>
   </div>
   
</div>   </body>
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
    
    
<?php include ("footer.php"); ?>