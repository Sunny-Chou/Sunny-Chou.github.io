<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>查看訂單</title>
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
            div{
                display: inline-block;
            }
        </style>
    </head> 
    <body>
        <main>
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
                }else if(mysqli_fetch_array(mysqli_query( $con,"select * from 使用者 where 帳號='{$_SESSION['mc']}';"))){
                    mysqli_close ( $con );
                    echo "<script>window.location.href='employeeFunctionSelect.php'</script>";
                }
                if(!isset($_POST['a'])){
                    mysqli_close ( $con );
                    echo "<script>window.location.href='gaiorshan.php'</script>";
                }
                $a = mysqli_query ( $con,"select * from 訂單 where 訂單編號='{$_POST['a']}';");
                $aa=mysqli_fetch_array($a);
                echo "<header><h1>訂單</h1></header>";
                echo "<p>訂單編號：",$aa['訂單編號'];
                if(!$aa['訂單備貨狀態']){
                    echo "<br>訂單狀態：未確認";
                }else{
                    if($aa['配送方式']){
                        echo "<br>訂單狀態：等待派車送貨";
                    }else{
                        echo "<br>訂單狀態：可店取";
                    }
                }
                echo "<br>","店家名稱：",$aa['店家名稱'],"<br>";
                if($aa['配送方式']){
                    echo "配送方式：宅配<br>配送日期：",$aa['配送日期'],"<br>";
                }else{
                    echo "配送方式：店取<br>店取時間：",$aa['店取時間'],"<br>";
                }
                $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
                $ga=mysqli_fetch_array($g);
                echo "備註：",$aa['備註'],"<br>";
                echo "購買商品：<br>";
                $finalmoney=0;
                while($ga){
                    echo $ga['商品名稱'];
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
                echo "總金額：",$finalmoney,"元";
                echo "</p>";
                $aa=mysqli_fetch_array($a);
            ?>
        </form>
        <form name="form2" method="post" action="dingdan2.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>