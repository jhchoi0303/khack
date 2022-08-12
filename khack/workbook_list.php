<?
include "header.php";
include "config.php";    
include "util.php";     
?>

<div class="column">
<div class="nes-field is-inline">
 <form action="workbook_list.php" method="get">
 <input style='margin-top:30px; margin-bottom:30px' name="search_keyword" type="text" id="inline_field" class="nes-input is-success" placeholder="workbook 통합검색 (workbook 제목)">
 </form>
</div>
</div>
 

    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * from workbook join workbook_problem,member where workbook.id=workbook_problem.workbook_id and member.id=creator";
    
    if (array_key_exists("search_keyword", $_GET)) {  
        $search_keyword = $_GET["search_keyword"];
        $query =  $query . " and title like '%$search_keyword%' group by(workbook.id)";
    
    }
    $query=$query."group by(workbook.id)";
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    
   
   
    
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>문제집명</th>
            <th>등록자</th>
            <th>난이도</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='workbook_view.php?workbook_id={$row['workbook_id']}'>{$row['title']}</a></td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['difficulty']}</td>";
            echo "<td width='17%'>
                <a href='workbook_form.php?workbook_id={$row['workbook_id']}'><button class='nes-btn' >수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['workbook_id']})' class='nes-btn is-warning'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        
        </tbody>
    </table>
     <a href='workbook_form.php'>연습문제 등록</a>
    <script>
        function deleteConfirm(workbook_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "workbook_delete.php?workbook_id=" + workbook_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
