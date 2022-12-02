<meta charset="utf-8">
<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";

    if ( !$userid )
    {
        echo("
                    <script>
                    alert('물품 등록은 로그인 후 이용해 주세요!');
                    history.go(-1)
                    </script>
        ");
        exit;
    }

    $product = $_POST["product"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $delivery_date = $_POST["delivery_date"];
	$product = htmlspecialchars($product, ENT_QUOTES);
	$price = htmlspecialchars($price, ENT_QUOTES);
    $stock = htmlspecialchars($stock, ENT_QUOTES);
	$upfile_name = $_FILES["upfile"]["name"];

	$con = mysqli_connect("localhost", "root", "", "product");
    $sql = "select * from inventory where product='$product'";
    $result = mysqli_query($con, $sql);
    $num_record = mysqli_num_rows($result);

    if ($num_record)//상품명 중복 방지
     {

       echo "
	   <script>
        alert('이미 있는 상품명입니다.')
	    location.href = 'add.php';
	   </script>
	";
     }
     else
     {
        $sql = "insert into inventory (product, sale, seller, price, stock, delivery_date,file_name) ";
	    $sql .= "values('$product', 0, '$userid', $price, $stock,'$delivery_date','$upfile_name')";
         
	mysqli_query($con, $sql);  

	mysqli_close($con);       

	echo "
	   <script>
	    location.href = 'category_list.php';
	   </script>
	";
     }
?>

  
