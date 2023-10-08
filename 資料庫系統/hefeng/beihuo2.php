<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>備貨</title>
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
            if(!isset($_POST['mc'])){
                mysqli_close ( $con );
                echo "<script>window.location.href='beihuo.php'</script>";
            }
            if($_POST['mc']=="選擇店家"){
                $a = mysqli_query ( $con,"select * from 訂單 where 訂單備貨狀態=0;");
                $a1=mysqli_fetch_array($a);
                if($a1){
                    echo"<header><h1>全部店家訂單</h1></header>";
                    echo "<form name='form' method='post' action='beihuo3.php'><select name='a'>";
                    while($a1){
                        echo "<option value='",$a1['訂單編號'],"'>",$a1['訂單編號'],"</option>";
                        $a1=mysqli_fetch_array($a);
                    }
                    echo "</select><br><input type='submit' value='選擇'>";
                }else{
                    echo"<header><h1>全部店家暫無訂單</h1></header>";
                }
            }else{
                $a = mysqli_query ( $con,"select * from 訂單 where 店家名稱='{$_POST['mc']}' and 訂單備貨狀態=0;");
                $a1=mysqli_fetch_array($a);
                if($a1){
                    echo "<header><h1>",$_POST['mc'],"訂單</h1></header>";
                    echo"<form name='form' method='post' action='beihuo3.php'><select name='a'>";
                    while($a1){
                        echo "<option value='",$a1['訂單編號'],"'>",$a1['訂單編號'],"</option>";
                        $a1=mysqli_fetch_array($a);
                        }
                        echo "</select><br><input type='submit' value='選擇'>";
                }else{
                    echo "<header><h1>",$_POST['mc'],"暫無訂單</h1></header>";
                }
            }
        ?>
        <br>
        </form>
        <form name="form2" method="post" action="beihuo.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 
</body> 
</html>