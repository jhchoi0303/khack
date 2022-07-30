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
 		 <form action="problem_list.php" method="get">
       <input style='margin-bottom:20px' type="text" name="search_keyword" placeholder="문제 또는 출제자 닉네임으로 검색">
 </form>
 
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select *, problem.id as problem_id from problem join member where problem.problem_author=member.id";
    
    if (array_key_exists("search_keyword", $_GET)) {  
        $search_keyword = $_GET["search_keyword"];
        $query =  $query . " and title like '%$search_keyword%' or username like '%$search_keyword%'";
    
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
            <th>출제자</th>
            <th>문제명</th>
            <th>종류</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td><a href='problem_view.php?problem_id={$row['problem_id']}'>{$row['title']}</a></td>";
            echo "<td>{$row['type']}</td>";
            echo "<td width='17%'>
            <div class='row'>
                <a href='problem_form.php?problem_id={$row['problem_id']}'><button class='nes-btn' >수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['problem_id']})' class='nes-btn is-warning' >삭제</button>
                 </div>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <a href='problem_form.php'><button class='nes-btn is-primary' >문제 출제</button></a>
    
    
    
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
<? include("footer.php") ?>
