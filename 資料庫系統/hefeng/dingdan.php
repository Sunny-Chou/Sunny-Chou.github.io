<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>查看訂單</title>
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
            <h1>選擇訂單種類</h1>
        </header>
        <form name="form" method="post" action="wory.php">
        <select name="a">
            <option value='未完成訂單'>未完成訂單</option>
            <option value='已完成訂單'>已完成訂單</option>
        </select><br>
        <input type="submit" value="選擇">
        </form>
        <form name="form2" method="post" action="employeeFunctionSelect.php">
            <input type="submit" value="返回">
        </form>
        </main>
</body> 
</html>