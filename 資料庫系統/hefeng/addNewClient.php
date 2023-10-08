<?php
    session_start ();
    $con = mysqli_connect ( "localhost", "root", ""); 
    if (! $con) { 
    die ( '資料庫連線失敗' . $mysql_error()); 
    }
     mysqli_select_db ( $con,"hefeng"); 
     //$店家名稱="";$店家地址="";$聯絡人員姓名="";$聯絡電話="";
     if (isset($_POST["storeName"])) $storeName = $_POST["storeName"];
     if (isset($_POST["address"])) $address = $_POST["address"];
     if (isset($_POST["name"])) $name = $_POST["name"];
     if (isset($_POST["phone"])) $phone = $_POST['phone'];
     if($storeName == "" || $address == "" || $name == "" || $phone == ""){
        echo "<script>alert('新增店家失敗!欄位必須全部填寫');</script>";
        echo "<script>history.back();</script>";
        mysqli_close($con);
        exit;
     }
     $random=8;
     for ($i=1;$i<=$random;$i=$i+1)
     {
     $c=rand(1,3);
     if($c==1){$a=rand(97,122);$b=chr($a);}
     if($c==2){$a=rand(65,90);$b=chr($a);}
     if($c==3){$b=rand(0,9);}
     //使用$randoma連接$b
     $randoma=$randoma.$b;
     }

     //帳號=手機號碼，密碼=亂數產生
     $sql = "INSERT INTO  店家
             VALUES ('{$storeName}','{$address}','{$name}','{$phone}',0,'{$phone}','{$randoma}');";

    if($storeName != "" && $address != "" && $name != "" && $phone != ""){
        if (!mysqli_query($con,$sql)){
          die('Error: '.mysqli_error($con));
        }
    }


    echo "<script>alert('新增店家成功');</script>";
    echo "<script>window.location.href = 'createOrder.php';</script>";
    mysqli_close($con);
?>