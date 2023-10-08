<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>歷史零售資料</title>
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
                    $a = mysqli_query ( $con,"select * from 使用者");
                    $aa=mysqli_fetch_array($a);
                    if(!$aa)
                        echo "<header><h1>暫無使用者</h1></header>";
                    for($i=1;$aa;$i++){
                        echo "<header><h1>使用者",$i,"</h1></header>";
                        echo "<p>帳號：",$aa['帳號'],"<br>姓名：",$aa['姓名'];
                        $aa=mysqli_fetch_array($a);
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