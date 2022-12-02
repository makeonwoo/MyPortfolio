<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 프로젝트</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/list.css">

</head>
<body> 
<header>
    
    <?php include "header.php";
    $count = isset($_GET["search_p"]);
    $count2 = isset($_GET["search_n"]);
    if(!$count){
        if(!$count2)
            header("Refresh:5; url=category_list.php?");
        else
            $search_n=$_GET["search_n"];
    }
    else $search_p=$_GET["search_p"];
    
    ?>
</header>  
    <script>
    function buy(){
        <?php
        if(isset($_SESSION["userid"])){
            ?>
            window.open("buyform.php?pname="+document.productform.pname.value,"",
                    "left=100,top=600,width=950,height=700,scrollbars=no,resizable=yes");
        <?php
        } else {
            ?>
            alert("로그인후 이용해주세요");
        <?php
        }
        ?>
            
   }
    </script>
<section>
    <form name="productform" method="get" action="buyform.php">
   	<div id="box">
	    <h3>
	    	물품 목록
        </h3>
	    <ul id="list">
				<li>
					<span class="col1">번호</span>
					<span class="col2">이미지</span>
					<span class="col3">품명</span>
					<span class="col4">가격</span>
					<span class="col5">재고</span>
					<span class="col6">판매량</span>
				</li>
<?php
    
	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;
    if(!$count){
        if(!$count2){
	$con = mysqli_connect("localhost", "root", "", "product");
	$sql = "select * from inventory order by num desc";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수
    if($total_record == 0)
        echo("등록된 상품이 없습니다");
    
        }
        else{
           $con = mysqli_connect("localhost", "root", "", "product");
	       $sql = "select * from inventory where price =$search_n";
	       $result = mysqli_query($con, $sql);
	       $total_record = mysqli_num_rows($result); // 전체 글 수
        if($total_record == 0)
        echo("검색된 $search_n  가격의 상품이 없습니다");
        else echo("검색하신 $search_n 의 가격을 가진 상품입니다.");
        }
    }
    else{
    $con = mysqli_connect("localhost", "root", "", "product");
	$sql = "select * from inventory where product ='$search_p'";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수
        if($total_record == 0)
        echo("검색된 $search_p 의 상품명을 가진 상품이 없습니다");
        else echo("검색하신$search_p 의 상품명을 가진 상품입니다.");
    }
            
	$scale = 5; // 5개까지 보여주기

	if ($total_record % $scale == 0)     
		$total_page = floor($total_record/$scale);      
	else
		$total_page = floor($total_record/$scale) + 1; 
 
	$start = ($page - 1) * $scale; // 1페이지 -    

	$number = $total_record - $start;
    
   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
   {
      mysqli_data_seek($result, $i);
      // 가져올 레코드로 위치(포인터) 이동
      $row = mysqli_fetch_array($result);
      // 하나의 레코드 가져오기
	  $num         = $row["num"];
	  $product     = $row["product"];
	  $price       = $row["price"];
      $stock       = $row["stock"];
      $sale        = $row["sale"];	  
      $img_name    = $row["file_name"];

?>
				<li>
					<span class="col1"><?=$number?></span>
					<span class="col2"><img src="img/<?=$img_name?>" width="100px" height="55px"></span>
                    <span class="col3"><?=$product?></span>
					<span class="col4"><?=$price?></span>
					<span class="col5"><?=$stock?></span>
					<span class="col6"><?=$sale?></span>
                    <input type="radio" name="pname" value="<?=$product?>" checked>
				</li>	
<?php
   	   $number--;
   }
   mysqli_close($con);

?>
	    	</ul>
        <!--페이지 - 이전/다음버튼 설정--> 
			<ul id="page_num"> 	
<?php
	if ($total_page>=2 && $page >= 2)	
	{
		$new_page = $page-1;
		echo "<li><a href='category_list.php?page=$new_page'>◀ 이전</a> </li>";
	}		
	else 
		echo "<li>&nbsp;</li>";

   	// 목록 하단에 페이지 링크 번호 출력
   	for ($i=1; $i<=$total_page; $i++)
   	{
		if ($page == $i)     // 현재 페이지 번호 링크 안함
		{
			echo "<li><b> $i </b></li>";
		}
		else
		{
			echo "<li><a href='category_list.php?page=$i'> $i </a><li>";
		}
   	}
   	if ($total_page>=2 && $page != $total_page)		
   	{
		$new_page = $page+1;	
		echo "<li> <a href='category_list.php?page=$new_page'>다음 ▶</a> </li>";
	}
	else 
		echo "<li>&nbsp;</li>";
?>
			</ul> <!--페이지설정	끝-->    	
			<ul class="buttons">
                <a href="#"><img src="./img/buy.PNG" onclick="buy()"></a>                
			</ul>
	</div> <!-- board_box -->
    </form>
</section> 

</body>
</html>
