<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>shop</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/list.css">
<style>
    input[type=text] { width: 500px; height: 25px; border: 2px solid skyblue; border-radius: 5px;}
    input[type=number] { width: 150px; height: 25px; border: 2px solid skyblue; border-radius: 5px;
    }
    </style>
<script>
  function check_input() {
      if (!document.add_form.product.value)
      {
          alert("품명을 입력하세요!");
          document.add_form.product.focus();
          return;
      }
            if (!document.add_form.price.value)
      {
          alert("가격을 입력하세요!");
          document.add_form.price.focus();
          return;
      }
            if (!document.add_form.stock.value)
      {
          alert("재고를 입력하세요!");
          document.add_form.stock.focus();
          return;
      }
      if (!document.add_form.delivery_date.value)
      {
          alert("배송에 걸리는 시간을 입력하세요!");
          document.add_form.delivery_date.focus();
          return;
      }
      
      document.add_form.submit();
   }
    function cal(obj){
        var val = Number(obj.value);
            if(val>obj.max){
                obj.value = obj.max;
            }
}
</script>
</head>
<body> 
<header>
    <?php include "header.php";
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

   	<div id="box">
	    <h3>
	    		물품 등록
		</h3>
	    <form name="add_form" method="post" action="add_insert.php" enctype="multipart/form-data">
	    	 <ul id="add_form">
				<li>
					<span class="col1">품명 : </span>
					<span class="col2"><input name="product" type="text" width="500px" height="25px"></span>
				</li>		
	    		<li>
	    			<span class="col1">가격 : </span>
	    			<span class="col2"><input name="price" type="text"></span>
	    		</li>	    	
	    		<li>	
	    			<span class="col1">재고 : </span>
	    			<span class="col2"><input name="stock" type="text"></span>
	    		</li>
                 <li>	
	    			<span class="col1">배송일 : </span>
	    			<span class="col2"><input name="delivery_date" type="number" max="30" min="1" placeholder="30일 이내로 입력" onkeyup="cal(this)" onmouseup="cal(this)"> 일</span>
	    		</li>
	    		<li>
			        <span class="col1">물품 이미지</span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">완료</button></li>
				<li><button type="button" onclick="location.href='category_list.php'">목록</button></li>
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
</body>
</html>
