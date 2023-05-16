<?php
header("content-type:text/html; charset=UTF-8");
require_once '../db_config.php';
if (isset($_POST)) {
    $id = $_GET['id'];
//    $id = 1;
    $jsonString = file_get_contents('php://input');
//    $jsonString = '{"data":{"id":3,"annotation":{"content":"寮犳煇锛屽コ锛�66宀併€�+鍒濊瘖锛�2013骞�4鏈�2鏃ャ€�+涓昏瘔锛氬挸鍡�2鍛ㄣ€�+鐜扮梾鍙诧細鎮ｈ€呬竴鍛ㄥ墠鎰熷啋锛屾櫒璧烽蓟娴侀粍娑曪紝鍜粍绮樼棸锛岀幇鍜冲椊锛屽挸灏戦噺鐏拌鑹叉竻娑曪紝绾冲樊涓嶉锛屽枩鐑ギ锛屽叆鐫″洶闅撅紝闃靛彂鎬ф睏鍑猴紝鍙屼笅鑲㈠嚬闄锋按鑲匡紝楹绘湪锛屼箯鍔涳紝浜屼究璋冿紝鑸屾殫绾紝鑻旇吇寰粍锛岃剦寮︾粏銆�+杈ㄨ瘉锛氶閭儊琛紝鑴捐櫄鐥板嚌銆�+娌诲垯锛氳В琛ㄥ拰閲屽仴鑴撅紝鍖栫棸姝㈠挸銆�+澶勬柟锛氬皬鏌磋儭姹ゅ姞鍑�+鏂硅嵂锛氭煷鑳�15g锛岄粍鑺�15g锛屽崐澶�9g锛岄檲鐨�10g锛屾鏋�10g锛岀櫧鑺�10g锛屽共濮�9g锛屼簲鍛冲瓙10g锛岄粍鑺�30g锛岀倷鐢樿崏10g銆�3鍓傦紝姘寸厧鏈嶃€�+浜岃瘖锛氭湇涓婃柟鍜冲椊澶у噺锛屽張鏈嶄笁鍓傝€屾剤銆�+鎸夎锛氶亣鍐峰垯榧绘祦娓呮稌锛屼负澶槼椋庨偑閮佽〃涓嶈В銆傚挸鍡姐€佸挴鐥伴粍锛岃嫈鑵昏€岄粍锛屼负鐥扮儹銆傜劧鎮ｈ€呬箯鍔涳紝绾冲樊鍠滅儹椋燂紝涓嬭偄姘磋偪锛屾鐨嗗洜鑴捐儍铏氬急锛屾按婀夸笉鍖栵紝鑱氳€屾垚鐥帮紝閮佽€屽寲鐑墍鑷淬€傜棸鐑唴闃伙紝闃撮槼涔嬫皵涓嶇浉椤烘帴锛屾晠鍙澶辩湢姹楀嚭銆傜礌浣撹櫄寮憋紝澶栨劅鑰岀梾锛屾晠浠ユ鏋濇堡鍜岃В鐤忛锛涘皬鏌磋儭姹よ繍杞灑鏈轰互鍔╄В琛ㄥ拰閲屻€傛槗浜哄弬涓洪粍鑺紝浠ラ粍鑺湁鍒╂按鍔熸晥銆傜棸铏介粍绮橈紝鍥犱簬鐥伴ギ鍖栫儹锛屽皧鈥滅梾鐥伴ギ鑰呬互娓╄嵂鍜屼箣鈥濆畻鏃紝浠嶄互骞插銆佷簲鍛冲瓙鍖栭ギ姝㈠挸锛屽悎榛勮姪浠ユ竻鐑€�","labelCategories":[{"id":1,"text":"123","color":"#cdd2d5","borderColor":"#999999"},{"id":2,"text":"1234","color":"#ff6c66","borderColor":"#999999"}],"labels":{"0":{"starIndex":"16","endIndex":"18","id":"1_php_0","categoryId":"1"},"1":{"starIndex":"33","endIndex":"35","id":"1_php_1","categoryId":"1"},"2":{"starIndex":"46","endIndex":"48","id":"2_php_2","categoryId":"2"},"4":{"starIndex":"184","endIndex":"186","id":"2_php_4","categoryId":"2"}}}}}';
    $json = json_decode($jsonString, true);
//    echo json_last_error();
//    var_dump($json['data']['annotation']['labelCategories']);
    foreach ($json['data']['annotation']['labelCategories'] as $val) {
        if ($val['id'] == $id) {
            unset($json['data']['annotation']['labelCategories'][$val['id']-1]);
            break;
        }
    }
    echo '<br>';
//    var_dump($json['data']['annotation']['labelCategories']);
    $textId = $json['data']['id'];
    $jsonText = json_encode($json,JSON_UNESCAPED_UNICODE);
    $queryString="update assignment set text='$jsonText' where id='$textId'";
    mysqli_query($link,$queryString);
    echo $jsonText;
//    echo mysqli_error($link);
//    $queryString="select text from assignment where id='$textId'";
//    $row=mysqli_fetch_row(mysqli_query($link,$queryString));
//    echo $row[0];
    //$json = json_decode($json, true);
    //var_dump($json);
}