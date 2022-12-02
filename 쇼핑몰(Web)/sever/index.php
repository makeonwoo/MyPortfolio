<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>쇼핑몰</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/main.css">
   <style>
       input[type=text]{
           margin-left: 0;
           border: 4px solid crimson;
           border-radius: 5px;
           width: 250px;
           height: 30px;
       }
    </style>
<script>
    function check_join(){
       window.open("check_day.php");
}
    function search(){
        if(document.search_form.tag.value == "product")
        location.href ='category_list.php?search_p='+document.search_form.search_p.value;
        else if(document.search_form.tag.value == "price")
        location.href ='category_list.php?search_n='+document.search_form.search_p.value; 
    }
</script>
</head>
<body> 
	<header>
    	<?php include "header.php";?>
    </header>  
    <span id="check_box"><img src ="img/check_join.png" style="margin :0px;" width="100px" onclick="check_join()" ></span>
    <form name="search_form">
    <div id="search_box">

        <select name="tag">
        <option value="product">품명</option>
        <option value="price">가격</option>
        </select>
          <input type="text" name="search_p" width="450px" placeholder="검색어를 입력해주세요"><a href="#"><img src="./img/search.png" onclick="search()"></a>

    </div>
    </form>
	<section>
	    <?php include "main.php";?>
	</section> 

</body>
</html>
