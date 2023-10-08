<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>列印派車單和簽收單</title>
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
            echo"<div><table style='white-space: pre-wrap;border:3px Navy solid;'border='1'><thead><tr><th colspan='6'>派車單</th></tr></thead>";
            $a = mysqli_query ( $con,"select * from 訂單 where 派車單編號='{$_POST['a']}';");
            $aa=mysqli_fetch_array($a);
            $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 派車單 where 派車單編號='{$_POST['a']}';"));
            echo "<tr><th>車牌</th><th>",$che['車牌'],"</th>";
            $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 貨車 where 車牌='{$che['車牌']}';"));
            echo "</th><th>司機</th><th>",$che['司機'],"</th><th>派車時間</th><th>";
            $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 派車單 where 派車單編號='{$_POST['a']}';"));
            echo $che['派車時間'],"</th></tr><tr><th colspan='3'>派車單編號</th><th colspan='3'>",$_POST['a'],"</th></tr>";
            for($i=1;$aa;$i++){
                $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$aa['店家名稱']}';"))['店家地址'];
                echo "<tr><th>訂單編號</th><th>店名</th><th>地址</th><th>訂單內容</th><th colspan='2'>金額</th></tr><tr><th>",$aa['訂單編號'],"</th><th>",$aa['店家名稱'],"</th><th>",$che,"</th><th>";
                $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
                $ga=mysqli_fetch_array($g);
                $finalmoney=0;
                while($ga){
                    echo $ga['商品名稱']," ";
                    if($ga['規格']){
                        echo $ga['規格']," ";
                    }
                    echo $ga['購買商品數量'],$ga['單位'],"<br>";
                    $gg=mysqli_fetch_array(mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';"));
                    $money=$ga['購買商品數量']*$gg['單價'];
                    $finalmoney+=$money;
                    $ga=mysqli_fetch_array($g);
                }
                echo "</th><th colspan='2'>",$finalmoney,"元</th></tr>";
                $aa=mysqli_fetch_array($a);
            }
            
            $a = mysqli_query ( $con,"select * from 訂單 where 派車單編號='{$_POST['a']}';");
            $aa=mysqli_fetch_array($a);
            
            $j=0;
            $k=0;
            
            while($aa){
                $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
                $ga=mysqli_fetch_array($g);
                while($ga){
                    $ga=mysqli_fetch_array($g);
                    $k++;
                }
                echo "</table></div><div><table style='white-space: pre-wrap;border:3px Navy solid;'border='1'><thead><tr><th colspan='5'>免用統一發票收據</th><th colspan='2'>收據專用章</th></tr></thead><tr><th>買受人簽收</th><th>&emsp;&emsp;&emsp;&emsp;&emsp;</th><th>統一編號</th><th colspan='2'>45564475</th><th colspan='2'>&emsp;&emsp;&emsp;<br><br><br></th></tr><tr><th>品名</th><th>規格</th><th>數量</th><th>單位</th><th>單價</th><th>金額</th><th>&emsp;&emsp;&emsp;&emsp;</th></tr>";
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
                    if($j==0){
                        echo"<td rowspan='5'>銀<br>貨<br>兩<br>訖</td>";
                    }
                    if($j==5){
                        echo"<td rowspan='",$k+1,"'></td>";
                    }
                    echo"</tr>";
                    $j++;
                }
                for($i=0;$i<5;$i++){
                    echo "<tr><td>&emsp;&emsp;&emsp;&emsp;</td>&emsp;&emsp;&emsp;&emsp;<td>&emsp;&emsp;&emsp;&emsp;</td>&emsp;&emsp;&emsp;&emsp;<td>&emsp;&emsp;&emsp;&emsp;</td>&emsp;&emsp;&emsp;&emsp;<td>&emsp;&emsp;&emsp;&emsp;</td>&emsp;&emsp;&emsp;&emsp;<td>&emsp;&emsp;&emsp;&emsp;</td>&emsp;&emsp;&emsp;&emsp;<td>&emsp;&emsp;&emsp;&emsp;</td>";
                    if($i+$j==5){echo"<td rowspan='",$k+1,"'></td>";}
                    echo "</tr>";
                }
                echo "<tr><td colspan='3'>訂單編號",$aa['訂單編號'],"</td>";
                echo "</td><td colspan='3'>總金額：",$finalmoney,"</td></tr></table></div>";
                $aa=mysqli_fetch_array($a);
            }
            ?>
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>