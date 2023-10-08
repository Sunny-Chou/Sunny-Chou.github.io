<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>查看庫存</title>
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
        <form name="form" method="post" action="jinhuo3.php">
            <?php
                session_start ();
                if(!$_SESSION['mc']){
                    echo "<script>window.location.href='index.html'</script>";
                }
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
                $i=1;
                echo "<header><h1>商品庫存</h1></header>";
                $mc=mysqli_query ( $con,"select * from 店家 where streamflag=1 and 店家名稱!='臻如意純水製冰公司';");
                $mcs=mysqli_fetch_array($mc);
                while($mcs){
                    if($mcs['店家名稱']!='合豐商行'){
                        echo "<header><h1>",$mcs['店家名稱'],"</h1></header>";
                    }else{
                        echo "<header><h1>合豐商行或臻如意純水製冰公司</h1></header>";
                    }
                    $g=mysqli_query ( $con,"select * from 商品 where 供貨廠商='{$mcs['店家名稱']}';");
                    $ga=mysqli_fetch_array($g);
                    $j=0;
                    while($ga){
                        $g2=mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';");
                        $ga2=mysqli_fetch_array($g2);
                        if($ga['規格']!=null){
                            echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='2'>",$ga2['商品名稱'],"</th></tr></thead>";
                            echo "<tbody><tr><td>規格</td><td>數量</td></tr>";
                        }else{
                            echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='1'>",$ga2['商品名稱'],"</th></tr></thead>";
                            echo "<tbody><tr><td>數量</td></tr>";
                        }
                        while($ga2){
                            $j++;
                            if($ga['規格']!=null){
                                echo "<tr><td>",$ga2['規格'],"</td><td><label>",$ga2['庫存數量'],$ga2['單位'],"</label></td></tr>";
                            }else{
                                echo "<tr><td><label>",$ga2['庫存數量'],$ga2['單位'],"</label></td></tr>";
                            }
                            $i++;
                            $ga2=mysqli_fetch_array($g2);
                        }
                        echo "</tbody></table></div>";
                        for($j;$j>0;$j--){
                            $ga=mysqli_fetch_array($g);
                        }
                        $j=0;
                    }
                    $mcs=mysqli_fetch_array($mc);
                }
            ?>
        </form>
        <form name="form2" method="post" action="employeeFunctionSelect.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>