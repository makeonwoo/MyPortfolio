
<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["usermoney"])) $usermoney = $_SESSION["usermoney"];
    else $usermoney = "";
?>		

    <div id="top_color">
        <div id="top">
            <h3>
                <a href="index.php" id="title">쇼핑몰</a>
            </h3>
            <ul id="top_menu">  
<?php
    if(!$userid) {
?>                
                <li><a href="member_form.php">회원 가입</a> </li>
                <li> | </li>
                <li><a href="login_form.php">로그인</a></li>
                
<?php
    } else {
                $logged = $username."(".$userid.")님[보유금액 :".$usermoney."원]";
?>
                <li><?=$logged?> </li>
                <li> | </li>
                <li><a href="logout.php">로그아웃</a> </li>
            </ul>
        </div>
<?php
    }
?>
            
        </div>
        <div id="menu_bar">
            <ul>  
                <li><a href="index.php">HOME</a></li>
                <hr>
                <li><a href="category_list.php">물품 목록</a></li>      
                <hr>
                <li><a href="purchase_list.php">구매내역</a></li>
                <hr>
                <li><a href="add.php">물품 등록</a></li>

            </ul>
        </div>
        