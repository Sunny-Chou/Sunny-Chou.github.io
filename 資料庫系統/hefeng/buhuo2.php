<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>補貨</title>
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
        <form name="form" method="post" action="buhuo3.php">
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
                if(!isset($_POST['mc'])){
                    mysqli_close ( $con );
                    echo "<script>window.location.href='buhuo.php'</script>";
                }
                if($_POST['mc']=='選擇補貨廠商'){
                    echo "<header><h1>全部補貨廠商</h1></header>";
                    $mc=mysqli_query ( $con,"select * from 店家 where streamflag=1 and 店家名稱!='合豐商行';");
                    $mcs=mysqli_fetch_array($mc);
                    if($_POST['pai']=="派車補貨"){
                        if(date('H', time()+7*60*60)>=8&&date('H', time()+7*60*60)<20){
                            echo"派車時間：",date("Y-m-d", time()+7*60*60),"<input type='time' name='d' id='d' min='",date('H:i:s', time()+7*60*60),"'max='20:00:00'value='",date('H:i:s', time()+7*60*60),"'>";
                        }else if(date('H', time()+7*60*60)<8){
                            echo"派車時間：",date("Y-m-d", time()+7*60*60),"<input type='time' name='d' id='d' min='08:00:00'max='20:00:00'value='",date('H:i:s', time()+7*60*60),"'>";
                        }
                    }
                    while($mcs){
                        echo "<header><h1>",$mcs['店家名稱'],"</h1></header>";
                        $g=mysqli_query ( $con,"select * from 商品 where 供貨廠商='{$mcs['店家名稱']}';");
                        $ga=mysqli_fetch_array($g);
                        $j=0;
                        while($ga){
                            $g2=mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';");
                            $ga2=mysqli_fetch_array($g2);
                            if($ga['規格']!=null){
                                echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='3'>",$ga2['商品名稱'],"</th></tr></thead>";
                                echo "<tbody><tr><td>規格</td><td>數量</td><td>庫存數量</td></tr>";
                            }else{
                                echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='2'>",$ga2['商品名稱'],"</th></tr></thead>";
                                echo "<tbody><tr><td>數量</td><td>庫存數量</td></tr>";
                            }
                            while($ga2){
                                $j++;
                                if($ga['規格']!=null){
                                    echo "<tr><td>",$ga2['規格'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td><td>",$ga2['庫存數量'],$ga2['單位'],"</td></tr>";
                                }else{
                                    echo "<tr><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td><td>",$ga2['庫存數量'],$ga2['單位'],"</td></tr>";
                                }
                                $ga2=mysqli_fetch_array($g2);
                            }
                            echo "</tbody></table></div>";
                            for($j;$j>0;$j--){
                                $ga=mysqli_fetch_array($g);
                            }
                            $j=0;
                        }
                        if($_POST['pai']=="派車補貨"){
                            if(date('H', time()+7*60*60)>=8&&date('H', time()+7*60*60)<20){
                                echo"<br><input type='submit' value='補貨'onclick=",'"',"document.forms['form'].a.value='",$mcs['店家名稱'],"';",'"',">";//123裡填入補貨單編號
                            }else if(date('H', time()+7*60*60)<8){
                                echo"<br><input type='submit' value='補貨'onclick=",'"',"document.forms['form'].a.value='",$mcs['店家名稱'],"';",'"',">";//123裡填入補貨單編號
                            }else{
                                echo "<br>現在不在補貨時間";
                            }
                        }
                        
                        $mcs=mysqli_fetch_array($mc);
                    }
                }else{
                    echo "<header><h1>",$_POST['mc'],"</h1></header>";
                    if($_POST['pai']=="派車補貨"){
                        if(date('H', time()+7*60*60)>=8){
                            echo"派車時間：",date("Y-m-d", time()+7*60*60),"<input type='time' name='d' id='d' min='",date('H:i:s', time()+7*60*60),"'max='20:00:00'value='",date('H:i:s', time()+7*60*60),"'><br><br>";
                        }else{
                            echo"派車時間：",date("Y-m-d", time()+7*60*60),"<input type='time' name='d' id='d' min='08:00:00'max='20:00:00'value='",date('H:i:s', time()+7*60*60),"'><br><br>";
                        }
                    }
                    $g=mysqli_query ( $con,"select * from 商品 where 供貨廠商='{$_POST['mc']}';");
                    $ga=mysqli_fetch_array($g);
                    $j=0;
                    while($ga){
                        $g2=mysqli_query ( $con,"select * from 商品 where 商品名稱='{$ga['商品名稱']}';");
                        $ga2=mysqli_fetch_array($g2);
                        if($ga['規格']!=null){
                            echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='3'>",$ga2['商品名稱'],"</th></tr></thead>";
                            echo "<tbody><tr><td>規格</td><td>數量</td><td>庫存數量</td></tr>";
                        }else{
                            echo "<div><table style='border:3px Navy solid;margin-left:20px;'border='1'><thead><tr><th colspan='2'>",$ga2['商品名稱'],"</th></tr></thead>";
                            echo "<tbody><tr><td>數量</td><td>庫存數量</td></tr>";
                        }
                        while($ga2){
                            $j++;
                            if($ga['規格']!=null){
                                echo "<tr><td>",$ga2['規格'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td><td>",$ga2['庫存數量'],$ga2['單位'],"</td></tr>";
                            }else{
                                echo "<tr><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"'min='0' max='50' value='0'>",$ga2['單位'],"</label></td><td>",$ga2['庫存數量'],$ga2['單位'],"</td></tr>";
                            }
                            $ga2=mysqli_fetch_array($g2);
                        }
                        echo "</tbody></table></div>";
                        for($j;$j>0;$j--){
                            $ga=mysqli_fetch_array($g);
                        }
                        $j=0;
                    }
                    if($_POST['pai']=="派車補貨"){
                        if(date('H', time()+7*60*60)>=8&&date('H', time()+7*60*60)<20){
                            echo"<br><input type='submit' value='補貨'onclick=",'"',"document.forms['form'].a.value='",$_POST['mc'],"';",'"',">";//123裡填入補貨單編號
                        }else if(date('H', time()+7*60*60)<8){
                            echo"<br><input type='submit' value='補貨' onclick=",'"',"document.forms['form'].a.value='",$_POST['mc'],"';",'"',">";//123裡填入補貨單編號
                        }else{
                            echo "<br>現在不在補貨時間";
                        }
                    }
                    
                }
            ?>
            <input type='hidden' name='a'>
        </form>
        <form name="form2" method="post" action="buhuo.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>