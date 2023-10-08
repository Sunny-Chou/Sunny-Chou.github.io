<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>追加</title>
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
        <header>
            <?php
                if(isset($_POST['a'])){echo "<h1>",$_POST['a'],"派車單追加</h1>";
                }else{
                    echo "<script>window.location.href='qianshou.php'</script>";
                }
            ?>
        </header>
        <form name="form" method="post" action="zhuijia2.php">
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
            if(isset($_POST['a'])){
                echo "<select name='a'>";
                $a = mysqli_query ( $con,"select * from 訂單 where 派車單編號='{$_POST['a']}';");
                $a1=mysqli_fetch_array($a);
                while($a1){
                    echo "<option value='",$a1['訂單編號'],"'>",$a1['訂單編號'],"</option>";
                    $a1=mysqli_fetch_array($a);
                }
                echo "</select><br><input type='submit' value='追加'>";
            }
        ?>
        
        </form>
        <form name="form2" method="post" action="qianshou.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 
</body> 
</html>