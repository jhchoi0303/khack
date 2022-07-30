<?
include "header.php";
include "config.php";    
include "util.php";     
?>

   
<?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from lecture";
    
    if (array_key_exists("search_keyword", $_GET)) {  
        $search_keyword = $_GET["search_keyword"];
        $query =  $query . " and title like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }

 ?>



<div class='row'>


        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
  
            $videoid="";
            $val= explode("v=", $row['lecture_url']);
            $videoid = $val[1];
            
            echo "<div class='row'>";
            echo "<div class='nes-container is-rounded is-dark' style='width:400px; height: 600px; margin-right:20px;'>";
            echo "<div class='column'>";
            echo "<h2>";

            echo "<div class='video-image-thumbnail'>";
            echo "<div class='img'>";
            echo "<img src='https://img.youtube.com/vi/{$videoid}/hqdefault.jpg' style='width:150px;height:150px' /></div></div>";
            echo "</h2>";
            
            echo "<div class='column' style='height:250px;'>";
            
            echo "<p>";
            echo "<p><a href='{$row['lecture_url']}'>Click url: {$row['title']}</a></p>";
            echo "<p>{$row['type']}</td>";
            echo "<p style='color:white; text-align:center;'>{$row['content']}</p>";
            
            $stars_count=(int)$row['difficulty'];
            $counts=0;
    
            echo "<p style='color:white'>난이도: ";
            while ($counts<$stars_count){
            	echo"<i class='nes-icon is-small star'></i>";
            	$counts++;
            }
            
           
           
            
            echo "</p>";
            echo "</div>";
            
            
            $sql = "select count(*) as count from lecture_enrollment where lecture_id={$row['id']}";
            $res2 = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_array($res2);
            
            echo "<p style='color:white'>현재 등록된 수강생: {$row2['count']}</p>";

            echo "<form action='lecture_enroll.php' method='post'>";
            
            echo "<input type='hidden' name='lecture_id' value='{$row['id']}'><br>";
            echo "<button class='nes-btn is-primary' type='submit' formmethod='post'>신청 하기</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            $row_index++;
        }
        ?>
</div>

</div>
<? include("footer.php") ?>
