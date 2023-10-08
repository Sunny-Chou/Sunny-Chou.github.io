<?php
    session_start ();
    $con = mysqli_connect ( "localhost", "root", ""); 
    if (! $con) { 
    die ( '資料庫連線失敗' . $mysql_error()); 
    }
     mysqli_select_db ( $con,"hefeng"); 
     if (isset($_POST["clientSelection"])){ //選擇店家
         $storeName = $_POST["clientSelection"];
     }else{ //同店家帳號
         $storeName = $_SESSION['mc'];
     }
     if (isset($_POST["methodSelector"])) $sendingMethod = $_POST["methodSelector"];
     if (isset($_POST["sendingDate"])){ $sendingDate = $_POST["sendingDate"];}
     if (isset($_POST["pickUpDate"])){ $pickUpDate = $_POST["pickUpDate"];}
     if (isset($_POST["pickUpTime"])){ $pickUpTime = $_POST["pickUpTime"];}
     if (isset($_POST["ps"])){ $ps = $_POST["ps"];}
     if($storeName == ""){
        echo "<script>alert('新增訂單失敗!必須選擇店家');</script>";
        echo "<script>history.back();</script>";
        mysqli_close($con);
        exit;
     }
     if($sendingMethod == ""){
        echo "<script>alert('新增訂單失敗!必須選擇配送方式');</script>";
        echo "<script>history.back();</script>";
        mysqli_close($con);
        exit;
     }
     if($sendingDate == "" && $pickUpDate == "" && $pickUpTime == ""){
        echo "<script>alert('新增訂單失敗!必須選擇日期');</script>";
        echo "<script>history.back();</script>";
        mysqli_close($con);
        exit;
     }
     if(($pickUpDate != "" && $pickUpTime == "")||($pickUpDate == "" && $pickUpTime != "")){
        echo "<script>alert('新增訂單失敗!日期時間必須完整');</script>";
        echo "<script>history.back();</script>";
        mysqli_close($con);
        exit;
     }
     $g=mysqli_query( $con,"select * from 商品;");
     $gs=mysqli_fetch_array($g);
     $i=0;
     while($gs){
         $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
         if(isset($_POST[$gn])&& $_POST[$gn]==0){
            $i++;
         }
         $gs=mysqli_fetch_array($g);
     }
     $sum =mysqli_query ($con,"select COUNT(*) as nums from 商品 where 單價!=0;");
     $suma =mysqli_fetch_array($sum);
     if($i == $suma['nums']){
        echo "<script>alert('新增訂單失敗!必須選擇商品數量');</script>";
        echo "<script>history.back();</script>";
        mysqli_close($con);
        exit;
     }




    $n=mysqli_query ($con,"select * from 訂單 order by 訂單編號 desc limit 1;"); //取最新一筆訂單
    $na=mysqli_fetch_array($n);

    function dateSet($na){
        $orderNum = strval(date("ymd")); //yymmdd
        $prev = strval($na['訂單編號']);
        if($orderNum == substr($prev,0,6)){  //跟目前最新一筆訂單是同一天下的單 
           $temp = intval(substr($prev, -3))+1; //訂單編號末三碼+1
           if($temp<10){ $t = strval("00".$temp);}
           else if($temp<100){$t = strval("0".$temp);}
           else{$t = strval($temp);}
           $orderNum = $orderNum.$t; 
        }else{   //是當天的第一筆訂單
           $orderNum = $orderNum."001";
        }
        return intval($orderNum);
    }

    $orderNum=dateSet($na);
    $ac = $_SESSION['mc'];
	$result = mysqli_query($con,"select * from 使用者 where 帳號='$ac'");
	$employee = mysqli_num_rows($result); 
    if($employee){
        if($sendingMethod == "byCar"){
        $sql = "INSERT INTO  訂單(訂單編號,配送方式,店家名稱,配送日期,備註,建立的帳號)
                 VALUES ('{$orderNum}',1,'{$storeName}','{$sendingDate}','{$ps}','{$_SESSION['mc']}');";
        }else{
            $pickUpTime = $pickUpDate." ".$pickUpTime.":00";  //合併成datetime格式
            $sql = "INSERT INTO  訂單(訂單編號,配送方式,店家名稱,店取時間,備註,建立的帳號)
                     VALUES ('{$orderNum}',0,'{$storeName}','{$pickUpTime}','{$ps}','{$_SESSION['mc']}');";
        }
        if (!mysqli_query($con,$sql)){
            die('Error: '.mysqli_error($con));
        }
    }else{
        if($sendingMethod == "byCar"){
            $sql = "INSERT INTO  訂單(訂單編號,配送方式,店家名稱,配送日期,備註)
                     VALUES ('{$orderNum}',1,'{$storeName}','{$sendingDate}','{$ps}');";
            }else{
                $pickUpTime = $pickUpDate." ".$pickUpTime.":00";  //合併成datetime格式
                $sql = "INSERT INTO  訂單(訂單編號,配送方式,店家名稱,店取時間,備註)
                         VALUES ('{$orderNum}',0,'{$storeName}','{$pickUpTime}','{$ps}');";
            }
            if (!mysqli_query($con,$sql)){
                die('Error: '.mysqli_error($con));
            }
    }

    $g=mysqli_query( $con,"select * from 商品;");
    $gs=mysqli_fetch_array($g);
    while($gs){
        $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
        if(isset($_POST[$gn])&&$_POST[$gn]>0){
                $n=mysqli_fetch_array(mysqli_query($con,"select * from 商品 where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'"));
                $sql = "INSERT INTO  購買
                        VALUES ('{$orderNum}','{$n['商品名稱']}','{$n['規格']}','{$n['單位']}','{$_POST[$gn]}');";
                if (!mysqli_query($con,$sql)){
                    die('Error: '.mysqli_error($con));
                }
        }
        $gs=mysqli_fetch_array($g);
    }

    echo "<script>alert('新增訂單成功');</script>";
    if($employee){
        echo "<script>window.location.href = 'createOrder.php';</script>";
    }else{
        echo "<script>window.location.href = 'createOrder2.php';</script>";
    }
    mysqli_close($con);
?>

