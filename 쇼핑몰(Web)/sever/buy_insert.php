<meta charset="utf-8">
<?php
    session_start();
    $userid = $_SESSION["userid"];
    $product = $_SESSION["temp"];
    $seller = $_SESSION["seller"];

    $_SESSION["temp"]="";
    $_SESSION["seller"]="";

	$con = mysqli_connect("localhost", "root", "", "product");
    $sql = "select * from consumer where id='$userid'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $address = $row["address"];
    $money = $row["money"];

    $sql = "select * from consumer where id='$seller'";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $seller_money = $row["money"];

    $sql = "select * from inventory where product='$product'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    $price = $row["price"];
    $stock = $row["stock"];
    $sale = $row["sale"];
    $delivery_date = $row["delivery_date"];
    $purchase_number =$_POST["purchase_number"];//구매수량

    $total_price = $price * $purchase_number;
    $new_stock = $stock - $purchase_number;
    $new_sale = $sale + $purchase_number;

    if($total_price > $money){
       echo("
        <script>
                    alert('보유한 금액이 부족합니다!');
                    history.go(-2);
                    </script>
       ");
    }
    else
    {
        echo "
	   <script>
       alert('$product 는 배송까지 $delivery_date 일 소요됩니다');
	   </script>
	";
        $new_money=$money-$total_price;
        $sql = "update consumer set money=$new_money where id='$userid'";
        $_SESSION["usermoney"] = $new_money;
        mysqli_query($con, $sql);
        
        $gain = $seller_money + $total_price;
        $sql = "update consumer set money=$gain where id='$seller'";
        mysqli_query($con, $sql);
        
        $sql = "update inventory set stock=$new_stock where product='$product'";
        mysqli_query($con, $sql);
        $sql = "update inventory set sale=$new_sale where product='$product'";
        mysqli_query($con, $sql);
        
        $date_of_purchase = date("Y-m-d H:i");//구매시간
        $delivery_date *= 86400;//배송에 걸리는시간을 초로 변환
        
        $end_delivered = date("Y-m-d H:i",strtotime($date_of_purchase) +$delivery_date);
        
        $sql = "insert into purchase_list(consumer_name, consumer_address, purchase_product, purchase_price, purchase_number, end_delivered) ";
	    $sql .= "values('$userid', '$address', '$product', $price,$purchase_number,'$end_delivered')";
        
        mysqli_query($con, $sql);
        mysqli_close($con);  
        echo "
	   <script>
        javascript:self.close()
	   </script>
	";
    }
?>

  
