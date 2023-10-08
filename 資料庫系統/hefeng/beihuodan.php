<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>列印備貨單</title>
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
                echo "<script>window.location.href='paiche.php'</script>";
            }
            $a=mysqli_query ( $con,"select * from 訂單 where 訂單編號='{$_POST['a']}';");
            $aa=mysqli_fetch_array($a);
            $d=mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$aa['店家名稱']}';"));
            echo"</table></div><div><table style='white-space: pre-wrap;border:3px Navy solid;'border='1'><thead><tr><th colspan='6'>訂單資訊</th></tr></thead>";
            echo "<tr><td>訂單編號</td><td colspan='2'>",$aa['訂單編號'],"</td><td>訂單狀態</td><td colspan='2'>已接單確認</td></tr><tr><td>店名</td><td colspan='2'>",$d['店家名稱'],"</td><td>地址</td><td colspan='2'>",$d['店家地址'],"</td></tr>";
            if($aa['配送方式']){
                echo "<tr><td>配送日期</td><td colspan='2'>",$aa['配送日期'],"</td><td>備註</td><td colspan='2'>";
            }else{
                echo "<tr><td>店取時間</td><td colspan='2'>",$aa['店取時間'],"</td><td>備註</td><td colspan='2'>";
            }
            echo $aa['備註'],"</td></tr>";
            echo"<thead><tr><th colspan='6'>訂購人資訊</th></tr></thead><tr><td>姓名</td><td colspan='2'>",$d['聯絡人員'],"</td><td>聯絡電話</td><td colspan='2'>",$d['聯絡電話'],"</td></tr>";
            $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
            $ga=mysqli_fetch_array($g);
            $finalmoney=0;
                echo "<tr><th>品名</th><th>規格</th><th>數量</th><th>單位</th><th>單價</th><th>金額</th></tr>";
                $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$aa['店家名稱']}';"))['店家地址'];
                $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
                $ga=mysqli_fetch_array($g);
                $finalmoney=0;
                $j=0;
                while($ga){
                    echo "<tr><td>",$ga['商品名稱'],"</td>";
                    if($ga['規格']){
                        echo "<td>",$ga['規格'],"</td>";
                    }
                    else{
                        echo "<td>&emsp;&emsp;&emsp;&emsp;</td>";
                    }
                    echo "<td>",$ga['購買商品數量'],"</td><td>",$ga['單位'],"</td>";
                    $gg=mysqli_fetch_array(mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';"));
                    echo "<td>",$gg['單價'],"</td><td>";
                    $money=$ga['購買商品數量']*$gg['單價'];
                    echo $money,"</td>";
                    $finalmoney+=$money;
                    $ga=mysqli_fetch_array($g);
                    echo"</tr>";
                    $j++;
                }
                echo "</td><td colspan='6'>總金額：",$finalmoney,"</td></tr></table></div>";
                $aa=mysqli_fetch_array($a);
            ?>
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>