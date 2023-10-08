<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>零售</title>
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
        <form name="form" method="post" action="lingshou2.php">
            <header><h1>零售</h1></header>
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
                $g=mysqli_query ( $con,"select * from 商品 where 供貨廠商!='鑫旺免洗餐具行豐原營業處';");
                $ga=mysqli_fetch_array($g);
                $i=1;
                $j=0;
                echo "<header><h1>衛生冰塊&冰沙</h1></header>";
                while($ga){
                    $g2=mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';");
                    $ga2=mysqli_fetch_array($g2);
                    if($ga['規格']!=null){
                        echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='3'>",$ga2['商品名稱'],"</th></tr></thead>";
                        echo "<tbody><tr><td>規格</td><td>單價</td><td>數量</td></tr>";
                    }else{
                        echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='2'>",$ga2['商品名稱'],"</th></tr></thead>";
                        echo "<tbody><tr><td>單價</td><td>數量</td></tr>";
                    }
                    while($ga2){
                        $j++;
                        if($ga['規格']!=null){
                            echo "<tr><td>",$ga2['規格'],"</td><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
                        }else{
                            echo "<tr><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
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
                $g=mysqli_query ( $con,"select * from 商品 where 供貨廠商='鑫旺免洗餐具行豐原營業處';");
                $ga=mysqli_fetch_array($g);
                $j=0;
                echo "<header><h1>原物料</h1></header>";
                while($ga){
                    $g2=mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';");
                    $ga2=mysqli_fetch_array($g2);
                    if($ga['規格']!=null){
                        echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='3'>",$ga2['商品名稱'],"</th></tr></thead>";
                        echo "<tbody><tr><td>規格</td><td>單價</td><td>數量</td></tr>";
                    }else{
                        echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='2'>",$ga2['商品名稱'],"</th></tr></thead>";
                        echo "<tbody><tr><td>單價</td><td>數量</td></tr>";
                    }
                    while($ga2){
                        $j++;
                        if($ga['規格']!=null){
                            echo "<tr><td>",$ga2['規格'],"</td><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
                        }else{
                            echo "<tr><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
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
            ?>
            <input type="submit" value="零售">
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