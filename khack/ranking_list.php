<?
include "header.php";
include "config.php";    
include "util.php";     
?>


 

 

    
    <div class="column">
    
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * from member";
    
   
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    
    ?>
    
 <form style='margin-top:50px; margin-bottom:50px;'>
 	<p style="font-size:15px; color:black;">옵션을 클릭해주세요:</p>
    <input type="button" class="nes-btn is-primary" onclick="showHide('hidethis')" value="전체 회원" /> 
       <input type="button" class="nes-btn is-success" onclick="showHide('hidethis2')" value="푼 문제 순위"/> 
      <input type="button" class="nes-btn is-warning" onclick="showHide('hidethis3')" value="출제한 문제 순위"/>
    
       </form>
    
    <script>
    function showHide(divId) {
    	$('.hidden-div').each(
    		function() {
    			$(this).hide();
    			}
    			);
    $("#"+divId).show();

    }
    </script>
    
    <div id="hidethis" style='width:80%; margin-bottom:200px;'class="hidden-div">
   
<div class="outer">
<div class="row" style="text-align: center;">
	<i style='margin-left:10px;'class="nes-icon is-large like"></i>
	
<table class="table table-striped table-bordered">
        <thead>
        <tr>
        <th style='width:50px; font-size:20px;' >번호  </th>
        <th style='width:50px; font-size:20px;' >유저네임(클릭해보세요!)  </th>
        <th style='width:50px; font-size:20px;' >Comments  </th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><font size='5px'>{$row_index}</font></td>";
            echo "<td><a href='ranking_info.php?member_id={$row['id']}'><font size='4px'>{$row['username']}</font></a></td>";
            echo "<td><font size='4px'>{$row['comments']}</font></a></td>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
</div>
  </div>

</div>
    
    
  
    
    <?
    $query = "SELECT username, counts from (select member_id, count(member_id) as counts from solves group by member_id) t1 right outer join (select *, member.id as personal_id from member) t2 on ( t1.member_id = t2.personal_id) order by t1.counts desc;";
    $res = mysqli_query($conn, $query);

    ?>
    
    
    
    
    
     <div id="hidethis2"  style='width:80%; margin-bottom:200px;' class="hidden-div">

      
<div class="outer">
<div class="row" style="text-align: center;">
  <i class="nes-icon trophy is-large"></i>
   <table class="table table-striped table-bordered" style="width:60%; margin-right:40px;">
        <thead>
        <tr>
        <th style='width:50px; font-size:20px;' >순위</th>
        <th style='width:50px; font-size:20px;' >유저 네임 </th>
        <th style='width:50px; font-size:20px;' >푼 문제 수 </th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><font size='5px'>{$row_index}</font></td>";
            echo "<td><font size='5pt'>{$row['username']}</font></td>";
            if($row['counts']==0){
            	 echo "<td><font size='5px'>0</font></td>";
            }
            else{
            echo "<td><font size='5px'>{$row['counts']}</font></td>";
            }
            $row_index++;
        }
        ?>
        </tbody>
    </table>
</div>
  </div>


  </div>

    
    
    
   
  
   






    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT username, counts from (select problem_author, count(problem_author) as counts from problem group by problem_author) t1 right outer join (select *, member.id as member_id from member) t2 on ( t1.problem_author = t2.member_id) order by t1.counts desc;";
    $res = mysqli_query($conn, $query);
    ?>
    
    
    
    
     <div id="hidethis3"  style='width:80%; margin-bottom:200px;' class="hidden-div">

    
      <div class="outer">
<div class="row" style="text-align: center;">
	 <i class="nes-icon coin is-large"></i>
<table class="table table-striped table-bordered" style="width:60%;margin-right:40px;">
        <thead>
        <tr>
            <th style='width:50px; font-size:20px;' >순위</th>
            <th style='width:100px; font-size:20px;'>유저 네임 </th>
            <th style='width:50px; font-size:20px;' >출제 문제 수 </th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><font size='5px'>{$row_index}</font></td>";
            echo "<td><font size='5px'>{$row['username']}</font></td>";
            if($row['counts']==0){
            	 echo "<td><font size='5px'>0</font></td>";
            }
            else{
            echo "<td><font size='5px'>{$row['counts']}</font></td>";
            }
            $row_index++;
        }
        ?>
        
        </div>
        
        </div>
        </tbody>
    </table>
</div>
  </div>


  </div>
  </div>







<? include("footer.php") ?>
