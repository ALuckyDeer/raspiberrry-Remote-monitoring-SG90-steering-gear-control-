<?php
header("Content-type: text/html; charset=utf-8");
if(!isset($_POST['direction']))
{
    echo -1;#没有POST
}
else
{
    $direction=$_POST['direction'];
    $ar="";
}
switch ($direction){
    case "up":
        $ar="VU";
        break;
    case "down":
        $ar="VD";
        break;
    case "left":
        $ar="HL";
        break;
    case "right":
        $ar="HR";
        break;
    case "reset":
        $ar="RESET";
        break;
    default:
        break;
}
$output = exec('sudo  python   ./camera_controler.py'." ".$ar);
echo $output;
?>