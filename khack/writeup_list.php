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
<div class="column">
 <form action="writeup_list.php" method="get">
       <input style='margin-bottom:20px' type="text" name="search_keyword" placeholder="writeup 검색 (문제 또는 writeup 제목) ">
 </form>
 

    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *, problem.title as problem_title, writeup.id as writeup_id, writeup.title as writeup_title from writeup join member, problem where writeup.writeup_author=member.id and writeup.problem_id=problem.id ";
    
    if (array_key_exists("search_keyword", $_GET)) {  
        $search_keyword = $_GET["search_keyword"];
        $query =  $query . " and writeup.title like '%$search_keyword%' or problem.title like '%$search_keyword% group by writeup.id'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    
  
   
    
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>problem 제목</th>
            <th>writeup 제목</th>
            <th>writeup 작성자</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['problem_title']}</td>";
            echo "<td><a href='writeup_view.php?writeup_id={$row['writeup_id']}'>{$row['writeup_title']}</a></td>";
            echo "<td>{$row['username']}</td>";
            echo "<td width='17%'>
                <a href='writeup_form.php?writeup_id={$row['writeup_id']}'><button class='nes-btn' >수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['writeup_id']})'class='nes-btn is-warning'>삭제</button>
                </td>";
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
<? include("footer.php") ?>
