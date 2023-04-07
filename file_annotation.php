<?php

$symbols=array();
$symbols["A"]=11.27;
$symbols["B"]=10.05;
$symbols["C"]=10.27;
$symbols["D"]=12.19;
$symbols["E"]=8.81;
$symbols["F"]=8.52;
$symbols["G"]=11.91;
$symbols["H"]=12.38;
$symbols["I"]=4.71;
$symbols["J"]=5.79;
$symbols["K"]=10.17;
$symbols["L"]=8.23;
$symbols["M"]=15.64;
$symbols["N"]=13.01;
$symbols["O"]=13.04;
$symbols["P"]=9.79;
$symbols["Q"]=13.06;
$symbols["R"]=10.46;
$symbols["S"]=9.24;
$symbols["T"]=9.5;
$symbols["U"]=11.94;
$symbols["V"]=10.83;
$symbols["W"]=16.29;
$symbols["X"]=10.33;
$symbols["Y"]=9.66;
$symbols["Z"]=9.93;
$symbols["a"]=8.85;
$symbols["b"]=10.23;
$symbols["c"]=8.04;
$symbols["d"]=10.25;
$symbols["e"]=9.08;
$symbols["f"]=5.56;
$symbols["g"]=10.24;
$symbols["h"]=9.86;
$symbols["i"]=4.27;
$symbols["j"]=4.565;
$symbols["k"]=8.73;
$symbols["l"]=4.26;
$symbols["m"]=15;
$symbols["n"]=9.87;
$symbols["o"]=10.2;
$symbols["p"]=10.2;
$symbols["q"]=10.25;
$symbols["r"]=6.12;
$symbols["s"]=7.42;
$symbols["t"]=5.98;
$symbols["u"]=9.86;
$symbols["v"]=8.42;
$symbols["w"]=12.64;
$symbols["x"]=8.13;
$symbols["y"]=8.48;
$symbols["z"]=7.87;
$symbols[" "]=4.85;
$symbols["."]=3.86;
$symbols[","]=3.86;
$symbols[":"]=3.86;
$symbols[";"]=3.86;
$symbols["'"]=4.11;
$symbols["?"]=7.74;
$symbols["/"]=6.85;
$symbols["\\"]=6.68;
$symbols["<"]=11.88;
$symbols[">"]=11.88;
$symbols["\""]=6.98;
$symbols["["]=5.37;
$symbols["]"]=5.37;
$symbols["{"]=5.37;
$symbols["}"]=5.37;
$symbols["("]=5.37;
$symbols[")"]=5.37;
$symbols["-"]=6.93;
$symbols["+"]=11.88;
$symbols["="]=11.88;
$symbols["_"]=7.18;
$symbols["|"]=4.32;
$symbols["~"]=11.88;
$symbols["!"]=5.02;
$symbols["@"]=16.5;
$symbols["#"]=10.22;
$symbols["$"]=9.39;
$symbols["%"]=14.25;
$symbols["^"]=11.88;
$symbols["&"]=13.93;
$symbols["*"]=7.29;
$symbols["`"]=4.74;
$symbols["·"]=3.85;
$symbols["…"]=13.03;

?>
<?php
session_start();
header("content-type:text/html; charset=UTF-8");
$textId = $_GET['id'];
$link = mysqli_connect("localhost", "root", "", "smart_annotation");
$queryString = "select name,text from assignment where id='$textId'";
$rs = mysqli_query($link, $queryString);
$row = mysqli_fetch_assoc($rs);
$row['text'] = str_replace(PHP_EOL, '+', $row['text']);
$jsonText = json_decode($row['text'], true);
$article = $jsonText['data']['annotation']['content'];
$_SESSION['article']=$article;
$_SESSION['textId']=$textId;
if (array_key_exists('labelCategories', $jsonText['data']['annotation'])) {
    $numLabelCategories = count($jsonText['data']['annotation']['labelCategories']);
} else {
    $numLabelCategories = 0;
}
$numLabelCategories === 0 ? $labelId = 0 : $labelId = end($jsonText['data']['annotation']['labelCategories'])['id'];
$length = 1600;//以举行为标准（多少个汉字长度）


$articleArray = contentSplit($article, $length,$symbols);
for ($i=1;$i<count($articleArray);$i++){
    if ($articleArray[$i]!=""){
        $articleArrayNow[] = $articleArray[$i];
    }
}
$articleArray=$articleArrayNow;
//var_dump($articleArrayNow);
$_SESSION['articleArray']=$article;

// 务川写的绝对转相对
function contentSplit($wenzhang,$length,$symbols)
{
    //函数作用是将内容排版，返回一个切割了文章内容的字符串数组
    //length是规定的文章长度参数
    $lastlocation=0;
    $splitnum=0;
    $templength=0;
    $wenzhangarray=array();
    $codestr="zabcdefghijklmnopqrstuvwxyzZABCDEFGHIJKLMNOPQRSTUVWXYZ<>?/,.:'\";~!@#$%^&*()`\\|[]{}_- ·=…  ";//不要改动字符串顺序z为起位符
    $codestr1="0123456789";
    $codestr2="l+";

    for($i=0;$lastlocation<mb_strlen($wenzhang,"utf-8");$i++,$templength=0){
        for($j=$lastlocation;($templength<$length);$j++){
            //echo " ".$j;
            if(($j<mb_strlen($wenzhang,"utf-8"))&&(strpos($codestr2,mb_substr($wenzhang,$j,1,"utf-8")))){
                $templength+=$length;//换行
            }
            if(($j<mb_strlen($wenzhang,"utf-8"))&&(mb_substr($wenzhang,$j,1,"utf-8")=="z"||strpos($codestr,mb_substr($wenzhang,$j,1,"utf-8")))){
                if(isset($symbols[mb_substr($wenzhang,$j,1,"utf-8")])){
                    $templength+=$symbols[mb_substr($wenzhang,$j,1,"utf-8")];
                }
            }else if(($j<mb_strlen($wenzhang,"utf-8"))&&(mb_substr($wenzhang,$j,1,"utf-8")=="0"||strpos($codestr1,mb_substr($wenzhang,$j,1,"utf-8")))){
                $templength=$templength+9.38;//数字
            }else{
                $templength=$templength+16;//汉字
            }
            $splitnum=$j-$lastlocation;
        }
        $wenzhangarray[$i]=mb_substr($wenzhang,$lastlocation,$splitnum,"utf-8");
        $wenzhangarray[$i]=str_replace('+', '', $wenzhangarray[$i]);
        $lastlocation=$lastlocation+$splitnum+(($splitnum==0)?1:0);
    }
    return $wenzhangarray;
}
$labels="";
if (array_key_exists('labels',$jsonText['data']['annotation'])){
    $labels = $jsonText['data']['annotation']['labels'];
}
//var_dump($labels);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>信息抽取平台</title>
    <link rel="stylesheet" type="text/css" href="CSS/file_annotation.css"/>
    <link rel="stylesheet" type="text/css" href="CSS/farbtastic.css"/>
    <script src="JS/Jquery.js"></script>
    <script src="JS/farbtastic.js"></script>
    <script src="action/drawLabel.js"></script>
</head>
<body>
<!--<iframe src="action/addLabel_ToContent.php" >style="display: none"</iframe>-->
<div>
    <div id="header" class="header"><!-- 网页最上方TOP-->
        <div class="headerTitlepic"><!-- 网页最上方TOP左侧LOGO位置 -->
            <img src="image/webtitle.png" width="380px" height="50px"
                 style="margin: auto;position: relative;top: 0;left: 20px;bottom: 0;right: 0;"/><!--LOGO图片-->
        </div>
        <div id="headerUser" class="headerUser">
            <img src="image/icon/user.png" height="45px" width="45px"/>
            <div id="userName" style="text-align: center;margin-top: 0 ; position: absolute; top:10px;left:50px;"></div>
        </div><!-- 网页最上方TOP右侧用户位置 -->
    </div>
    <div id="leftMenu" class="leftMenu" style="width: 150px;"><!-- 网页左侧Left跳转功能栏 -->
        <ul class="leftMenulist">
            <li onclick="pageJump('file_list')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">文章列表</span>
            </li><!-- 按钮内容 -->
            <li onclick="pageJump('user_admin')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">用户管理</span>
            </li>
            <li onclick="pageJump('')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">日志</span></li>
            <li onclick="pageJump('')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">数据备份站</span>
            </li>
        </ul>
    </div>
    <div style="">
        <div class="fileInfocontainer"><!-- 作用是加上文件信息 -->
            <div style="position: relative; float: left;width: 50px;height: 43px;border: #00ff00 solid 1px;">
                <!-- 装入文件图片 -->
                <img src="image/icon/txt_icon.png" height="30px" width="30px"
                     style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;">
            </div>
            <span style="float:left;margin-top: 10px"><?php echo $row['name'] ?></span>
        </div class="fileInfocontainer">
        <div class="labelInfocontainer">
            <div id="labelBox" class="label_box">
                <label>实体标签:</label><br>
                <div id="label"></div>
                <div><span id="add_substance" class="addLabel_button" onclick="addSubstance()" aria-readonly="true">添加实体标签</span>
                </div>
            </div>
            <!--                        <div class="label_box" ">-->
            <!--                            关系标签：-->
            <!--                            <span class="label_nav">默认标签</span>-->
            <!--                            <span class="label_nav">默认标签</span>-->
            <!--                            <span class="label_nav">默认标签</span>-->
            <!--                            <button id="add_relation" name="add_relation" class="addLabel_button"  >添加关系标签</button>-->
            <!--                        </div>-->
        </div>
        <form id="selectedTextForm" action="" method="post">
            <input type="hidden" id="selectedText" name="selectedText" value=""/>
        </form>
        <div id="svgMaincontainer" class="svgMaincontainer"><!-- 作用是加上个滚动条 -->
            <svg id="svgArticle" style=" background-color:lavender;width: 1642px;height: <?php echo count($articleArray) * 60;
                 echo 'px' ?>;" xmlns="http://www.w3.org/2000/svg"><!-- svg框，需要改变 height 属性增加滚动条的量,width固定长度 -->
                <!-- <g><rect width="51" height="17" x="72" y="153" fill="red" rx="5" ry="5" /></g>-->
                <text id="textArray" style="z-index: 100 white-space: pre; " x="0" y="15" fill="black">
                    <!-- svg框，需要改变 height 属性增加滚动条的量 -->
                    <?php
                    for ($i = 0; $i < count($articleArray); $i++) {
                        echo "<tspan id='tspan_$i' x='10' dy='51'>$articleArray[$i]</tspan>";
                    }
                    ?>
                </text>
            </svg>
        </div>
    </div>
</div>
<!--        <button class="btn" id="JS_dialog">Click Me!</button>-->
<!--        遮罩层-->
<!--        <div class="mask" id="dialog_mask"></div>-->
<!--        弹出框盒子-->
<!--        <div class="dialog" id="dialogBox">-->
<!--            <span style="display: inline-block;">标签设置</span><span class="dialog_close" style="display: inline-block;padding-left: 470px;border-bottom: 1px solid #eee;">x</span>-->
<!--            <h5 id="select_text" class="dialog_title"></h5>-->
<!--            <div id="select_index" class="dialog_content"></div>-->
<!--        </div>-->

</body>

<script type="text/javascript">
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    const symbols = [];
    symbols["A"]=11.27;
    symbols["B"]=10.05;
    symbols["C"]=10.27;
    symbols["D"]=12.19;
    symbols["E"]=8.81;
    symbols["F"]=8.52;
    symbols["G"]=11.91;
    symbols["H"]=12.38;
    symbols["I"]=4.71;
    symbols["J"]=5.79;
    symbols["K"]=10.17;
    symbols["L"]=8.23;
    symbols["M"]=15.64;
    symbols["N"]=13.01;
    symbols["O"]=13.04;
    symbols["P"]=9.79;
    symbols["Q"]=13.06;
    symbols["R"]=10.46;
    symbols["S"]=9.24;
    symbols["T"]=9.5;
    symbols["U"]=11.94;
    symbols["V"]=10.83;
    symbols["W"]=16.29;
    symbols["X"]=10.33;
    symbols["Y"]=9.66;
    symbols["Z"]=9.93;
    symbols["a"]=8.85;
    symbols["b"]=10.23;
    symbols["c"]=8.04;
    symbols["d"]=10.25;
    symbols["e"]=9.08;
    symbols["f"]=5.56;
    symbols["g"]=10.24;
    symbols["h"]=9.86;
    symbols["i"]=4.27;
    symbols["j"]=4.565;
    symbols["k"]=8.73;
    symbols["l"]=4.26;
    symbols["m"]=15;
    symbols["n"]=9.87;
    symbols["o"]=10.2;
    symbols["p"]=10.2;
    symbols["q"]=10.25;
    symbols["r"]=6.12;
    symbols["s"]=7.42;
    symbols["t"]=5.98;
    symbols["u"]=9.86;
    symbols["v"]=8.42;
    symbols["w"]=12.64;
    symbols["x"]=8.13;
    symbols["y"]=8.48;
    symbols["z"]=7.87;
    symbols[" "]=4.85;
    symbols["."]=3.86;
    symbols[","]=3.86;
    symbols[":"]=3.86;
    symbols[";"]=3.86;
    symbols["'"]=4.11;
    symbols["?"]=7.74;
    symbols["/"]=6.85;
    symbols["\\"]=6.68;
    symbols["<"]=11.88;
    symbols[">"]=11.88;
    symbols["\""]=6.98;
    symbols["["]=5.37;
    symbols["]"]=5.37;
    symbols["{"]=5.37;
    symbols["}"]=5.37;
    symbols["("]=5.37;
    symbols[")"]=5.37;
    symbols["-"]=6.93;
    symbols["+"]=11.88;
    symbols["="]=11.88;
    symbols["_"]=7.18;
    symbols["|"]=4.32;
    symbols["~"]=11.88;
    symbols["!"]=5.02;
    symbols["@"]=16.5;
    symbols["#"]=10.22;
    symbols["$"]=9.39;
    symbols["%"]=14.25;
    symbols["^"]=11.88;
    symbols["&"]=13.93;
    symbols["*"]=7.29;
    symbols["`"]=4.74;
    symbols["·"]=3.85;
    symbols["…"]=13.03;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (sessionStorage.id === undefined) {
        window.location.href = 'login.php';
    } else {
        $('#userName').html(sessionStorage.id);
    }

    let countLabelNum = 0  //定义的二超js需要的参数
    let needThings = [];   //定义的二超js需要的参数
    let codestr="zabcdefghijklmnopqrstuvwxyzZABCDEFGHIJKLMNOPQRSTUVWXYZ<>?/,.:'\";~!@#$%^&*()`\\|[]{}+_- ·=…  ";
    let codestr1="0123456789";

    var numLabelCategories =<?php echo $numLabelCategories;?>;
    var labelId =<?php echo $labelId;?>;
    const jsonText = '<?php echo $row['text'];?>';
    json = JSON.parse(jsonText);
    // // console.log(json);

    //实体标签DOM 实现标签展示
    function showLabel(labelBox) {
        //展示标签的方法
        if (numLabelCategories !== 0) {
            let objLabelBox = $('#' + labelBox);
            for (let i in json['data']['annotation']['labelCategories']) {
                let labelSpan = $('<span>', {
                    class: 'label_nav',
                    id: json['data']['annotation']['labelCategories'][i]['id']
                });
                labelSpan.css({
                    backgroundColor: json['data']['annotation']['labelCategories'][i]['color']
                })
                labelSpan.html(json['data']['annotation']['labelCategories'][i]['text']);
                labelSpan.appendTo(objLabelBox);

                labelSpan.bind(
                    'contextmenu',
                    function (e) {
                        alert('实体标签不可删除！请联系管理员删除！')
                        // let objDialog = $('<dialog>', {
                        //     id: 'deleteDialog'
                        // });
                        // objDialog.appendTo(document.body);
                        // let objForm = $('<form>', {
                        //     method: 'dialog'
                        // })
                        // objForm.appendTo(objDialog);
                        // let objLabel = $('<label>要删除这个标签吗？<label>');
                        // objLabel.appendTo(objForm);
                        // let btnYes = $('<button>是</button>', {
                        //     type: 'submit'
                        // })
                        // btnYes.appendTo(objForm);
                        // let btnNo = $('<button>否</button>', {
                        //     type: 'submit'
                        // })
                        // btnNo.appendTo(objForm);
                        // document.getElementById('deleteDialog').showModal();
                        // btnYes.bind(
                        //     'click',
                        //     function () {
                        //         let id = labelSpan.attr('id');
                        //         $.ajax({
                        //             url: "/action/deleteCategoryLabel.php?id=" + id,
                        //             type: 'POST',
                        //             data: jsonText,
                        //             success: successCallback
                        //         })
                        //
                        //         function successCallback(result) {
                        //             // console.log(result);
                        //         }
                        //
                        //         setInterval(() => {
                        //             location.replace(location.href)
                        //         }, 100);
                        //         objDialog.remove();
                        //     }
                        // )
                        // btnNo.bind(
                        //     'click',
                        //     function () {
                        //         // console.log('no');
                        //         objDialog.remove();
                        //     }
                        // )
                        e.preventDefault();
                    }
                )
            }
        }
    }
    showLabel("label");

    //添加实体标签
    function addSubstance() {
        let objDialog = $('<dialog>', {
            id: 'addLabel',
            destroy_on_close: 'true'
        });
        objDialog.appendTo(document.body);
        let objForm = $('<form>', {method: 'dialog'});
        objForm.appendTo(objDialog);
        objForm.append('<label>标签名称:</label>');
        let objTextInput = $('<input>', {type: 'text'});
        objTextInput.appendTo(objForm);
        objForm.append('<br>');
        objForm.append('<label>标签颜色:</label>');
        let objColorInput = $('<input>', {
            type: 'text',
            id: 'color',
            name: 'color',
            width: '55px',
            value: '#66ccff'
        })
        objColorInput.appendTo(objForm);
        let objColorPicker = $('<div>', {
            id: 'colorPicker'
        })
        objColorPicker.appendTo(objForm);
        $(document).ready(function () {
            $('#colorPicker').farbtastic('#color');
        });
        let btnDetermine = $('<button>确认</button>', {
            type: 'submit',
            id: 'determine',
            name: 'determine',
        })
        btnDetermine.appendTo(objForm);
        let btnCancel = $('<button>取消</button>', {
            type: 'submit',
            id: 'cancel',
            name: 'cancel',
        })
        btnCancel.appendTo(objForm);
        document.getElementById('addLabel').showModal();

        btnDetermine.click(function () {
            let text = objTextInput.val();
            let color = objColorInput.val();
            if (numLabelCategories === 0) {
                // console.log(labelId);
                json.data.annotation.labelCategories = [{
                    id: labelId + 1,
                    text: text,
                    color: color,
                    borderColor: '#999999'
                }];
            } else {
                // console.log(labelId);
                json.data.annotation.labelCategories[labelId] = {
                    id: labelId + 1,
                    text: text,
                    color: color,
                    borderColor: '#999999'
                };
            }
            var jsonText2 = JSON.stringify(json);
            numLabelCategories++;
            labelId++;
            // console.log(labelId);
            $.ajax({
                url: '/action/addLabel.php',
                type: 'POST',
                data: jsonText2,
                success: successCallback
            })

            function successCallback(result) {
                // console.log(result);
            }

            let objLabelBox = $('#label');
            let labelSpan = $('<span>', {
                class: 'label_nav',
                id: numLabelCategories
            });
            labelSpan.html(text);
            labelSpan.css({
                backgroundColor: color
            })
            labelSpan.appendTo(objLabelBox);
            location.reload();
            objDialog.remove();
        });
        btnCancel.click(function () {
            objDialog.remove();
        });
    }

    //根据窗口大小自适应，但未解决窗口内文本内容自适应
    // $('#svgArticle').css({
    //     width: window.innerWidth-278
    // });
    // window.addEventListener('resize', function(){
    //     $('#svgArticle').css({
    //         width: window.innerWidth-278
    //     });
    // })

    // var scrollHeight = document.getElementById('svgMaincontainer').scrollHeight;
    // // console.log(document.getElementById('svgMaincontainer').style.height);
    // document.getElementById('svgMaincontainer').scroll(0, Math.round(520))

    //文本选择+打标签（分开写！！！！！！！！）
    // function getSelectText() {
    // //     //console.log(window.getSelection());
    // //     //console.log(window.getSelection().focusNode.parentElement);//获取值 两者不相同
    // //     //console.log(window.getSelection().anchorNode.parentElement);
    //     //判断是否选中
    //
    // }

    function changeAddressFrom_A_to_R(startIndex){
        let needTh=[];
        needTh['x']=0;
        needTh['y']=0;
        let tempLength=[startIndex,startIndex];
        let row=0;
        let objText=document.getElementById("textArray");
        for (let i of objText.childNodes){
            if (i.nodeName === "tspan"){
                // console.log(i.textContent);
                tempLength[0] =tempLength[1];
                tempLength[1]=tempLength[1]-i.textContent.length;
                // console.log("tempLength:"+tempLength[1]+"  row:"+row);
                row++;
                let objTspan_textContent =  document.getElementById("tspan_"+(row-1)).textContent;
                if (tempLength[1]<=0){
                    // console.log(tempLength[0]);
                    for (let j=0;j<tempLength[0];j++){
                        // console.log();
                        if (codestr.indexOf(objTspan_textContent[j])==-1&&codestr1.indexOf(objTspan_textContent[j])==-1){
                            needTh['x']=needTh['x']+16;
                        }
                        if(codestr1.indexOf(objTspan_textContent[j])!=-1){
                            needTh['x']=needTh['x']+9.38;
                        }
                        if (codestr.indexOf(objTspan_textContent[j])!=-1){
                            needTh['x']=needTh['x']+symbols[codestr[codestr.indexOf(objTspan_textContent[j])]];
                        }
                    }
                    needTh['x']=needTh['x']+10;
                    needTh['y']=row*51-1;
                    break;
                }

            }
        }
        // console.log(needTh);
        // console.log("^^^^^^^^^^^^^^^")
        return needTh;
    }

    function SqlDraw(){
        let labelArray;
        labelArray='<?php echo json_encode($labels); ?>';
        labelArray = JSON.parse(labelArray);
        // console.log(labelArray);
        if (labelArray!=""){
            for (let i in labelArray){
                let needTh=changeAddressFrom_A_to_R(labelArray[i]['starIndex']);
                console.log(labelArray[i]['categoryId']);
                DrawPath(0,(labelArray[i]['endIndex'] - labelArray[i]['starIndex']) * 17,document.getElementById(labelArray[i]['categoryId']).textContent,labelArray[i]['id'],document.getElementById(labelArray[i]['categoryId']).style.backgroundColor,needTh['x'],needTh['y'], <?php echo $textId;?>);
                countLabelNum++;
                // console.log(countLabelNum);
            }
        }
    }
    SqlDraw();
    //选中文本后跳出的Dialog
    function showDialog(left, right, x_selected, y_selected,selectFrom_AllStart,selectFrom_AllEnd) {
        // needThings[0]="";
        // needThings[1]=0;
        // needThings[2]=""

        // if (!$('#dialog_select_label')){
        // let objDialog = document.createElement('dialog');
        let objDialog = document.createElement('dialog');
        objDialog.id = 'dialog_select_label';

        // objDialog.style.display="";
        // objDialog.style.position="absolute";
        // objDialog.style.position="absolute";
        // objDialog.style.left="800px"
        // objDialog.style.right="600px";
        // objDialog.style.backgroundColor="#8e8e8e"
        let sendTexttemp;

        document.body.appendChild(objDialog);
        let objForm = $('<form>', {method: 'dialog'});
        objForm.appendTo(objDialog);
        objForm.append('<label style="margin-bottom: 30px">请选择标签:</label>');
        objForm.append('<input id="dialog_selected_show" type="text" disabled=true>');
        objForm.append('<br>');
        objForm.append('<br>');

        for (let i in json['data']['annotation']['labelCategories']) {
            let labelSpan = $('<span>', {
                class: 'label_nav',
                id: json['data']['annotation']['labelCategories'][i]['id']
            });
            labelSpan.css({
                backgroundColor: json['data']['annotation']['labelCategories'][i]['color']
            })
            labelSpan.html(json['data']['annotation']['labelCategories'][i]['text']);
            labelSpan.appendTo(objForm);
            labelSpan.bind(
                'click',
                function () {
                    needThings[2] = json['data']['annotation']['labelCategories'][i]['color'];
                    needThings[1] = labelSpan.attr('id');
                    needThings[0] = json['data']['annotation']['labelCategories'][i]['text'];
                    sendTexttemp=selectFrom_AllStart+","+selectFrom_AllEnd+","+needThings[1]+"_php_"+countLabelNum+","+needThings[1];
                    // console.log(sendTexttemp)
                    $("#dialog_selected_show").val(labelSpan.html());
                })
        }
        objForm.append('<br>');
        let btnDetermine = $('<button style="margin-top: 20px">确认</button>', {
            type: 'submit',
            id: 'determine',
            name: 'determine',
        })
        btnDetermine.appendTo(objForm);
        let btnCancel = $('<button style="margin-top: 20px">取消</button>', {
            type: 'submit',
            id: 'cancel',
            name: 'cancel',
        })
        btnCancel.appendTo(objForm);
        // objDialog.showModal();
        btnDetermine.bind(
            'click', function () {
                if (needThings[0] !== "" && needThings[1] !== 0 && needThings[2] !== "") {
                    // // console.log("test_2 x:" + x_selected, " y:" + y_selected);
                    countLabelNum++;
                    DrawPath(0, (right - left) * 17, needThings[0], needThings[1] + "_js_" + countLabelNum, needThings[2], x_selected, y_selected, <?php echo $textId;?>);
                    setInterval(() => {
                        location.replace(location.href)
                    }, 200);
                }
                $.ajax({
                    url: 'action/addLabel_ToContent.php',
                    type: 'POST',
                    data: sendTexttemp,
                    success: successCallback
                })
                function successCallback(result) {
                    // console.log(result);
                }
                objDialog.remove();
            }
        )
        btnCancel.bind(
            'click', function () {
                // objDialog.close();
                objDialog.remove();
            }
        )
    }

    $('#textArray').click(function () {


        needThings[0] = "";
        needThings[1] = 0;
        needThings[2] = "";
        var range = window.getSelection().getRangeAt(0);
        var rect_Select = range.getBoundingClientRect();
        const x_selected = rect_Select.left + document.getElementById("svgMaincontainer").scrollLeft - document.getElementById("svgMaincontainer").offsetLeft - 10;
        const y_selected = rect_Select.top + document.getElementById("svgMaincontainer").scrollTop - document.getElementById("svgMaincontainer").offsetTop - 10;
        // // console.log("test x:" + x_selected, " y:" + y_selected);
        // 获取鼠标选中文字,和始终位置
        var selecter = window.getSelection();
        var selectStr = selecter.toString();
        if (window.getSelection().focusNode.parentElement === window.getSelection().anchorNode.parentElement) {

            startIndex = (window.getSelection().anchorOffset < window.getSelection().focusOffset) ? window.getSelection().anchorOffset : window.getSelection().focusOffset;
            EndIndex = (window.getSelection().anchorOffset > window.getSelection().focusOffset) ? window.getSelection().anchorOffset : window.getSelection().focusOffset;
            // console.log("选取的文字：" + window.getSelection().toString() + "————起始位置" + startIndex + "终止位置" + EndIndex + "第" + window.getSelection().focusNode.parentElement.id + "行");
            document.getElementById("selectedText").value = window.getSelection().focusNode.parentElement.id + "," + startIndex + "," + EndIndex;
            // document.getElementById("selectedTextForm").submit();
            // console.log('selectStr:', selectStr);//选中的文字
            if (!selectStr || !selectStr.trim()) return;
            //获取位置
            let position = {};
            position.left = selecter.anchorOffset;
            position.right = selecter.focusOffset;
            // console.log(position);

            let startIndex_All=position.left;
            let endIndex_All;
            // console.log(window.getSelection().focusNode.parentElement.id);
            for (let i of document.getElementById("textArray").childNodes){
                if (i.nodeName === "tspan"){
                    if (i.id==window.getSelection().focusNode.parentElement.id){
                        break;
                    }
                    startIndex_All=startIndex_All+i.textContent.length;
                }
            }
            endIndex_All=startIndex_All+position.right-position.left;
            // console.log("startIndex_All: "+startIndex_All+"     endIndex_All: "+endIndex_All)

            //渲染并且打开选择标签控件
            showDialog(position.left, position.right, x_selected, y_selected,startIndex_All,endIndex_All);
            document.getElementById("dialog_select_label").showModal();
        } else {
             alert("请不要跨行选择");
            // rowNumAbs=Math.abs(window.getSelection().focusNode.parentElement.id-window.getSelection().anchorNode.parentElement.id);
            // addRows="";
            // for(var i=0;i<rowNumAbs;i++){
            //     addRows+="+";
            // }
            // if(window.getSelection().focusNode.parentElement.id>window.getSelection().anchorNode.parentElement.id){
            //     //正选
            //     var startIndex=window.getSelection().anchorOffset;
            //     var EndIndex=window.getSelection().focusOffset;
            //     sendText=window.getSelection().anchorNode.parentElement.id+","+startIndex+","+addRows+","+EndIndex;
            // }else{
            //     //反选
            //     var startIndex=window.getSelection().focusOffset;
            //     var EndIndex=window.getSelection().anchorOffset;
            //     sendText=window.getSelection().focusNode.parentElement.id+","+startIndex+","+addRows+","+EndIndex;
            // }
        }
    });

    function pageJump(page) {
        //传入Page名
        //作用页面跳转
        if (page === "") {
            alert("页面开发中，敬请期待!");
        } else {
            window.location.href = page + ".php";
        }
    }
</script>
</html>