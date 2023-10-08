<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>進貨</title>
        <style>
            body {
                width: 100%;
                height: 100%;
                max-width: 960px;		
                margin: 0 auto; 
                padding: 0px;
                font-family: 標楷體;
                color:navy;
            }
            main{
                width:100%;
                text-align: center;
                background-color: AliceBlue;
            }
            header{
                text-align: center;
                color:white;
                background-color: navy;
            }
            p{
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
            }else if(mysqli_fetch_array(mysqli_query( $con,"select * from 店家 where 店家名稱='{$_SESSION['mc']}';"))){
                mysqli_close ( $con );
                echo "<script>window.location.href='clientFunctionSelect.php'</script>";
            }
            $d=substr(str_replace("-","",$_POST['d']),2,6);
            $s="select * from 補貨單 where 補貨單狀態=1 and 補貨單編號 like '%".$d."%';";
            $a = mysqli_query ( $con,$s);
            $aa=mysqli_fetch_array($a);
            $i=1;
            if(!$aa){
                echo "<header><h1>暫無補貨單</h1></header>";
            }
            while($aa){
            echo "<header><h1>補貨單",$i,"</h1></header>";
            echo "<p>補貨單編號：",$aa['補貨單編號'],"<br>","補貨的廠商：",$aa['補貨的廠商'],"<br>進貨的帳號：",$aa['進貨的帳號'],"<br>";
            if($aa['車牌']==null){
                echo "補貨方式：到店補貨<br>";
            }else{
                echo "補貨方式：派車補貨<br>車牌：",$aa['車牌'],"<br>地址：",mysqli_fetch_array(mysqli_query ( $con,"select * from 店家 where 店家名稱='{$aa['補貨的廠商']}';"))['店家地址'],"<br>";
            }
            $g=mysqli_query ( $con,"select * from 商補 where 補貨單編號='{$aa['補貨單編號']}';");
            $ga=mysqli_fetch_array($g);
            echo "補貨商品：<br>";
            while($ga){
                echo $ga['商品名稱']," ";
                if($ga['規格']){
                    echo $ga['規格']," ";
                }
                echo $ga['補貨商品數量'],$ga['單位'],"<br>";
                $ga=mysqli_fetch_array($g);
            }
            $aa=mysqli_fetch_array($a);
            $i++;
            }
        ?>
        <form name="form2" method="post" action="employeeFunctionSelect.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 
</body> 
</html>