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

  
<div class="nes-field is-inline">
 <form action="writeup_list.php" method="get">
 <div class="row">
 <input style='margin-top:30px; margin-bottom:30px' name="search_keyword" type="text" id="inline_field" class="nes-input is-success" placeholder="writeup 검색 (writeup 제목) ">
 <button type="submit" style="font-size: 13px; margin-left: 20px; height:40px; width: 50px;" onclick="javascript:return validate();" class="nes-btn is-success">검색</button>
</div> 
</form>
</div>
 <script>
    function validate(){
    if(document.getElementById("inline_field").value.length == 0)
{
    alert("검색어를 입력해주세요");
    window.location = "/writeup_list.php";
}
}
    </script>

    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *, problem.title as problem_title, writeup.id as writeup_id, writeup.title as writeup_title from writeup join member, problem where writeup.writeup_author=member.id and writeup.problem_id=problem.id";
    $query2 = $query. " order by writeup_id asc";
    if (array_key_exists("search_keyword", $_GET)) {  
        $search_keyword = $_GET["search_keyword"];
        if($search_keyword){
        $query2 =  $query . " and writeup.title like '%$search_keyword%' order by writeup_id asc";
        }
    
    }
    $res = mysqli_query($conn, $query2);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    
  
    <div class = "column">   
    
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th style="font-size:25px;">No.</th>
            <th style="width:100px; font-size:25px;">problem</br>제목</th>
            <th style="font-size:25px;">writeup</br>제목</th>
            <th style="font-size:25px;">writeup</br>작성자</th>
            <th style="font-size:25px;">기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><font size='5em'>{$row_index}</font></td>";
            echo "<td><font size='4px'>{$row['problem_title']}</font></td>";
            echo "<td><a href='writeup_view.php?writeup_id={$row['writeup_id']}'><font size='4px'>{$row['writeup_title']}</font></a></td>";
            echo "<td><font size='4px'>{$row['username']}</font></td>";
            echo "<td width='17%'>";
            echo "<div class='row'>";
            echo "<a href='writeup_form.php?writeup_id={$row['writeup_id']}'><button class='nes-btn' >수정</button></a>";
            echo " <button onclick='javascript:deleteConfirm({$row['writeup_id']})'class='nes-btn is-warning'>삭제</button>";
            echo "</div>";
                 echo "</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>  
    <a href='writeup_form.php'><button class='nes-btn is-primary'>writeup 등록</button></a>
    <script>
        function deleteConfirm(writeup_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "writeup_delete.php?writeup_id=" + writeup_id;
            }else{   //취소
                return;
            }
        }
    </script>
    </div>
</div>
    </div>
    </div>
    </div>
<? include("footer.php") ?>
