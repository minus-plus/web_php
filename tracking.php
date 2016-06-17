<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>三妞美国代购-订单跟踪</title>

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
    .error {color:red;}
</style>
</head>
<body>
<?php
    $tracking_num = '';
    $tracking_err = '';
    $has_error = false;
    function test_tracking_num() {
        global $tracking_num, $tracking_err, $has_error;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $tracking_num = $_POST["tracking-number"];;
            if (empty($_POST["tracking-number"])) {
                $tracking_err = "请输入订单号！";
                $has_error = true;
            } else if (!preg_match("/^201[0-9]{8,9}$/", $tracking_num)) {
                $tracking_err = "订单号有误，请重新输入！";
                $has_error = true;
            }
        }
    }
    test_tracking_num();

    function tracking_info($tracking_num) {
        global $has_error;
        $result = '';
        if ($has_error) {
            return $result;
        }
        $ch = curl_init();
        curl_setopt_array(
            $ch, array(
                CURLOPT_URL => 'http://www.heyshopstreet.com/Transport/search?WaybillNumber=FU'.$tracking_num,
                CURLOPT_RETURNTRANSFER => true
                ));
        $html = curl_exec($ch);
        curl_close($ch);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        $count = 0;
        foreach($dom->getElementsByTagName('td') as $td) {
            if ($count != 0) {
                $result .= '<tr>';
                $s = trim($td->nodeValue);
                //echo $s.'<br>';
                $arr = preg_split("/[\s]+/", $s);
                //print_r($arr);
                for ($i=0; $i<count($arr); $i++){
                    print_r($arr[2]);
                    if(!preg_match('/[\s]+/', $arr[$i])) {
                        $result .= '<td>'.$arr[$i].'</td>';
                    }
                }
                $result .= '</tr>';
            }
            $count ++;
        }
        return $result;
    }

?>

<h3 class='title'>三妞美国正品代购</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class='input'>
    <label>
     输入订单号：
    <input class='text' type='text' name= 'tracking-number' value="<?php echo $tracking_num;?>">
    <input class='submit' type='submit' value='提交'>
    <p class="error"><?php echo $tracking_err;?></p>
    </label>
    </div>
</form>
<div class='info'>
    <?php
        $table = tracking_info($tracking_num);
        if ($table != ''){
            echo '订单追踪:'.'<br>';
            echo '订单号:'.$tracking_num.'<br>';
            echo '<table>'.$table.'</table>';
        }
        else if($tracking_num != '' and !$has_error) {
            echo 'Sorry亲,目前检索不到亲的订单信息,请亲耐心等待！';
        }
    ?>
</div>
</body>
</html>
