<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>歷史產線進貨資料</title>
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
                    $s="select * from 產線進貨 where 進貨編號 like '%".$d."%';";
                    $a = mysqli_query ( $con,$s);
                    $aa=mysqli_fetch_array($a);
                    if(!$aa)
                        echo "<header><h1>暫無產線進貨</h1></header>";
                    for($i=1;$aa;$i++){
                        echo "<header><h1>產線進貨",$i,"</h1></header>";
                        echo "<p>進貨編號：",$aa['進貨編號'],"<br>進貨的帳號：",$aa['產線進貨的帳號'];
                        $g=mysqli_query ( $con,"select * from 進貨商品 where 進貨編號='{$aa['進貨編號']}';");
                        $ga=mysqli_fetch_array($g);
                        echo "<br>進貨商品：<br>";
                        while($ga){
                            echo $ga['商品名稱']," ";
                            if($ga['規格']){
                                echo $ga['規格']," ";
                            }
                            echo $ga['進貨商品數量'],$ga['單位'],"<br>";
                            $ga=mysqli_fetch_array($g);
                        }
                        echo "</p>";
                        $aa=mysqli_fetch_array($a);
                    }
                }else{
                    mysqli_close ( $con );
                    echo "<script>window.location.href='chanxians.php'</script>";
                }
            ?>
        <form name="form2" method="post" action="chanxians.php">
            <input type="submit" value="返回">
        </form>
    </main>
    <?php
        mysqli_close ( $con ); 
    ?> 

    </body> 
</html>