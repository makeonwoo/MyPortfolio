<?php
    $id   = $_POST["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $address  = $_POST["address"];
   

              
    $con = mysqli_connect("localhost", "root", "", "product");

	$sql = "insert into consumer(id, pass, name, address,  money) ";
	$sql .= "values('$id', '$pass', '$name', '$address', 100000)";

	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'index.php';
	      </script>
	  ";
?>

   
