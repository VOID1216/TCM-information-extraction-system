<?php
require_once './db_config.php';
session_start();
$scrollOldTop_list = 0;
$scrollOldTop_list = $_GET['scrollOldTop_list'];
$isTag = $_GET['isTag'];
$userName = $_SESSION['userName'];
if (isset($_SESSION['level'])) {
    $level = $_SESSION['level'];
} else {
    $level = 2;
}
header("content-type:text/html; charset=UTF-8");
$textId = $_GET['id'];
$nowTag = $_GET['tag'];
$queryString = "select name,text from assignment where id='$textId'";
$rs = mysqli_query($link, $queryString);
$row = mysqli_fetch_assoc($rs);
$row['text'] = str_replace(PHP_EOL, '￥', $row['text']);
$jsonText = json_decode($row['text'], true);
$article = $jsonText['data']['annotation']['content'];
$_SESSION['article'] = $article;
$_SESSION['textId'] = $textId;
if (array_key_exists('labelCategories', $jsonText['data']['annotation'])) {
    $numLabelCategories = count($jsonText['data']['annotation']['labelCategories']);
} else {
    $numLabelCategories = 0;
}
$numLabelCategories === 0 ? $labelId = 0 : $labelId = end($jsonText['data']['annotation']['labelCategories'])['id'];
//var_dump($articleArrayNow);
$_SESSION['articleArray'] = $article;
$labels = "";
if (array_key_exists('labels', $jsonText['data']['annotation'])) {
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
            <li onclick="pageJump('file_list')">
                <span
                    style="display: block; text-align: center; line-height: 30px; color: black;">文章列表
                </span>
            </li><!-- 按钮内容 -->
            <li id="uerAdmin" onclick="pageJump('user_admin')">
                <span
                    style="display: block; text-align: center; line-height: 50px; color: white; ">用户管理</span>
            </li>

            <li>
                <span
                    style="display: block; text-align: center; line-height: 30px; color: black;">日志
                </span>
            </li>
            <li>
                <span
                    style="display: block; text-align: center; line-height: 30px; color: black;">数据备份站
                </span>
            </li>

        </ul>
    </div>
    <div style="">
        <div class="fileInfocontainer"><!-- 作用是加上文件信息 -->
            <div style="position: relative; float: left;width: 50px;height: 43px;">
                <!-- 装入文件图片 -->
                <img src="image/icon/txt_icon.png" height="40px" width="43px" style="margin-top: 3px">
            </div>
            <span style="float:left;margin-top: 10px"><?php echo $row['name'] ?></span>
            <button id="btnIsTag"
                    style="position: relative; float: left; margin-top: 6px; margin-left: 10px; border-style: none; border-radius: 10px; width: 150px; height: 30px; text"
                    type="button"></button>
        </div class="fileInfocontainer">
        <div class="labelInfocontainer">
            <div id="labelBox" class="label_box">
                <label>实体标签:</label><br>
                <div id="label"></div>
                <div>
                    <span id="add_substance" class="addLabel_button" onclick="addSubstance()" aria-readonly="true">添加实体标签</span>
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
            <svg id="svgArticle" xmlns="http://www.w3.org/2000/svg">
                <!-- svg框，需要改变 height 属性增加滚动条的量,width固定长度 -->
                <!-- <g><rect width="51" height="17" x="72" y="153" fill="red" rx="5" ry="5" /></g>-->
                <text id="textArray" style="z-index: 100 white-space: pre; " x="0" y="15" fill="black">
                    <!-- svg框，需要改变 height 属性增加滚动条的量 -->
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
<script src="JS/Jquery.js"></script>
<script src="action/drawLabel.js"></script>

<script>

    //console.log('<?php //echo $userName?>//');
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    let countLabelNum = 0  //定义的二超js需要的参数
    let needThings = [];   //定义的二超js需要的参数
    let codestr = "zabcdefghijklmnopqrstuvwxyzZABCDEFGHIJKLMNOPQRSTUVWXYZ<>?/,.:'\";~!@#$%^&*()`\\|[]{}+_- ·=…  ";
    let codestr1 = "0123456789";

    var numLabelCategories =<?php echo $numLabelCategories;?>;
    var labelId =<?php echo $labelId;?>;
    var nowTag = '<?php echo $nowTag;?>';
    const jsonText = '<?php echo $row['text'];?>';
    json = JSON.parse(jsonText);

    let level = 2;
    level = <?php echo $level;?>;
    let textId = <?php echo $textId;?>;
    let isTag = <?php echo $isTag;?>;

    if (isTag === 0) {
        $('#btnIsTag').html('未完成');
        $('#btnIsTag').css({
            backgroundColor: '#999999'
        })
    } else {
        $('#btnIsTag').html('已完成');
        $('#btnIsTag').css({
            backgroundColor: '#39C5BB'
        })
    }

    $('#btnIsTag').bind(
        'click',
        () => {
            if (isTag === 1) {
                $('#btnIsTag').html('未完成');
                $('#btnIsTag').css({
                    backgroundColor: '#999999'
                })
            } else {
                $('#btnIsTag').html('已完成');
                $('#btnIsTag').css({
                    backgroundColor: '#39C5BB'
                })
            }
            $.ajax({
                url: '/action/changeIsTag.php?id=' + textId + '&isTag=' + isTag
            })
        }
    )
    // console.log(level);
    if (level === 2) {
        $('#add_substance').css({
            display: 'none'
        })
    }
    if (level === 2) {
        $('#uerAdmin').css({
            display: 'none'
        })
    }
    if (sessionStorage.id === undefined) {
        window.location.href = 'login.php';
    } else {
        $('#userName').html('<?php echo $userName?>');
    }

    //symbols
    const symbols = [];
    symbols["A"] = 11.27;
    symbols["B"] = 10.05;
    symbols["C"] = 10.27;
    symbols["D"] = 12.19;
    symbols["E"] = 8.81;
    symbols["F"] = 8.52;
    symbols["G"] = 11.91;
    symbols["H"] = 12.38;
    symbols["I"] = 4.71;
    symbols["J"] = 5.79;
    symbols["K"] = 10.17;
    symbols["L"] = 8.23;
    symbols["M"] = 15.64;
    symbols["N"] = 13.01;
    symbols["O"] = 13.04;
    symbols["P"] = 9.79;
    symbols["Q"] = 13.06;
    symbols["R"] = 10.46;
    symbols["S"] = 9.24;
    symbols["T"] = 9.5;
    symbols["U"] = 11.94;
    symbols["V"] = 10.83;
    symbols["W"] = 16.29;
    symbols["X"] = 10.33;
    symbols["Y"] = 9.66;
    symbols["Z"] = 9.93;
    symbols["a"] = 8.85;
    symbols["b"] = 10.23;
    symbols["c"] = 8.04;
    symbols["d"] = 10.25;
    symbols["e"] = 9.08;
    symbols["f"] = 5.56;
    symbols["g"] = 10.24;
    symbols["h"] = 9.86;
    symbols["i"] = 4.27;
    symbols["j"] = 4.565;
    symbols["k"] = 8.73;
    symbols["l"] = 4.26;
    symbols["m"] = 15;
    symbols["n"] = 9.87;
    symbols["o"] = 10.2;
    symbols["p"] = 10.2;
    symbols["q"] = 10.25;
    symbols["r"] = 6.12;
    symbols["s"] = 7.42;
    symbols["t"] = 5.98;
    symbols["u"] = 9.86;
    symbols["v"] = 8.42;
    symbols["w"] = 12.64;
    symbols["x"] = 8.13;
    symbols["y"] = 8.48;
    symbols["z"] = 7.87;
    symbols[" "] = 4.85;
    symbols["."] = 3.86;
    symbols[","] = 3.86;
    symbols[":"] = 3.86;
    symbols[";"] = 3.86;
    symbols["'"] = 4.11;
    symbols["?"] = 7.74;
    symbols["/"] = 6.85;
    symbols["\\"] = 6.68;
    symbols["<"] = 11.88;
    symbols[">"] = 11.88;
    symbols["\""] = 6.98;
    symbols["["] = 5.37;
    symbols["]"] = 5.37;
    symbols["{"] = 5.37;
    symbols["}"] = 5.37;
    symbols["("] = 5.37;
    symbols[")"] = 5.37;
    symbols["-"] = 6.93;
    symbols["+"] = 11.88;
    symbols["="] = 11.88;
    symbols["_"] = 7.18;
    symbols["|"] = 4.32;
    symbols["~"] = 11.88;
    symbols["!"] = 5.02;
    symbols["@"] = 16.5;
    symbols["#"] = 10.22;
    symbols["$"] = 9.39;
    symbols["%"] = 14.25;
    symbols["^"] = 11.88;
    symbols["&"] = 13.93;
    symbols["*"] = 7.29;
    symbols["`"] = 4.74;
    symbols["·"] = 3.85;
    symbols["…"] = 13.03;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////// 《《《《《渲染顺序一》》》》》  ///实体标签DOM 实现标签展示////////////////////////////////////////
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
                        if (level === 2) {
                            alert('权限不足，请联系组长或管理员修改');
                        } else {
                            let objDialog = $('<dialog>', {
                                id: 'deleteDialog'
                            });
                            objDialog.appendTo(document.body);
                            let objForm = $('<form>', {
                                method: 'dialog'
                            })
                            objForm.appendTo(objDialog);
                            let objLabel = $('<label>标签删除后不可恢复！确认要删除吗？<label>');
                            objLabel.appendTo(objForm);
                            let btnYes = $('<button>是</button>', {
                                type: 'submit'
                            })
                            btnYes.appendTo(objForm);
                            let btnNo = $('<button>否</button>', {
                                type: 'submit'
                            })
                            btnNo.appendTo(objForm);
                            document.getElementById('deleteDialog').showModal();
                            btnYes.bind(
                                'click',
                                function () {
                                    let id = labelSpan.attr('id');
                                    $.ajax({
                                        url: "/action/deleteCategoryLabel.php?id=" + id,
                                        type: 'POST',
                                        data: jsonText,
                                        success: successCallback
                                    })

                                    function successCallback(result) {
                                        // console.log(result);
                                    }

                                    setTimeout(() => {
                                        location.replace(location.href)
                                    }, 100);

                                    objDialog.remove();
                                }
                            )
                            btnNo.bind(
                                'click',
                                function () {
                                    // console.log('no');
                                    objDialog.remove();
                                }
                            )
                        }
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
            id: 'addLabel'
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
            type: 'color',
            id: 'color',
            name: 'color',
            width: '55px',
            value: '#66ccff'
        })
        objColorInput.appendTo(objForm);
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

        btnDetermine.bind(
            'click',
            function () {
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
                    console.log('test');
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
                setTimeout(() => {
                    location.replace(location.href)
                }, 50);
                objDialog.remove();
            });
        btnCancel.click(function () {
            objDialog.remove();
        });
    }

    ////////////////////////////////////////////实体标签DOM 实现标签展示//////////////////////////////////////////////////////////////////

    ////////////////////////// 《《《《《渲染顺序二》》》》》  ///////文章处理函数 并且动态生成文章展示///////////////////////////////
    let widthOfScreen = document.body.clientWidth + 500;
    // console.log(json);
    let wenZhang = json['data']['annotation']['content'];
    wenZhang = wenZhang.split("￥").filter(item => item !== '');
    let objTextArray = document.getElementById("textArray");
    let objSvg = document.getElementById("svgArticle");

    objSvg.style.width = widthOfScreen;

    function cutArticle(wenZhang) {
        let wenZhangChangeLine = [];
        let countChangeLine = 0;
        // console.log(wenZhang)
        for (let i = 0; i < wenZhang.length; i++) {
            // console.log(wenZhang[i]);
            let tempLength = 10;
            let head = 0;
            let ifOnlyOneLine = true;
            for (let j = 0; j <= wenZhang[i].length; j++) {
                if (codestr.indexOf(wenZhang[i][j]) === -1 && codestr1.indexOf(wenZhang[i][j]) === -1) {
                    // console.log(tempLength+" _tempLength");
                    tempLength = tempLength + 16;
                }
                if (codestr1.indexOf(wenZhang[i][j]) !== -1) {
                    // console.log(tempLength+" _tempLength");
                    tempLength = tempLength + 9.38;
                }
                if (codestr.indexOf(wenZhang[i][j]) !== -1) {
                    // console.log(tempLength+" _tempLength");
                    tempLength = tempLength + symbols[codestr[codestr.indexOf(wenZhang[i][j])]];
                }

                ///////////////////////////////遍历到最后一行也没有超出屏幕长度/////////////////////////////
                if (j === wenZhang[i].length - 1 && tempLength <= widthOfScreen - 782 && ifOnlyOneLine === true) {
                    wenZhangChangeLine[countChangeLine] = wenZhang[i];
                    tempLength = 10;
                    countChangeLine++;
                }
                ///////////////////////////////遍历到tempLength大于了屏幕显示长度，并且此行为结束/////////////////////////////
                if (tempLength > widthOfScreen - 782 && j !== wenZhang[i].length - 1) {
                    // console.log("cut to "+countChangeLine+"  "+tempLength);
                    wenZhangChangeLine[countChangeLine] = wenZhang[i].slice(head, j);
                    // console.log(head+" "+j+"  tempL:"+tempLength+"  "+countChangeLine+"<<<<<cCL"+" 1:"+i)
                    // console.log(wenZhang[i].slice(head,j))
                    tempLength = 10;
                    countChangeLine++;
                    ifOnlyOneLine = false;
                    head = j;
                }
                ///////////////////////////////遍历到需跨行的段落的最后一段/////////////////////////////
                if (j === wenZhang[i].length - 1 && tempLength <= widthOfScreen - 782 && ifOnlyOneLine === false) {
                    wenZhangChangeLine[countChangeLine] = wenZhang[i].slice(head, j);
                    // console.log(wenZhang[i].slice(head,j+1)+"<<< END >>>")
                    tempLength = 10;
                    countChangeLine++;
                    break;
                }

            }
        }
        return wenZhangChangeLine.filter(item => item !== '');
    }

    // cutArticle(wenZhang);
    // console.log(cutArticle(wenZhang));
    function domArticle(wenZhang) {
        objSvg.style.height = wenZhang.length * 75 + 300;
        for (let i = 0; i < wenZhang.length; i++) {
            addTspan("tspan_", i, wenZhang);
        }
    }

    function addTspan(tspanName, i, wenZhang) {
        let objTspan = document.createElementNS("http://www.w3.org/2000/svg", "tspan")
        objTspan.setAttribute("id", tspanName + i);
        objTspan.setAttribute("x", "10");
        objTspan.setAttribute("dy", 51 + 24);
        objTspan.textContent = wenZhang[i];
        // console.log(objTspan);
        objTextArray.appendChild(objTspan);
    }

    domArticle(cutArticle(wenZhang));
    /////////////////////////////////文章处理函数 并且动态生成文章展示///////////////////////////////

    //////////////////////// 《《《《《《渲染顺序三》》》》》  /////////文章标签处理函数  动态生成标签///////////////////////////////
    function changeAddressFrom_A_to_R(startIndex, endIndex) {
        let needTh = [];
        needTh['x'] = 0;
        needTh['y'] = 0;
        let tempLength_forStart = [startIndex, startIndex];
        let tempLength_forEnd = [endIndex, endIndex];
        let row_Start = 0;
        let row_End = 0;
        let objText = document.getElementById("textArray");
        for (let i of objText.childNodes) {
            if (i.nodeName === "tspan") {
                if (tempLength_forEnd[1] < 0 && tempLength_forStart[1] < 0) {
                    // console.log("row_Start:"+row_Start+"  row_End:"+row_End);
                    break;
                }
                if (tempLength_forStart[1] >= 0) {
                    row_Start++;
                    tempLength_forStart[0] = tempLength_forStart[1];
                    tempLength_forStart[1] = tempLength_forStart[1] - i.textContent.length;
                }
                if (tempLength_forEnd[1] > 0) {
                    row_End++;
                    tempLength_forEnd[0] = tempLength_forEnd[1];
                    tempLength_forEnd[1] = tempLength_forEnd[1] - i.textContent.length;
                }
            }
        }
        if (row_Start === row_End) {
            // console.log("row_Start:"+row_Start+"  row_End:"+row_End);
            for (let j = 0; j < tempLength_forStart[0]; j++) {
                // console.log();
                let objTspan_textContent = document.getElementById("tspan_" + (row_Start - 1)).textContent;
                if (codestr.indexOf(objTspan_textContent[j]) === -1 && codestr1.indexOf(objTspan_textContent[j]) === -1) {
                    needTh['x'] = needTh['x'] + 16;
                }
                if (codestr1.indexOf(objTspan_textContent[j]) !== -1) {
                    needTh['x'] = needTh['x'] + 9.38;
                }
                if (codestr.indexOf(objTspan_textContent[j]) !== -1) {
                    needTh['x'] = needTh['x'] + symbols[codestr[codestr.indexOf(objTspan_textContent[j])]];
                }
            }
            needTh['x'] = needTh['x'] + 9;
        } else {
            let objTspan_start = document.getElementById("tspan_" + (row_Start - 1));
            let objTspan_end = document.getElementById("tspan_" + (row_End - 1));
            objTspan_end.innerHTML = objTspan_start.innerHTML.slice(tempLength_forStart[0], objTspan_start.innerHTML.length) + objTspan_end.innerHTML;
            objTspan_start.innerHTML = objTspan_start.innerHTML.slice(0, tempLength_forStart[0]);
            needTh['x'] = 9;
        }
        needTh['now_long'] = tempLength_forStart[0];
        needTh['tspan_id'] = row_End - 1;
        for (let i = 0; i < row_End; i++) {
            needTh['y'] = needTh['y'] + parseInt(document.getElementById("tspan_" + (i)).getAttribute("dy"));
        }
        for (let i = startIndex; i < endIndex; i++) {

        }
        // console.log(needTh);
        return needTh;
    }

    function labelWeight(labelArray) {
        let labelGroup = [];
        for (let i = 0; i < labelArray.length; i++) {
            let needTh = changeAddressFrom_A_to_R(labelArray[i]['starIndex'], labelArray[i]['endIndex']);
            labelGroup[i] = [0, 0, 0];
            let anchor_now = (parseInt(labelArray[i]['starIndex']) + parseInt(labelArray[i]['endIndex'])) / 2;
            let label_length_now = document.getElementById(labelArray[i]['categoryId']).innerText.length;
            if (i !== 0) {
                let anchor_before = (parseInt(labelArray[i - 1]['starIndex']) + parseInt(labelArray[i - 1]['endIndex'])) / 2;
                let label_length_before = document.getElementById(labelArray[i - 1]['categoryId']).innerText.length;
                if (anchor_now - anchor_before < (label_length_now + label_length_before) / 2) {
                    labelGroup[i][0] = 1;
                }
            }
            if (i !== (labelArray.length - 1)) {
                let anchor_after = (parseInt(labelArray[i + 1]['starIndex']) + parseInt(labelArray[i + 1]['endIndex'])) / 2;
                let label_length_after = document.getElementById(labelArray[i + 1]['categoryId']).innerText.length;
                if (anchor_after - anchor_now < (label_length_now + label_length_after) / 2) {
                    labelGroup[i][1] = 1;
                }
            }
            labelGroup[i][2] = needTh['tspan_id'];
        }
        return labelGroup;
    }

    function SqlDraw() {
        let labelArray;
        labelArray = '<?php echo json_encode($labels); ?>';
        labelArray = JSON.parse(labelArray);
        let labelGroup = labelWeight(labelArray);
        // console.log(labelGroup);

        if (labelArray !== "") {
            var overLength = 0;
            var happen = 0;
            var lineId_young = 0;
            for (let i = 0; i < labelArray.length; i++) {
                let lineId_old = -1;
                let needTh = changeAddressFrom_A_to_R(labelArray[i]['starIndex'], labelArray[i]['endIndex']);
                if (i < labelArray.length) {
                    // console.log("turn:"+i)
                    if (lineId_young == lineId_old || lineId_old == -1) {//判断是否为同一行
                        lineId_old = lineId_young;
                        lineId_young = labelGroup[i][2];
                        if (happen==2){
                            overLength=0;
                        }
                        if (labelGroup[i][0]==0&&labelGroup[i][1]==1){
                            happen=1;       //happen 为1代表重叠开始发生
                            overLength++;
                        }
                        if (labelGroup[i][0]==1&&labelGroup[i][1]==1){
                            overLength++;
                        }
                        if (labelGroup[i][0]==1&&labelGroup[i][1]==0){
                            happen=2;          //happen 为2代表重叠结束
                            overLength++;
                        }
                        if (labelGroup[i][0]==0&&labelGroup[i][1]==0){
                            overLength=0;
                        }
                    } else {
                        lineId_young = labelGroup[i][2];
                        overLength = 0;
                    }
                }
                // console.log(overLength+" lineId_old:"+lineId_old+" lineId_young:"+lineId_young)
                if (overLength % 2 !== 1) {
                    DrawPath(0, (labelArray[i]['endIndex'] - labelArray[i]['starIndex']) * 17, document.getElementById(labelArray[i]['categoryId']).textContent, labelArray[i]['id'], document.getElementById(labelArray[i]['categoryId']).style.backgroundColor, needTh['x'], needTh['y'], <?php echo $textId;?>, "true");
                } else {
                    // console.log("false overLength is "+overLength)
                    DrawPath(0, (labelArray[i]['endIndex'] - labelArray[i]['starIndex']) * 17, document.getElementById(labelArray[i]['categoryId']).textContent, labelArray[i]['id'], document.getElementById(labelArray[i]['categoryId']).style.backgroundColor, needTh['x'], needTh['y'], <?php echo $textId;?>, "false");
                }
                countLabelNum++;
            }
        }
    }

    SqlDraw();
    /////////////////////////////////文章标签处理函数 动态生成标签///////////////////////////////

    //选中文本后跳出的Dialog
    function showDialog(left, right, x_selected, y_selected, selectFrom_AllStart, selectFrom_AllEnd) {
        let objDialog = document.createElement('dialog');
        objDialog.id = 'dialog_select_label';
        let sendTexttemp;

        function IsOnly(sendTexttemp, objId) {
            if (document.getElementById(objId)) {
                console.log("已经存在 " + objId + " 了 __form isONly")
                sendTexttemp = selectFrom_AllStart + "," + selectFrom_AllEnd + "," + objId + "+" + "," + needThings[1];
                console.log("修改为：" + sendTexttemp);
                IsOnly(sendTexttemp, objId + "+");
                return sendTexttemp;
            } else {
                return sendTexttemp;
            }
        }

        document.body.appendChild(objDialog);
        let objForm = $('<form>', {method: 'dialog'});
        objForm.appendTo(objDialog);
        objForm.append('<label style="margin-bottom: 30px">请选择标签:</label>');
        objForm.append('<input id="dialog_selected_show" type="text" readonly>');
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
                    sendTexttemp = selectFrom_AllStart + "," + selectFrom_AllEnd + "," + needThings[1] + "_php_" + countLabelNum + "," + needThings[1];
                    sendTexttemp = IsOnly(sendTexttemp, needThings[1] + "_php_" + countLabelNum);
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

        function ifOnlyLabel(DrawLabelDate, id) {
            if (document.getElementById(id)) {
                console.log(id + "is 存在")
                DrawLabelDate[3] = DrawLabelDate[3] + "+";
                ifOnlyLabel(DrawLabelDate, DrawLabelDate[3]);
            }
        }
        var ifSoloChoose = true;//是否单行选择的标记
        btnDetermine.bind(
            'click', function () {
                if ($('#dialog_selected_show').val() !== "") {
                    if (needThings[0] !== "" && needThings[1] !== 0 && needThings[2] !== "") {
                        // // console.log("test_2 x:" + x_selected, " y:" + y_selected);
                        if (left !== -1 && right !== -1) {
                            let DrawLabelDate = [0, (right - left) * 17, needThings[0], needThings[1] + "_php_" + countLabelNum, needThings[2], x_selected, y_selected];
                            ifOnlyLabel(DrawLabelDate, needThings[1] + "_php_" + countLabelNum)
                            // console.log(DrawLabelDate);
                            DrawPath(DrawLabelDate[0], DrawLabelDate[1], DrawLabelDate[2], DrawLabelDate[3], DrawLabelDate[4], DrawLabelDate[5], DrawLabelDate[6], <?php echo $textId;?>,"true");
                            countLabelNum++;
                            ifSoloChoose = true;
                        } else {
                            ifSoloChoose = false;
                        }
                    }
                    $.ajax({
                        // ifSoloChoose 是否单行选择的标记
                        url: 'action/addLabel_ToContent.php?ifSoloChoose=',
                        type: 'POST',
                        data: sendTexttemp,
                        success: (result) => {
                            console.log(result);
                        }
                    })
                    if (!ifSoloChoose)
                        setTimeout(() => {
                            location.replace(location.href)
                        }, 100);
                    objDialog.remove();
                } else {
                    alert("请选择实体标签！！！");
                }
            }
        )
        btnCancel.bind(
            'click', function () {
                // objDialog.close();
                objDialog.remove();
            }
        )
    }

    //触发 选中文本后跳出的Dialog 的事件
    $('#textArray').click(function () {
        needThings[0] = "";
        needThings[1] = 0;
        needThings[2] = "";
        var range = window.getSelection().getRangeAt(0);
        var rect_Select = range.getBoundingClientRect();
        const x_selected = rect_Select.left + document.getElementById("svgMaincontainer").scrollLeft - document.getElementById("svgMaincontainer").offsetLeft - 7;
        const y_selected = rect_Select.top + document.getElementById("svgMaincontainer").scrollTop - document.getElementById("svgMaincontainer").offsetTop - 6;
        console.log("test x:" + x_selected, " y:" + y_selected);
        // 获取鼠标选中文字,和始终位置
        let selecter = window.getSelection();
        let selectStr = selecter.toString();

        let position = {};
        position.left = selecter.anchorOffset;
        position.right = selecter.focusOffset;
        if (window.getSelection().focusNode.parentElement === window.getSelection().anchorNode.parentElement) {
            if (position.left > position.right) {
                // console.log("进行了反向选择");
                let temp_1 = position.left;
                position.left = position.right;
                position.right = temp_1;
            }
        }
        //_____________________________________________书写将选中的位置的值 转化为全文中的位置的值_____________________________________________
        let startIndex_All = position.left;
        let endIndex_All;
        // console.log(window.getSelection().focusNode.parentElement.id);
        for (let i of document.getElementById("textArray").childNodes) {
            if (i.nodeName === "tspan") {
                if (i.id === window.getSelection().anchorNode.parentElement.id) {
                    break;
                }
                startIndex_All = startIndex_All + i.textContent.length;
            }
        }
        endIndex_All = startIndex_All + selectStr.length;
        // console.log(startIndex_All+"<<<<<<<>>>>>>"+endIndex_All);
        // endIndex_All = startIndex_All + position.right - position.left;
        if (!selectStr || !selectStr.trim()) return;
        //获取选取位置  选取的开始和结束的值

        if (window.getSelection().focusNode.parentElement === window.getSelection().anchorNode.parentElement) {
            showDialog(position.left, position.right, x_selected, y_selected, startIndex_All, endIndex_All);
            document.getElementById("dialog_select_label").showModal();
        } else {
            showDialog(-1, -1, x_selected, y_selected, startIndex_All, endIndex_All);
            document.getElementById("dialog_select_label").showModal();
            console.log("进行了跨行选择");
        }
    });

    function pageJump(page) {
        //传入Page名
        //作用页面跳转
        if (page === "") {
            alert("页面开发中，敬请期待!");
        } else if (page === "file_list") {
            window.location.href = page + ".php?scrollOldTop_list=" +<?php echo $scrollOldTop_list ?> +"&tag=" + nowTag;
        } else {
            window.location.href = page + ".php";
        }
    }

    ///////////////////////////////////////////////cookie操作记录滚动条的值//////////////////////////////////////////
    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
    }

    var scrollTop = 0;
    document.getElementById('svgMaincontainer').onscroll = function () {
        scrollTop = document.getElementById('svgMaincontainer').scrollTop || document.getElementById('svgMaincontainer').scrollTop;
        document.cookie = "scrollTop=" + scrollTop;
    }
    //滚动 清空
    var scrollOldTop = getCookie("scrollTop");
    document.getElementById('svgMaincontainer').scrollTop = scrollOldTop;
</script>
</html>