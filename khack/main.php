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
    	<h2># How?</h2>
   <div class="lists">
  <ul class="nes-list is-disc" >
    <li style="font-size:20px">문제 목록에서 문제를 고른다. </li>
    <li style="font-size:20px">문제를 읽고 문제 파일을 분석한다음 플래그(정답)을 찾는다.</li>
    <li style="font-size:20px">플래그 제출하기에서 플래그를 제출한다.</li>
    <li style="font-size:20px">정답이면 점수를 획득한다!</li>
  </ul>
</div>
        </div>
        
        <div class="BigTitle">
        	
        <div class="nes-container with-title is-centered">
  <p class="title" style="font-size:25px">초보자들을 위한 팁</p>
  <p>워게임에는 리버싱 (역공학), 포너블 (시스템 해킹), 웹 해킹, 포렌식, 암호학 등이 있습니다.</p>
</div>
      </div>  
        
        </div>    
        </div>
        
      
        <div class="row">
        	<div class="column" style="width:700px;">
        	
        		<hr>
       
      <h1># Functions</h1>
        	<div class = "BigTitle" style="width:600px;">
        		<div class="nes-table-responsive" style="width:550px;">
  <table class="nes-table is-bordered is-centered" style="width:500px;">
    <thead>
      <tr>
        <th class="board">워게임</th>
        <th class="board">라잇업</th>
        <th class="board">강의</th>
   
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="tiles">사용자들이 추가한 문제를 풀 수 있어요!</td>
        <td class="tiles">문제를 어떻게 풀었는지 풀이를 공유할 수 있어요!</td>
        <td class="tiles">관련 강의를 </br>들을 수 있어요!</td>
      </tr>
      <tr>
      <td class="tiles">직접 문제를 추가할 수 있어요!</td>
      <td class="tiles">다른 사람들의 풀이를 볼 수 있어요!</td>
      <td class="tiles">강의 수강등록을</br> 할 수 있어요!</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
</div>
<div class= "column"> 
<h2># Recent Solvers</h2>	
<div class= "BigTitle" style="width:450px; height=500px;">	
<div class="nes-container is-rounded" style="display:inline-block; width:100%; height:500px;">
  <?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$query = "select * from ( select username, member.id as members from member) t1 join ( select member_id, problem_id, solve_date, title, points ,problem_author, solves.id as id from solves join problem on problem_id = problem.id order by id desc limit 3) t2 on t1.members = t2.member_id;";
$res = mysqli_query($conn, $query);


        $row_index = 1;
   
        while ($recent_solves = mysqli_fetch_assoc($res)) {
        	echo "<div style='display:inline; font-size: 20px; border-radius: 10px; width:100%; margin-bottom:30px; padding:10px; display: inline-block; background-color:#108DE0 ; opacity: 0.8;'>";
            echo "<p style='margin-left:20px; display:inline; font-size: 20px; color: rgba(0, 0, 129, 1);'>{$recent_solves['username']}</p><p style='display:inline; font-size: 18px; color: white;'>이(가)</p><p style='display:inline; font-size: 20px; color: rgba(0, 0, 129, 1);'>'{$recent_solves['title']}'</p><p style='display:inline; font-size: 18px; color: white;'>문제를 풀었습니다</p>";
            $time_gap = time()-strtotime($recent_solves['solve_date']);
            
            $s= $time_gap%60;
            $m= floor(($time_gap%3600)/60);
            $h= floor(($time_gap%86400)/3600);
            $d = floor(($time_gap%2592000)/86400);
            $M = floor($time_gap/2592000);
            
            if($time_gap>86400){
            	echo "<p style='margin-right: 5px; margin-top: 5px; font-size: 20px; float: right; color: rgba(0, 0, 129, 1);'>$d 일 전 </p>";
            }else if($time_gap>3600){
            	echo "<p style='margin-right: 5px; margin-top: 5px; font-size: 20px; float: right; color: rgba(0, 0, 129, 1);'>$h 시간 전</p>";
            } else if($time_gap>60){
            	echo "<p style='margin-right: 5px; margin-top: 5px; font-size: 20px; float: right; color: rgba(0, 0, 129, 1);'>$m 분 전</p>";
            } else if($time_gap>1){
            	echo "<p style='margin-right: 5px; margin-top: 5px; font-size: 20px; float: right; color: rgba(0, 0, 129, 1);'>$s 초 전</p>";
            }echo"</div>";
            $row_index++;
            
        }
        ?>

</div>
    </div>
      </div>

      <div class= "large-column"> 
<div class= "column"> 
<div class= "BigTitle" style="width:350px; height=250px;">	


<div class="nes-container is-dark with-title">
  <p class="title" style="font-size:30px;">Ranking Board</p>

<?
$query2 = "SELECT username, counts from (select member_id, count(member_id) as counts from solves group by member_id) t1 right outer join (select *, member.id as personal_id from member) t2 on ( t1.member_id = t2.personal_id) order by t1.counts desc limit 3;";
$res2 = mysqli_query($conn, $query2);


$row_index = 1;
while ($row = mysqli_fetch_array($res2)) {
  echo "<div style='font-size:18px; font-weight:bold; border-radius: 10px; width:100%; margin-bottom:20px; padding:10px; display: inline-block; border: 20px; '>";
    echo "<tr>";
    if($row_index==1){
      echo"<i class='nes-icon trophy is-small' style='font-size:2em';></i>";
    }
    if($row_index==2 |$row_index==3 | $row_index==4){
      echo"<i class='nes-icon coin is-small' style='font-size:2em';></i>";
    }
    echo "<td><font size='5px'>{$row_index}위 </td>";
    echo "<td>{$row['username']}</td>";
    echo "<td></td>";
    echo"</div>";
    $row_index++;
}
?>


</div>
    </div>

</div>


<section class="nes-container is-dark" style="width: 350px; height:200px;">
  <section class="message-list">

        <div class= "row">
        <img src="assets/profile.jfif" style="width:100px;height:100px;">
          <div class="column">
          <p style="width: 100%; font-size: 20px; color:white; margin-left:30px;">만든이: 최지현</p>
          <p style="width: 100%; font-size: 15px; color:white; margin-left:30px;">디자인: NES-style CSS Framework</p>
</div>
        </div>

        <div class= "row-small">
        <i class="nes-icon facebook" style="margin-right:30px;"></i>
        <i class="nes-icon instagram" style="margin-right:15px;"></i>
        <i class="nes-icon github" style="margin-left:15px;"></i>
</div>


      </section>
    </section>







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