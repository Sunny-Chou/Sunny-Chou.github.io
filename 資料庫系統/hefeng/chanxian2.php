<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>產線進貨</title>
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
        <form name="form" method="post" action="chakan.php">
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
                $g=mysqli_query( $con,"select * from 商品 where 供貨廠商='合豐商行' or 供貨廠商='臻如意純水製冰公司';");
                $gs=mysqli_fetch_array($g);
                $j=true;
                while($gs){
                    $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
                    if(isset($_POST[$gn])&&$_POST[$gn]>0){
                        $j=false;break;
                    }
                    $gs=mysqli_fetch_array($g);
                }
                if($j){
                    echo "<script>alert('沒有選擇任何商品！');</script>";
                    echo "<script>window.location.href='chanxian.php'</script>";
                }
                $today = substr(date("Ymd", time()+7*60*60),2,6)."001";
                $today=(int)($today);
                while(mysqli_fetch_array(mysqli_query ( $con,"select * from 產線進貨 where 進貨編號='{$today}';"))){
                    $today++;
                }
                mysqli_query( $con,"insert into 產線進貨 values('{$today}','{$_SESSION['mc']}');");
                $g=mysqli_query( $con,"select * from 商品 where 供貨廠商='合豐商行' or 供貨廠商='臻如意純水製冰公司';");
                $gs=mysqli_fetch_array($g);
                $g=mysqli_query( $con,"select * from 商品 where 供貨廠商='合豐商行' or 供貨廠商='臻如意純水製冰公司';");
                $gs=mysqli_fetch_array($g);
                while($gs){
                    $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
                    if(isset($_POST[$gn])&&$_POST[$gn]>0){
                        $n=mysqli_fetch_array(mysqli_query($con,"select * from 商品 where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'"))['庫存數量']+$_POST[$gn];
                        mysqli_query($con,"update 商品 set 庫存數量='{$n}' where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'");
                        mysqli_query($con,"insert into 進貨商品 values('{$today}','{$gs['商品名稱']}','{$gs['規格']}','{$gs['單位']}','{$_POST[$gn]}');");
                    }
                    $gs=mysqli_fetch_array($g);
                }
                echo "<input type='hidden' name='a' value='",$today,"'><script>form.submit()</script>";
            ?>
            
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>