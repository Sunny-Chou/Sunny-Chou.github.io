<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>列印補貨單</title>
        <style>
            body {
                color:navy;
            }
            main{
                width:100%;
                text-align: center;
                font-family: 標楷體;
            }
            div{
                text-align:center;
                float:left;
            }
        </style>
        <link href="print.css" media="print">
    </head> 
    <body>
        <main>
            <form name="form" method="post" action="qianshou3.php">
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
                echo "<script>window.location.href='buhuo.php'</script>";
            }
            echo"<div><table style='white-space: pre-wrap;border:3px Navy solid;'border='1'><thead><tr><th colspan='6'>補貨單</th></tr></thead>";
            $a = mysqli_query ( $con,"select * from 補貨單 where 補貨單編號='{$_POST['a']}';");
            $aa=mysqli_fetch_array($a);
            echo "<tr><th>車牌</th><th>",$aa['車牌'],"</th>";
            $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 貨車 where 車牌='{$aa['車牌']}';"));
            if($aa['車牌']){
                echo "</th><th>司機</th><th>",$che['司機'],"</th><th>派車時間</th><th>";
            }else{
                echo "</th><th>司機</th><th></th><th>派車時間</th><th>";
            }
            echo $aa['派車時間'],"</th></tr>";
            $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$aa['補貨的廠商']}';"))['店家地址'];
            echo "<tr><th>補貨單編號</th><th>店名</th><th>地址</th><th colspan='3'>補貨內容</th></tr><tr><td>",$_POST['a'],"</td><td>",$aa['補貨的廠商'],"</td><td>",$che,"</td><td colspan='3'>";
            $g=mysqli_query ( $con,"select * from 商補 where 補貨單編號='{$aa['補貨單編號']}';");
            $ga=mysqli_fetch_array($g);
            while($ga){
                echo $ga['商品名稱']," ";
                if($ga['規格']){
                    echo $ga['規格']," ";
                }
                echo $ga['補貨商品數量'],$ga['單位'],"<br>";
                $ga=mysqli_fetch_array($g);
            }
            echo "</tr></table></div>";
            ?>
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>