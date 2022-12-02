 <?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["usermoney"])) $usermoney = $_SESSION["usermoney"];
    else $userpoint = "";

        $save_now = date("Y-m-d H:i");
        $con = mysqli_connect("localhost", "root", "", "product");
        $sql = "select * from check_user where user_id='$userid'";
        $result = mysqli_query($con, $sql);
        $total_record = mysqli_num_rows($result);

        $count_today=0;
        echo($count_today);
        for($i=0; $i<$total_record; $i++)
        {
        mysqli_data_seek($result, $i);
        $row = mysqli_fetch_array($result);
        $dday = strtotime($row['regist_day']);
        $now = date("Y-m-d H:i:s");
        $now = strtotime($now);

        $now -= $now % 60; 
        echo("<br>$now <br> $dday <br>");
        if ($now == $dday) {
            $count_today++; 
            echo($count_today);}
        }

        if($count_today==0){
            $sql = "insert into check_user(user_id, regist_day)";
            $sql .= "values('user1','$save_now')";
            echo($sql);
            $result = mysqli_query($con, $sql);
            $new_money = $_SESSION["usermoney"]+10;
            
            $sql = "update consumer set money=$new_money where id='$userid'";
            $result = mysqli_query($con, $sql);
            $_SESSION["usermoney"] = $new_money;
           echo("<script>
           alert('출석하였습니다 +10원');
           javascript:self.close();
           </script>
           ");
            
        }
        
        else{
          
           echo("<script>
           alert('이미 출석하였습니다 1분후에 다시출석해주세요');
           javascript:self.close();
           </script>
           ");

        }
?>
         
