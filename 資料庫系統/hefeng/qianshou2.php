<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>簽收</title>
        <style>
            body {
                width: 100%;
                height: 100%;
                max-width: 960px;		
                margin: 0 auto; 
                padding: 0px;
                color:navy;
            }
            header{
                text-align: center;
                color:white;
                background-color: navy;
            }
            main{
                width:100%;
                text-align: center;
                font-family: 標楷體;
                background-color: AliceBlue;
            }
        </style>
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
            $a = mysqli_query ( $con,"select * from 訂單 where 派車單編號='{$_POST['a']}';");
            $aa=mysqli_fetch_array($a);
            $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 派車單 where 派車單編號='{$_POST['a']}';"));
            echo "<br>車牌：",$che['車牌'];
            $che=mysqli_fetch_array(mysqli_query ( $con,"select * from 貨車 where 車牌='{$che['車牌']}';"));
            echo "<br>司機：",$che['司機'],"<br>配送日期：",$aa['配送日期'],"<br>派車單編號：",$aa['派車單編號'];
            
            for($i=1;$aa;$i++){
                echo "<header><h1>訂單",$i,"</h1></header>";
                echo "<p>訂單編號：",$aa['訂單編號'],"<br>","店家名稱：",$aa['店家名稱'],"<br>";
                $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
                echo "備註：",$aa['備註'],"<br>";
                $ga=mysqli_fetch_array($g);
                echo "購買商品：<br>";
                $finalmoney=0;
                while($ga){
                    echo $ga['商品名稱']," ";
                    if($ga['規格']){
                        echo $ga['規格']," ";
                    }
                    echo $ga['購買商品數量'],$ga['單位']," ";
                    $gg=mysqli_fetch_array(mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';"));
                    $money=$ga['購買商品數量']*$gg['單價'];
                    $finalmoney+=$money;
                    echo " 單價：",$gg['單價'],"元 金額：",$money,"元<br>";
                    $ga=mysqli_fetch_array($g);
                }
                $g=mysqli_query ( $con,"select * from 追加商品 where 訂單編號='{$aa['訂單編號']}';");
                $ga=mysqli_fetch_array($g);
                if($ga){
                    echo "追加商品：<br>";
                }
                while($ga){
                    echo $ga['商品名稱']," ";
                    if($ga['規格']){
                        echo $ga['規格']," ";
                    }
                    echo $ga['追加商品數量'],$ga['單位']," ";
                    $gg=mysqli_fetch_array(mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';"));
                    $money=$ga['追加商品數量']*$gg['單價'];
                    $finalmoney+=$money;
                    echo " 單價：",$gg['單價'],"元 金額：",$money,"元<br>";
                    $ga=mysqli_fetch_array($g);
                }
                echo "總金額：",$finalmoney,"元";
                echo "</p>";
                $aa=mysqli_fetch_array($a);
            }
            echo "<input type='submit' value='簽收' name='a' onclick=",'"',"document.forms['form'].a.value='",$_POST['a'],"';",'"',">";
            ?>
        </form>
        <form name="form2" method="post" action="qianshou.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>