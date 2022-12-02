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
    header("Refresh:5; url=purchase_list.php"); //페이지 새로고침
    if (!$userid )
	{
		echo("<script>
				alert('로그인 후 이용해주세요!');
				history.go(-1);
				</script>
			");
		exit;
	}
    ?>
</header>  
<section>
    <form name="productform" method="get" action="buyform.php">
   	<div id="box">
	    <h3>
	    	구매내역
		</h3>
	    <ul id="list">
				<li>
					<span class="col1">번호</span>
					<span class="col2">품명</span>
					<span class="col3">소비자 주소지</span>
					<span class="col4">물품 개당가격</span>
					<span class="col5">구매 수량</span>
					<span class="col6">구매 가격</span>
				</li>
<?php
	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;
	$con = mysqli_connect("localhost", "root", "", "product");
	$sql = "select * from purchase_list where consumer_name='$userid' order by num desc";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수

	$scale = 8; // 8개까지 보여주기

	if ($total_record % $scale == 0)     
		$total_page = floor($total_record/$scale);      
	else
		$total_page = floor($total_record/$scale) + 1; 
 
	$start = ($page - 1) * $scale; // 1페이지     

	$number = $start +1;
    
    $total_price = 0;
    
   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
   {
       $price=0;
      mysqli_data_seek($result, $i);
      // 가져올 레코드로 위치(포인터) 이동
      $row = mysqli_fetch_array($result);
      // 하나의 레코드 가져오기
       $purchase_product    = $row["purchase_product"];
       $purchase_price      = $row["purchase_price"];
       $purchase_number     = $row["purchase_number"];
       $price += $purchase_price * $purchase_number;
       $total_price += $price;      //페이지 최종 금액
       $consumer_address    = $row["consumer_address"];
       //잔여 배송시간
       $end_delivered       = $row["end_delivered"];
       $today = date('Y-m-d H:i',time());
       $delivery_time = strtotime($end_delivered) - strtotime($today);
       $day = 0; $hour = 0; $minute = 0;
       if($delivery_time > 86400){
           $day = floor($delivery_time / 86400);
           $delivery_time = $delivery_time % 86400;
           if($delivery_time >3600){
               $hour = floor($delivery_time / 3600);
               $delivery_time = $delivery_time % 3600;
               $minute = floor($delivery_time / 60);
           }
           else $minute = floor($delivery_time / 60);
       }
       else {
           if($delivery_time >3600){
               $hour = floor($delivery_time / 3600);
               $delivery_time = $delivery_time % 3600;
               $minute = floor($delivery_time / 60);
           }
           else $minut = floor($delivery_time/60);
       }    
?>
				<li>
					<span class="col1"><?=$number?></span>
					<span class="col2"><?=$purchase_product?></span>
                    <span class="col3"><?=$consumer_address?></span>
                    <span class="col4"><?=$purchase_price?></span>					
					<span class="col5"><?=$purchase_number?></span>
					<span class="col6"><?=$price?>원</span>
                    <?php if($day == 0 && $hour == 0 && $minute == 0){
               ?>
                    <span class="col8">이미 배송이 끝난 상품입니다.</span>
                    <? }else{ ?>
                    
                    <?php }?>
				</li>	
                    <span class="col7">배송까지<?=$day?>일 <?=$hour?>시간 <?=$minute?>분 남았습니다</span>
                <li>
            </li>
<?php
   	   $number++;
   }
   mysqli_close($con);

?>
            <li>
                <span class="col7"><b>출력된 구매내역의 소비 금액 : <?=$total_price?>원</b></span>
            </li>
	    	</ul>
        <!--페이지 - 이전/다음버튼 설정--> 
			<ul id="page_num"> 	
<?php
	if ($total_page>=2 && $page >= 2)	
	{
		$new_page = $page-1;
		echo "<li><a href='purchase_list.php?page=$new_page'>◀ 이전</a> </li>";
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
			echo "<li><a href='purchase_list.php?page=$i'> $i </a><li>";
		}
   	}
   	if ($total_page>=2 && $page != $total_page)		
   	{
		$new_page = $page+1;	
		echo "<li> <a href='purchase_list.php?page=$new_page'>다음 ▶</a> </li>";
	}
	else 
		echo "<li>&nbsp;</li>";
?>
	</ul> <!--페이지설정	끝-->    	
	</div> <!-- board_box -->
    </form>
</section> 

</body>
</html>
