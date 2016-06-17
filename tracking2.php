<html>
<head>
<meta charset="UTF-8">
<title>tracking your order</title>
<style> 
    body {
        margin: auto;
        width: auto;
        padding: 10px;
        border: 1px solid black;
        background: lightblue;
    }
    .title {
        text-align: center;
        padding:30px;
        }
    
    div.input{
        margin: auto;
        width: 60%;
        font-size:18;
        padding: 10px;
    }

    input {
        font-size: 18;
    }
    input.text {
        width:60%;
        height: 30px;
        border: 1px solid steelblue;
        font-family: Times;
    }
    
    div.info{
        margin: auto;
        width: 60%;
        padding: 10px;

    }
    table{
        margin: auto;
        width: 100%;
        padding: 10px;
        border: 1px solid steelblue;
    }

</style>
</head>
<body>
<h3 class='title'>三妞美国正品代购</h3>
<form method='get'>
    <div class='input'>
    <label>
     输入订单号：
    <input class='text' type='text' name= 'tracking-number' value="">
    <input class='submit' type='submit' value='提交'>
    </label>
    </div>
</form>
<div class='info'>
<p>订单追踪：</p>
<p>订单号:</p>
<table>
<?php
    $ch = curl_init();
    curl_setopt_array(
        $ch, array(
            CURLOPT_URL => 'http://www.heyshopstreet.com/Transport/search?WaybillNumber=FU20160501001',
            CURLOPT_RETURNTRANSFER => true
            ));
    $html = curl_exec($ch);
    curl_close($ch);
    $dom = new DOMDocument();;
    $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
    $count = 0;
    foreach($dom->getElementsByTagName('td') as $td) {
        echo '<tr>';
        if ($count != 0) {
            $s = trim($td->nodeValue);
            //echo $s.'<br>';
            $arr = preg_split("/[\s]+/", $s);
            $len = count($arr);
            for ($i=0; $i<count($arr); $i++){
                echo '<td>'.$arr[$i].'&nbsp;&nbsp;</td>';
            }
        }
        echo '</tr>';
        $count ++;
    }
?>
</table>
<p>Sorry亲,目前检索不到亲的订单信息,请亲耐心等待！</p>


</div>
</body>
</html>
