<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>歷史店取訂單資料</title>
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
                    $d=substr(str_replace("-","",$_POST['d']),2,6);
                    $s="select * from 訂單 where 訂單編號 like '%".$d."%' and 配送方式=0 and 訂單狀態=1;";
                    $a = mysqli_query ( $con,$s);
                    $aa=mysqli_fetch_array($a);
                    if(!$aa)
                        echo "<header><h1>暫無訂單</h1></header>";
                    for($i=1;$aa;$i++){
                        echo "<header><h1>店取訂單",$i,"</h1></header>";
                        echo "<p>訂單編號：",$aa['訂單編號'],"<br>店家名稱：",$aa['店家名稱'],"<br>建立或修改的帳號：",$aa['建立的帳號'],"<br>店取交貨的帳號：",$aa['店取交貨的帳號'],"<br>店取時間：",$aa['店取時間'],"<br>備註：",$aa['備註'];
                        $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
                        $ga=mysqli_fetch_array($g);
                        echo "<br>購買商品：<br>";
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
                        echo "總金額：",$finalmoney,"元";
                        echo "</p>";
                        $aa=mysqli_fetch_array($a);
                    }
                }else{
                    mysqli_close ( $con );
                    echo "<script>window.location.href='dianqus.php'</script>";
                }
            ?>
        <form name="form2" method="post" action="dianqus.php">
            <input type="submit" value="返回">
        </form>
    </main>
    <?php
        mysqli_close ( $con ); 
    ?> 

    </body> 
</html>