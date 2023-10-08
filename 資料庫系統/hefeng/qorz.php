<?php
if($_POST['act']=='qianshou'){
include ("qianshou2.php");  
}else if($_POST['act']=="zhuijia"){
include("zhuijia.php");
}else if($_POST['act']=="paichedan"){
    include("paichedan.php");
}
?>