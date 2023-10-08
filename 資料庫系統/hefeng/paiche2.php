<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>派車</title>
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
        <form name="form" method="post" action="paiche3.php">
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
                if(isset($_POST['d'])){
                    $a = mysqli_query ( $con,"select * from 訂單 where 訂單備貨狀態=1 and 配送方式=1 and 配送日期='{$_POST['d']}' and 派車單編號 is null;");
                    $aa=mysqli_fetch_array($a);
                    $finalmoneys=0;
                    if(!$aa)
                        echo "<header><h1>暫無訂單</h1></header>";
                    for($i=1;$aa;$i++){
                        echo "<header><h1>訂單",$i,"</h1></header>";
                        $dian=mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$aa['店家名稱']}';"));
                        echo "<p>訂單編號：",$aa['訂單編號'],"<br>","店家名稱：",$aa['店家名稱'],"<br>店家地址：",$dian['店家地址'],"<br>聯絡人員：",$dian['聯絡人員'],"<br>聯絡電話：",$dian['聯絡電話'];
                        echo "<br>配送方式：宅配<br>配送日期：",$aa['配送日期'],"<br>備註：",$aa['備註'];
                        $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
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
                            echo "<br>追加商品：<br>";
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
                        $finalmoneys+=$finalmoney;
                        echo "總金額：",$finalmoney,"元";
                        echo "</p>";
                        $aa=mysqli_fetch_array($a);
                    }
                    $a = mysqli_fetch_array(mysqli_query ( $con,"select * from 訂單 where 訂單備貨狀態=1 and 訂單狀態=0 and 配送方式=1 and 配送日期='{$_POST['d']}' and 派車單編號 is null;"));
                    if($a){
                        echo "派車總金額：",$finalmoneys,"元<br>";
                        if(date("H", time()+7*60*60)>=8&&date("H", time()+7*60*60)<20){
                            echo "派車時間：<input type='time' name='t' value='",date("H:i:s", time()+7*60*60),"' min='",date("H:i:s", time()+7*60*60),"'max='20:00:00'><br><input type='submit' value='派車'>";
                        }else if(date("H", time()+7*60*60)<8){
                            echo "派車時間：<input type='time' name='t' value='",date("H:i:s", time()+7*60*60),"' min='08:00:00'max='20:00:00'><br><input type='submit' value='派車'>";
                        }else{
                            echo "現在不在派車時間";
                        }
                        echo"<input type='hidden' name='a' value='",$_POST['d'],"'>";
                    }
                }else{
                    mysqli_close ( $con );
                    echo "<script>window.location.href='paiche.php'</script>";
                }
            ?>
        </form>
        <form name="form2" method="post" action="paiche.php">
            <input type="submit" value="返回">
        </form>
    </main>
    <?php
        mysqli_close ( $con ); 
    ?> 

    </body> 
</html>