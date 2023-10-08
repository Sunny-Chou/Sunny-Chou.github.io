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
                echo "<script>window.location.href='jinhuo.php'</script>";
            }
            if($_POST['mc']=='選擇進貨廠商'){
                $a = mysqli_query ( $con,"select * from 補貨單 where 補貨單狀態=0;");
                $aa=mysqli_fetch_array($a);
                if($aa){
                    echo "<header><h1>全部補貨單</h1></header><form name='form' method='post' action='qorz2.php'><select name='a'>";
                }else{
                    echo "<header><h1>暫無補貨單</h1></header>";
                }
                while($aa){
                    echo "<option value='",$aa['補貨單編號'],"'>",$aa['補貨單編號'],"</option>";
                    $aa=mysqli_fetch_array($a);
                }
                if(mysqli_fetch_array(mysqli_query ( $con,"select * from 補貨單;"))){
                    echo "</select><br><input type='submit' value='進貨' onclick=",'"',"document.forms['form'].act.value='jinhuo';",'"',">";
                    echo"<input type='submit' value='列印補貨單' onclick=",'"',"document.forms['form'].act.value='lie';",'"',">";
                }
            }else{
                $a = mysqli_query ( $con,"select * from 補貨單 where 補貨的廠商='{$_POST['mc']}' and 補貨單狀態=0;");
                $aa=mysqli_fetch_array($a);
                if($aa){
                    echo "<header><h1>",$_POST['mc'],"補貨單</h1></header><form name='form' method='post' action='qorz2.php'><select name='a'>";
                }else{
                    echo "<header><h1>",$_POST['mc'],"暫無補貨單</h1></header>";
                }
                while($aa){
                    echo "<option value='",$aa['補貨單編號'],"'>",$aa['補貨單編號'],"</option>";
                    $aa=mysqli_fetch_array($a);
                }
                if(mysqli_fetch_array(mysqli_query ( $con,"select * from 補貨單 where 補貨的廠商='{$_POST['mc']}';"))){
                    echo "</select><br><input type='submit' value='進貨' onclick=",'"',"document.forms['form'].act.value='jinhuo';",'"',">";
                    echo"<input type='submit' value='列印補貨單' onclick=",'"',"document.forms['form'].act.value='lie';",'"',">";
                }
            }
            
            ?>
            <input name="act" type="hidden">
        </form>
        <form name="form2" method="post" action="jinhuo.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>