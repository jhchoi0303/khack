<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("member_id", $_GET)) {
    $id = $_GET["member_id"];
    $query = "SELECT * from member where id='$id'";
    $res = mysqli_query($conn, $query);
    
    $query2 = "SELECT * from (select *, solves.id as solves_id, count(member_id) as counts from solves group by member_id) t1 right outer join (select *, member.id as personal_id from member) t2 on ( t1.member_id = t2.personal_id) and t1.member_id =$id;";
    $res2 = mysqli_query($conn, $query2);
    $rank = mysqli_fetch_assoc($res2);
   
 
}
?>
<div class="container">
      <h2 style="margin-bottom: 0;">
        <i class="snes-jp-logo" style="width:80px;" ></i>
        회원 정보
      </h2>
    </div>
  </nav>

  <div class="container" style="margin-bottom: 50px;">

      <div class="col">
       
      </div>
      <div class="col-sm-9 col-xs-12 style='width:300px;'">
        
          <?
        while ($member = mysqli_fetch_assoc($res)) {
        	
        	if($member['id']%4==0){
        		echo "<i style='margin-right:40px;' class='nes-charmander'></i>";
        	}
        	else if($member['id']%4==1)
        	{
        	echo "<i style='margin-right:40px;' class='nes-squirtle'></i>";
        	}
        	else if($member['id']%4==2)
        	{
        	echo "<i style='margin-right:40px;' class='nes-kirby'></i>";
        	}
        	else if($member['id']%4==3)
        	{
        	echo "<i style='margin-right:40px;' class='nes-bulbasaur'></i>";
        	}
        	else{
        	echo "<i style='margin-right:40px;' class='nes-pokeball'></i>";
        	}
        	
        	echo "<div class='nes-balloon from-left style='width:300px;''>";
            echo "<p> 닉네임: {$member['username']}</p>";
            echo "<p style='color: black; width:600px;'> 성별: {$member['gender']}</p>";
            echo "<p style='color: black; width:600px;'> 코멘트: {$member['comments']}</p>";
            echo "<p style='color: black; width:600px;'> 가입날짜: {$member['signup_date']}</p>";
            if ($rank['counts']==0){
            	echo "<p> 워게임 문제 수: 0 </p>";
            }
            else{
            echo "<p> 워게임 문제 수: {$rank['counts']}</p>";
            }
            $row_index++;
        }
        ?>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
  
     <!-- right      -->
      <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="nes-container with-title">
          <h2 style='font-size:30px'class="title">푼 문제 구성</h2>
         
   
      <div id="problem_types" style="width: 900px; height: 500px;"></div>

<?
	$query = "select personal_id,problem_id, type, username from (select type,problem_id,member_id, solves.id as solves_id from solves join problem on solves.problem_id=problem.id) as t1 join (select username, solves.id as solves_id, member.id as personal_id from member join solves on solves.member_id = member.id) t2 on t1.solves_id = t2.solves_id where personal_id=$id;";
    $res = mysqli_query($conn, $query);
    
    $Pwnable=0;
    $WebHack=0;
    $Forensics=0;
    $Cypto=0;
    $Reversing=0;
    $Etc=0;
    
    
    $row_index = 1;
    
    while($types = mysqli_fetch_assoc($res)){
    	
    	$result = $types['type'];
    	
   

    	
    	if(strpos($result,"Pwnable")!== false){
    		$Pwnable++;
    	}
    	else if(strpos($result,"Web Hack")!== false){
    		$WebHack++;
    	}
    	else if(strpos($result,"Forensics")!== false){
    		$Forensics++;
    	}
    	else if(strpos($result,"Crypto")!== false){
    		$Crypto++;
    	}
    	else if(strpos($result,"Etc")!== false){
    		$Etc++;
    	}
    	else if(strpos($result,"Reversing")!== false){
    		$Reversing++;
    	}
    	$row_index++;
    }
 
    
    
?>


      <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
      <script type="text/javascript"> google.load("visualization", "1", {packages:["corechart"]}); 
      
      google.setOnLoadCallback(drawChart); 
      
      function drawChart() { 
      var Pwnable = '<?= $Pwnable ?>';
      var WebHack = '<?= $WebHack ?>';
      var Forensics = '<?= $Forensics ?>';
      var Crypto = '<?= $Crypto ?>';
      var Reversing = '<?= $Reversing ?>';
      var Etc = '<?= $Etc ?>';
      var count = '<?= $rank['counts']?>';
      var P = (Pwnable / (Pwnable+WebHack+Forensics+Crypto+Reversing+Etc)) * 100; 
      var W = (WebHack / (Pwnable+WebHack+Forensics+Crypto+Reversing+Etc)) * 100; 
      var F = (Forensics / (Pwnable+WebHack+Forensics+Crypto+Reversing+Etc)) * 100; 
      var C = (Crypto / (Pwnable+WebHack+Forensics+Crypto+Reversing+Etc)) * 100; 
      var R = (Reversing / (Pwnable+WebHack+Forensics+Crypto+Reversing+Etc)) * 100; 
      console.log(R);
      var E = (Etc / (Pwnable+WebHack+Forensics+Crypto+Reversing+Etc)) * 100; 
      
      if(count==0){
      	document.getElementById("problem_types").innerHTML = "푼 문제 가 없어 집계를 낼 수 없습니다!";
      }
      
  else{
      var data = google.visualization.arrayToDataTable( [["Types","Rate"],["Pnwable",P],["Webhacking",W],["Forensics",F],["Crypto",C],["Reversing",R],["Etc",E]] ); 
      var chart = new google.visualization.PieChart(document.getElementById("problem_types")); 
      chart.draw(data); 
      } 
      }
      </script>
        
</div>
       
  </div>






</div>

        



        
        
<? include("footer.php") ?>