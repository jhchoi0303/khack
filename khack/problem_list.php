<?
include "header.php";
include "config.php";    
include "util.php"; 
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}

?>


<div class = "column">
<div class="wrapper block" style="padding: 100px; width: 60%; margin-top:20px;">
  <p class="title">
  
<div class="nes-field is-inline">
    
<form action="problem_list.php" method="get">
<div class="row">
  <input style='margin-top:30px; margin-bottom:30px' name="search_keyword" type="text" id="inline_field" class="nes-input is-success" placeholder="문제 제목이나 출제자 아이디를 입력해보세요">
  <button type="submit" style="font-size: 13px; margin-left: 20px; height:40px; width: 50px;" onclick="javascript:return validate();" class="nes-btn is-success">검색</button>
</div>
</div>

<script>
    function validate(){
    if(document.getElementById("inline_field").value.length == 0)
{
    alert("검색어를 입력해주세요");
    window.location = "/problem_list.php";
}
}
    </script>

    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *, problem.id as problem_id from problem join member where problem.problem_author=member.id";
    
    if (array_key_exists("search_keyword", $_GET)) {  
        $search_keyword = $_GET["search_keyword"];
        if($search_keyword){

            $query =  $query . " and title like '%$search_keyword%' or username like '%$search_keyword%'";

        }
        
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
   </p> 
   
    <div class = "column">    
    <table class="list-table">
        <thead>
        <tr>
            <th style="font-size:25px;">No.</th>
            <th style="font-size:20px;">출제자</th>
            <th style="font-size:20px;">문제명</th>
            <th style="font-size:25px;">종류</th>
            <th style="font-size:25px;">기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td style='width:17%'><font size='5px'>{$row_index}</font></td>";
            echo "<td style='width:17%'><font size='5px'>{$row['username']}</font></td>";
            echo "<td width='53%'><a href='problem_view.php?problem_id={$row['problem_id']}'><font size='4px'>{$row['title']}</font></a></td>";
            echo "<td><font size='5px'>{$row['type']}</font></td>";
            echo "<td style='width:17%'>";
            echo "<div class='row'>";
            echo "<a href='problem_form.php?problem_id={$row['problem_id']}' class='nes-btn'>수정</a>";
            echo "<a href='javascript:deleteConfirm({$row['problem_id']})'class='nes-btn' >삭제</a>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <a href='problem_form.php' class='nes-btn'>문제 출제</a>
    
    
    
    	</div>
    <script>
        function deleteConfirm(problem_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "problem_delete.php?problem_id=" + problem_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
    </div>

<? include("footer.php") ?>
