<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/common.css">
    <link rel="stylesheet" type="text/css" href="./css/list.css">
    
<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["usermoney"])) $usermoney = $_SESSION["usermoney"];
    else $userpoint = "";
?>		

<style>
h3 {
   padding-left: 5px;
   border-left: solid 5px #edbf07;
}
</style>

</head>
<body>
<h3>물품 구매폼</h3>
    <div id="top"><ul id="top_menu">
    <li>
    <?php
     $logged = $username."(".$userid.")님[보유금액 :".$usermoney."]";
?>
        <li><?=$logged?> </li></ul></div>
<form name="buy_form" method="post" action="buy_insert.php">
<?php
    $pname = $_GET["pname"];
    $con = mysqli_connect("localhost", "root", "", "product");
    $sql = "select * from inventory where product='$pname'";
            
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
	$num         = $row["num"];
	$product     = $row["product"];
	$price       = $row["price"];
    $stock       = $row["stock"];
    $sale        = $row["sale"];	  
    $img_name    = $row["file_name"];
    $seller      = $row["seller"];
    mysqli_close($con);
   if($userid == $seller){
       echo("<script>
       alert('자기가 등록한 상품을 구매할수 없습니다.');
	    javascript:self.close()
	   </script>"
       );
   }
   if($stock == 0){
       echo("<script>
       alert('재고가 없는 상품입니다');
	    javascript:self.close()
	   </script>"
       );
}
?>
	    <ul id="list">
            <li>
				<span class="col1">품명</span>
				<span class="col1">판매자</span>
				<span class="col2">이미지</span>
				<span class="col3">가격</span>
				<span class="col4">재고</span>
				<span class="col5">구매 희망수량</span>
                <span class="col5">구매 금액</span>
			</li>
            <li>
				<span class="col1"><?=$product?></span>
				<span class="col1"><?=$seller?></span>
				<span class="col2"><img src="img/<?=$img_name?>" width="100"></span>
				<span class="col3"><?=$price?></span>
				<span class="col4"><?=$stock?></span>
				<span class="col5"><input type="number" max="<?=$stock?>" name="purchase_number" min="1" value="1" onkeyup="cal(this)" onmouseup="cal(this)"></span>
                <span class="col8"></span>
			</li>
    </ul>
<script>
    function cal(obj){
        var val = Number(obj.value);
            if(val>obj.max){
                obj.value = obj.max;
            }
        tempmoney = obj.value * <?=$price?>;
            document.querySelector(".col8").textContent = obj.value * <?=$price?> +"원";
}
    function buyinsert(){
        <?php
        $_SESSION["temp"]=$product;//임시 물품 명 
        $_SESSION["seller"]=$seller;//판매자명
        ?>
        document.buy_form.submit();
    }
    </script>
<ul class="buttons">
    <a href="#"><img src="./img/buy.PNG" onclick="buyinsert()"></a>
    <a href="#"><img src="./img/buyclose.png" onclick="javascript:self.close()"></a>
</ul>    
    
</form>

</body>
</html>