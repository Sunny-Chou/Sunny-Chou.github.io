<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>簽收</title>
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
            die ('資料庫連線失敗' . $mysql_error()); 
            }
            mysqli_select_db ( $con,"hefeng");
            if(!$_SESSION['mc']){
                mysqli_close ( $con ); 
                echo "<script>window.location.href='index.html'</script>";
            }else if(mysqli_fetch_array(mysqli_query( $con,"select * from 店家 where 店家名稱='{$_SESSION['mc']}';"))){
                mysqli_close ( $con );
                echo "<script>window.location.href='clientFunctionSelect.php'</script>";
            }
            $a = mysqli_query ( $con,"select * from 派車單 where 派車單狀態=0;");
            $aa=mysqli_fetch_array($a);
            if($aa){
                echo "<header><h1>派車單</h1></header><form name='form' method='post' action='qorz.php'><select name='a'>";
                
            }else{
                echo "<header><h1>暫無派車單</h1></header>";
            }
            while($aa){
                echo "<option value='",$aa['派車單編號'],"'>",$aa['派車單編號'],"</option>";
                $aa=mysqli_fetch_array($a);
            }
            $a = mysqli_query ( $con,"select * from 派車單 where 派車單狀態=0;");
            $aa=mysqli_fetch_array($a);
            if($aa){
                echo "</select><br><input type='submit' value='簽收' onclick=",'"',"document.forms['form'].act.value='qianshou';",'"',">
                <br><input type='submit' value='追加商品'onclick=",'"',"document.forms['form'].act.value='zhuijia';",'"',"><br>
                <input type='submit' value='列印派車單與簽收單'onclick=",'"',"document.forms['form'].act.value='paichedan';",'"',">";
            }
            
            ?>
                <input type='hidden' name='act'>
                
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