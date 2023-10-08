<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <title>建立訂單</title>
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
  <script>
    $(function(){
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth() + 1; //January is 0!
      var yyyy = today.getFullYear();

      if (dd < 10) {dd = '0' + dd;}
      if (mm < 10) {mm = '0' + mm;} 
    
      today = yyyy + '-' + mm + '-' + dd;
      $("#sendingDate1").attr("min",today);
      $("#pickUpDate1").attr("min",today);
      //console.log(today);

      var mm2 = parseInt(mm)+1;
      mm2.toString();
      if (mm2 < 10) {mm2 = '0' + mm2;} 
      today = yyyy + '-' + mm2 + '-' + dd;
      $("#sendingDate1").attr("max",today);
      $("#pickUpDate1").attr("max",today);
      //console.log(today);
                    //取得使用者選擇的店取日期
                    //若為當天訂單，最早可選當下時刻1小時之後
                    //若不是當天訂單，最早可選營業時間早上8點
                    $("#pickUpDate1").on("change", function() { //偵測店取日期
                      var dateSelect = document.getElementById("pickUpDate1").value;
                      var arr = dateSelect.split("-"); 
                      var day=arr[2];
                      
                      var today = new Date();
                      var dd = today.getDate();
                      
                      if(day == dd){
                        var time = new Date();
                        var hour = parseInt(time.getHours())+1;
                        hour.toString();
                        var minute = time.getMinutes();
                        time = hour + ':' + minute;
                        $("#pickUpTime1").attr("min",time);
                      }else{
                        $("#pickUpTime1").attr("min","8:00");
                      }
                    });
    });
  </script>
  </head>
  <body>
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
              echo "<script>window.location.href='clientFunctionSelect.php'</script>";
            }
            ?>
      <main>
    <section>
       <header><h1 class="page_title">合豐商行進貨與銷售系統</h1></header>
    </section>
    <section>
            <div class="buyerInformation">
            </div>

            <form action="addNewOrder.php" method="post">
             <label>配送方式</label>
             <select name="methodSelector" id="Selector">
                <option value="byCar">外送</option>
                <option value="bySelf">自取</option>
             </select><br><br>
            
            <br><br>

             <div id="div外送日期" style="display:block;"><label>配送日期<input type="date" name="sendingDate" max="" min="" id="sendingDate1"></label><br><br></div>
             <div id="div店取日期" style="display:none;"><label>店取日期<input type="date" name="pickUpDate" max="" min=""  id="pickUpDate1"></label><br><br></div><br>
             <div id="div店取時間" style="display:none;"><label>店取時間<input type="time" name="pickUpTime" max="21:00" min="8:00" id="pickUpTime1"></label><br><br></div><br>
             <label>備註<input type="text" name="ps"></label><br>
            <script>
              $("#Selector").on("click", function() { //偵測店取或外送
                $("#Selector option:selected").each(function () {
                  if($(this).val() == "bySelf"){
                    document.getElementById("div外送日期").style.display = 'none';
                    document.getElementById("div店取日期").style.display = 'block';
                    document.getElementById("div店取時間").style.display = 'block';
                  }
                  if($(this).val() == "byCar"){
                    document.getElementById("div外送日期").style.display = 'block';
                    document.getElementById("div店取日期").style.display = 'none';
                    document.getElementById("div店取時間").style.display = 'none';
                  }
                });
              });
            </script>
            <?php
                $g=mysqli_query ( $con,"select * from 商品 where 供貨廠商!='鑫旺免洗餐具行豐原營業處';");
                $ga=mysqli_fetch_array($g);
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
                            echo "<tr><td>",$ga2['規格'],"</td><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"' min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
                        }else{
                            echo "<tr><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"' min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
                        }
                        $ga2=mysqli_fetch_array($g2);
                    }
                    echo "</tbody></table></div>";
                    for($j;$j>0;$j--){
                        $ga=mysqli_fetch_array($g);
                    }
                    $j=0;
                }
                $g=mysqli_query ( $con,"select * from 商品 where 供貨廠商='鑫旺免洗餐具行豐原營業處' AND 單價 !=0;");
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
                            echo "<tr><td>",$ga2['規格'],"</td><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"' min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
                        }else{
                            echo "<tr><td>",$ga2['單價'],"</td><td><label><input type='number' name='",$ga2['商品名稱'],$ga2['規格'],$ga2['單位'],"' min='0' max='50' value='0'>",$ga2['單位'],"</label></td></tr>";
                        }
                        $ga2=mysqli_fetch_array($g2);
                    }
                    echo "</tbody></table></div>";
                    for($j;$j>0;$j--){
                        $ga=mysqli_fetch_array($g);
                    }
                    $j=0;
                }
            ?>
            
            <br><br>
            <input type="submit" class="addOrder" value="送出訂單">
            </form>
            <form name="form2" method="post" action="clientFunctionSelect.php">
            <input type="submit" value="返回">
            </form>
            </div>
    </section>
                </main>  
                <?php
        mysqli_close ( $con ); 
    ?>   
  </body>
  
</html>