<div id="main_img_bar">

</div>
    <div id="main_content">
        <div id="best" >
            <h4><b>인기상품</b></h4>
    <ul>

<?php
    $rank = 1;
    $con = mysqli_connect("localhost", "root", "", "product");
    $sql = "select * from inventory order by sale desc limit 2";
    $result = mysqli_query($con, $sql);


    while( $row = mysqli_fetch_array($result) )
    { 
        $product  = $row["product"];        
        $sale = $row["sale"];
        $img_name    = $row["file_name"];
        if($sale != 0) {
?>
                
            <li>
                <span><img src="img/<?=$img_name?>" width="273" height="180"></span>
                <span>순위 : <?=$rank?></span>
                <span>품명 : <?=$product?></span>
                <span>판매량 : <?=$sale?></span>
            </li>
<?php
            }
        $rank++;
    }


    mysqli_close($con);
?>
            </ul>
        </div>
    </div>

