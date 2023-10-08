<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>進貨</title>
        <style>
            body {
                width: 100%;
                height: 100%;
                max-width: 960px;		
                margin: 0 auto; 
                padding: 0px;
                font-family: 標楷體;
                color:navy;
            }
            main{
                width:100%;
                text-align: center;
                background-color: AliceBlue;
            }
            header{
                text-align: center;
                color:white;
                background-color: navy;
            }
            p{
                display: inline-block;
            }
        </style>
    </head> 
    <body>
        <main>
            
            <form name="form" method="post" action="jinhuo4.php">
            <?php
            session_start ();
            $con = mysqli_connect ( "localhost", "root", ""); 
            if (! $con) { 
            die ( '資料庫連線失敗' . $mysql_error()); 
            }
            mysqli_select_db ( $con,"hefeng");
            if(!$_SESSION['mc']){
                mysqli_close ( $con ); 
                echo "<script>window.location.href='index.html'</script>";
            }else if(mysqli_fetch_array(mysqli_query( $con,"select * from 店家 where 店家名稱='{$_SESSION['mc']}';"))){
                mysqli_close ( $con );
                echo "<script>window.location.href='clientFunctionSelect.php'</script>";
            }
            echo "<header><h1>",mysqli_fetch_array(mysqli_query ( $con,"select * from 補貨單 where 補貨單編號='{$_POST['a']}';"))['補貨的廠商'],"補貨單</h1></header>";
            $a = mysqli_fetch_array(mysqli_query ( $con,"select * from 補貨單 where 補貨單編號='{$_POST['a']}';"));
            $d=mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$a['補貨的廠商']}';"));
            echo "<p>補貨單編號：",$a['補貨單編號'],"<br>","補貨的廠商：",$a['補貨的廠商'],"<br>聯絡人員：",$d['聯絡人員'],"<br>聯絡電話：",$d['聯絡電話'],"<br>";
            if($a['車牌']==null){
                echo "補貨方式：到店補貨<br>";
            }else{
                echo "地址：",$d['店家地址'],"<br>補貨方式：派車補貨<br>車牌：",$a['車牌'],"<br>";
                $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 貨車 where 車牌='{$a['車牌']}';"));
                echo "司機：",$che['司機'],"<br>派車時間：",$a['派車時間'],"<br>";
            }
            $g=mysqli_query ( $con,"select * from 商補 where 補貨單編號='{$_POST['a']}';");
            $ga=mysqli_fetch_array($g);
            echo "補貨商品：<br>";
            while($ga){
                echo $ga['商品名稱']," ";
                if($ga['規格']){
                    echo $ga['規格']," ";
                }
                echo $ga['補貨商品數量'],$ga['單位'],"<br>";
                $ga=mysqli_fetch_array($g);
            }
            echo "</p><div style='text-align:center'><input type='submit' name='a' value='進貨完成' onclick=",'"',"document.forms['form'].a.value='",$_POST['a'],"'",'"',"></div>";
        ?>
        
        </form>
        <form name="form2" method="post" action="jinhuo2.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 
</body> 
</html>