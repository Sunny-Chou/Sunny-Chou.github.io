<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>修改或刪除訂單</title>
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
                echo "<p>訂單編號：",$aa['訂單編號'],"<br>","店家名稱：",$aa['店家名稱'],"<br>";
                if($aa['配送方式']){
                    echo "配送方式：宅配<br>配送日期：",$aa['配送日期'],"<br>";
                }else{
                    echo "配送方式：店取<br>店取時間：",$aa['店取時間'],"<br>";
                }
                echo "備註：",$aa['備註'],"<br>";
                $g=mysqli_query ( $con,"select * from 購買 where 訂單編號='{$aa['訂單編號']}';");
                $ga=mysqli_fetch_array($g);
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
    </main>
    <main>
        <form name="form" method="post" action="gors.php">
        <input type="hidden" name="act">
            <?php
                echo "<input type='hidden' name='",$_POST['a'],"'value='",$_POST['a'],"'>";
                echo "<input type='submit' value='刪除'onclick=",'"',"document.forms['form'].act.value='shan';",'"',">";
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
                echo "<br><input type='submit' value='更改'onclick=",'"',"document.forms['form'].act.value='gai';",'"',">";
            ?><br>
        </form>
        <form name="form2" method="post" action="gaiorshan.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>