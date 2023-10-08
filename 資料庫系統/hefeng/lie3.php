<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>備貨</title>
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
            div{
                text-align: center;
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
            <form name="form" method="post" action="beihuodan.php">
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
            if(!isset($_POST['a'])){
                mysqli_close ( $con );
                echo "<script>window.location.href='beihuo2.php'</script>";
            }
            $a = mysqli_fetch_array(mysqli_query ( $con,"select * from 訂單 where 訂單編號='{$_POST['a']}';"));
            $d=mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$a['店家名稱']}';"));
            echo "<header><h1>",mysqli_fetch_array(mysqli_query ( $con,"select * from 訂單 where 訂單編號='{$_POST['a']}';"))['店家名稱'],"訂單</h1></header>";
            echo "<p>訂單編號：",$a['訂單編號'],"<br>","店家名稱：",$a['店家名稱'],"<br>";
            
            if($a['配送方式']==0){
                echo "配送方式：店取<br>店取時間：",$a['店取時間'],"<br>";
            }else{
                echo "配送方式：宅配<br>配送日期：",$a['配送日期'],"<br>地址：",$d['店家地址'],"<br>";;
            }
            echo "備註：",$a['備註'],"<br>訂購人姓名：",$d['聯絡人員'],"<br>聯絡電話：",$d['聯絡電話'],"<br>";
            $finalmoney=0;
            $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$_POST['a']}';");
            $ga=mysqli_fetch_array($g);
            echo "購買商品：<br>";
            while($ga){
                echo $ga['商品名稱']," ";
                if($ga['規格']){
                    echo $ga['規格']," ";
                }
                echo $ga['購買商品數量'],$ga['單位']," ";
                $gg=mysqli_fetch_array(mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';"));
                $money=$ga['購買商品數量']*$gg['單價'];
                $finalmoney+=$money;
                echo "庫存數量:",$gg['庫存數量'],$gg['單位']," 單價：",$gg['單價'],"元 金額：",$money,"元<br>";
                $ga=mysqli_fetch_array($g);
            }
            echo "總金額：",$finalmoney,"元";
            echo "</p><br>";
            echo "<div><input type='submit' value='列印備貨單' name='a' onclick=",'"',"document.forms['form'].a.value='",$_POST['a'],"';",'"',"></div>";
        ?>
        </form>
        <div><form name="form2" method="post" action="lie2.php">
            <input type="submit" value="返回">
        </form></div>
    </main>
<?php
mysqli_close ( $con ); 
?> 
</body> 
</html>