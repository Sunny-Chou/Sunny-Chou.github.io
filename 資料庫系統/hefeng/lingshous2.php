<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>歷史零售資料</title>
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
        <form name="form" method="post" action="shouju.php">
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
                    $s="select * from 零售 where 零售編號 like '%".$d."%';";
                    $a = mysqli_query ( $con,$s);
                    $aa=mysqli_fetch_array($a);
                    if(!$aa)
                        echo "<header><h1>暫無零售</h1></header>";
                    for($i=1;$aa;$i++){
                        echo "<header><h1>零售",$i,"</h1></header>";
                        echo "<p>零售編號：",$aa['零售編號'],"<br>零售的帳號：",$aa['零售的帳號'];
                        $g=mysqli_query ( $con,"select * from 零售商品 where 零售編號='{$aa['零售編號']}';");
                        $ga=mysqli_fetch_array($g);
                        echo "<br>零售商品：<br>";
                        $finalmoney=0;
                        while($ga){
                            echo $ga['商品名稱']," ";
                            if($ga['規格']){
                                echo $ga['規格']," ";
                            }
                            echo $ga['零售商品數量'],$ga['單位']," ";
                            $gg=mysqli_fetch_array(mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';"));
                            $money=$ga['零售商品數量']*$gg['單價'];
                            $finalmoney+=$money;
                            echo " 單價：",$gg['單價'],"元 金額：",$money,"元<br>";
                            $ga=mysqli_fetch_array($g);
                        }
                        echo "總金額：",$finalmoney,"元";
                        echo "</p>";
                        echo "<input type='submit' value='列印收據' onclick=",'"',"document.forms['form'].a.value='",$aa['零售編號'],"';",'"',">";
                        $aa=mysqli_fetch_array($a);
                    }
                }else{
                    mysqli_close ( $con );
                    echo "<script>window.location.href='lingshous.php'</script>";
                }
            ?>
            <input type='hidden' name='a'>
        </form>
        <form name="form2" method="post" action="lingshous.php">
            <input type="submit" value="返回">
        </form>
    </main>
    <?php
        mysqli_close ( $con ); 
    ?> 

    </body> 
</html>