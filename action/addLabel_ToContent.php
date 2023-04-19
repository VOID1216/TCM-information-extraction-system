<?php
$symbols = array();
$symbols["A"] = 11.27;
$symbols["B"] = 10.05;
$symbols["C"] = 10.27;
$symbols["D"] = 12.19;
$symbols["E"] = 8.81;
$symbols["F"] = 8.52;
$symbols["G"] = 11.91;
$symbols["H"] = 12.38;
$symbols["I"] = 4.71;
$symbols["J"] = 5.79;
$symbols["K"] = 10.17;
$symbols["L"] = 8.23;
$symbols["M"] = 15.64;
$symbols["N"] = 13.01;
$symbols["O"] = 13.04;
$symbols["P"] = 9.79;
$symbols["Q"] = 13.06;
$symbols["R"] = 10.46;
$symbols["S"] = 9.24;
$symbols["T"] = 9.5;
$symbols["U"] = 11.94;
$symbols["V"] = 10.83;
$symbols["W"] = 16.29;
$symbols["X"] = 10.33;
$symbols["Y"] = 9.66;
$symbols["Z"] = 9.93;
$symbols["a"] = 8.85;
$symbols["b"] = 10.23;
$symbols["c"] = 8.04;
$symbols["d"] = 10.25;
$symbols["e"] = 9.08;
$symbols["f"] = 5.56;
$symbols["g"] = 10.24;
$symbols["h"] = 9.86;
$symbols["i"] = 4.27;
$symbols["j"] = 4.565;
$symbols["k"] = 8.73;
$symbols["l"] = 4.26;
$symbols["m"] = 15;
$symbols["n"] = 9.87;
$symbols["o"] = 10.2;
$symbols["p"] = 10.2;
$symbols["q"] = 10.25;
$symbols["r"] = 6.12;
$symbols["s"] = 7.42;
$symbols["t"] = 5.98;
$symbols["u"] = 9.86;
$symbols["v"] = 8.42;
$symbols["w"] = 12.64;
$symbols["x"] = 8.13;
$symbols["y"] = 8.48;
$symbols["z"] = 7.87;
$symbols[" "] = 4.85;
$symbols["."] = 3.86;
$symbols[","] = 3.86;
$symbols[":"] = 3.86;
$symbols[";"] = 3.86;
$symbols["'"] = 4.11;
$symbols["?"] = 7.74;
$symbols["/"] = 6.85;
$symbols["\\"] = 6.68;
$symbols["<"] = 11.88;
$symbols[">"] = 11.88;
$symbols["\""] = 6.98;
$symbols["["] = 5.37;
$symbols["]"] = 5.37;
$symbols["{"] = 5.37;
$symbols["}"] = 5.37;
$symbols["("] = 5.37;
$symbols[")"] = 5.37;
$symbols["-"] = 6.93;
$symbols["+"] = 11.88;
$symbols["="] = 11.88;
$symbols["_"] = 7.18;
$symbols["|"] = 4.32;
$symbols["~"] = 11.88;
$symbols["!"] = 5.02;
$symbols["@"] = 16.5;
$symbols["#"] = 10.22;
$symbols["$"] = 9.39;
$symbols["%"] = 14.25;
$symbols["^"] = 11.88;
$symbols["&"] = 13.93;
$symbols["*"] = 7.29;
$symbols["`"] = 4.74;
$symbols["·"] = 3.85;
$symbols["…"] = 13.03;
?>
<?php
session_start();
$textId = $_SESSION['textId'];
header("content-type:text/html; charset=UTF-8");
if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    // ajax 请求的处理方式
    $ifSoloChoose=$_GET['ifSoloChoose'];                        // ifSoloChoose 是否单行选择的标记
    $Array = file_get_contents('php://input');
    $Array = explode(",", $Array);
    $link = mysqli_connect('localhost', 'root', '', 'smart_annotation');
    $queryString = "select text from assignment where id = '$textId'";
    @$rs = mysqli_query($link, $queryString);
    @$row = mysqli_fetch_row($rs);
    $json = json_decode($row[0], true);

    if ($ifSoloChoose=="true"){                        // ifSoloChoose 是否单行选择的标记 跨行选择则会添加标签到头部，反则为添加到尾部，提前渲染跨行的标签;
        $countLabel = @count($json['data']['annotation']['labels']);
        $json['data']['annotation']['labels'][$countLabel]['starIndex'] =$Array[0];
        $json['data']['annotation']['labels'][$countLabel]['endIndex'] = $Array[1];
        $json['data']['annotation']['labels'][$countLabel]['id'] = $Array[2];
        $json['data']['annotation']['labels'][$countLabel]['categoryId'] = $Array[3];
    }else{
        $Array_across['starIndex']= $Array[0];
        $Array_across['endIndex']= $Array[1];
        $Array_across['id']= $Array[2];
        $Array_across['categoryId']= $Array[3];
        if ($json['data']['annotation']['labels']!=[]||in_array("label",$json['data']['annotation'])){
//            echo "已经有label了，可以插值";
            array_unshift($json['data']['annotation']['labels'],$Array_across);
        }else{
//            echo "没有label，插首值";
            $json['data']['annotation']['labels'][0]['starIndex'] =$Array[0];
            $json['data']['annotation']['labels'][0]['endIndex'] = $Array[1];
            $json['data']['annotation']['labels'][0]['id'] = $Array[2];
            $json['data']['annotation']['labels'][0]['categoryId'] = $Array[3];
        }
    }


    $json = json_encode($json,JSON_UNESCAPED_UNICODE);

    $queryString = "update assignment set text='$json' where id='$textId'";
    mysqli_query($link, $queryString);
    echo mysqli_error($link);
    echo $json;
}
