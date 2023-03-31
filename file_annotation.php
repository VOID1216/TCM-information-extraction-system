<?php
header("content-type:text/html; charset=UTF-8");
$textId = $_GET['id'];
$link = mysqli_connect("localhost", "root", "", "smart_annotation");
$queryString = "select name,text from assignment where id='$textId'";
$rs = mysqli_query($link, $queryString);
$row = mysqli_fetch_assoc($rs);
$jsonText = json_decode($row['text'], true);
$article = $jsonText['data']['annotation']['content'];
if (array_key_exists('labelCategories', $jsonText['data']['annotation'])) {
    $numLabelCategories = count($jsonText['data']['annotation']['labelCategories']);
} else {
    $numLabelCategories = 0;
}
$numLabelCategories === 0 ? $labelId = 0 : $labelId = end($jsonText['data']['annotation']['labelCategories'])['id'];
$length = 70;//以汉字长度为标准（多少个汉字长度）
$articleArray = contentSplit($article, $length);
function contentSplit($wenzhang, $length){
    //函数作用是将内容排版，返回一个切割了文章内容的字符串数组
    //17个数字或小写字母相当于10个汉字 15个大写字母相当于10个汉字 1数字=10/17.5汉字 1大字=10/15汉字 1汉字=1汉字
    //length是一排的汉字标准长度
    $lastlocation = 0;
    $splitnum = 0;
    $templength = 0;
    $wenzhangarray = array();
    $codestr = "l~!@?<>#$%^&1234567890abcdefghijklmnopqrstuvwxyz";//第一个L不要删
    $codestr1 = "*()[]{}/\.·,'; ";//最后有个空格
    $codestr2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i = 0; $lastlocation < mb_strlen($wenzhang, "utf-8"); $i++, $templength = 0) {
        //echo (strpos($codestr,mb_substr($wenzhang,$i,1,"utf-8")))?"Yes":"No";
        for ($j = $lastlocation; ($templength <= $length); $j++) {
            if ($j < mb_strlen($wenzhang, "utf-8") && strpos($codestr, mb_substr($wenzhang, $j, 1, "utf-8"))) {
                $templength = $templength + (10 / 18);//数字及小写字母,可能需要调整10/18 6/18 10.5/15
            } else if ($j < mb_strlen($wenzhang, "utf-8") && strpos($codestr1, mb_substr($wenzhang, $j, 1, "utf-8"))) {
                $templength = $templength + (6 / 18);//括号等小型字符
            } else if ($j < mb_strlen($wenzhang, "utf-8") && strpos($codestr2, mb_substr($wenzhang, $j, 1, "utf-8"))) {
                $templength = $templength + (10.5 / 15);//大写字符
            } else {
                $templength = $templength + 1;
                //echo $templength;
            }
            $splitnum = $j - $lastlocation;
        }
        $wenzhangarray[$i] = mb_substr($wenzhang, $lastlocation, $splitnum, "utf-8");
        $lastlocation = $lastlocation + $splitnum;
    }
    return $wenzhangarray;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>信息抽取平台</title>
    <link rel="stylesheet" type="text/css" href="CSS/file_annotation.css"/>
    <link rel="stylesheet" type="text/css" href="CSS/farbtastic.css"/>
    <script src="JS/Jquery.js"></script>
    <script src="JS/farbtastic.js"></script>
</head>
<body>
<img id="cp" src="">
<div>
    <div id="header" class="header"><!-- 网页最上方TOP-->
        <div class="headerTitlepic"><!-- 网页最上方TOP左侧LOGO位置 -->
            <img src="image/webtitle.png" width="380px" height="50px"
                 style="margin: auto;position: relative;top: 0;left: 20px;bottom: 0;right: 0;"/><!--LOGO图片-->
        </div>
        <div id="headerUser" class="headerUser">
            <img src="image/icon/user.png" height="45px" width="45px"/>
            李应龙
        </div><!-- 网页最上方TOP右侧用户位置 -->
    </div>
    <div id="leftMenu" class="leftMenu"><!-- 网页左侧Left跳转功能栏 -->
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
            <span style="float:left;"><?php echo $row['name'] ?></span>
        </div class="fileInfocontainer">
        <div class="labelInfocontainer">
            <div id="labelBox" class="label_box">
                <label>实体标签:</label><br>
                <button type="button" id="add_substance" name="add_substance" class="addLabel_button" onclick="addSubstance()">添加实体标签</button>
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
        <div id="svgMaincontainer" onmouseup="getSelectText()" class="svgMaincontainer"><!-- 作用是加上个滚动条 -->
            <svg id="svgArticle"
                 style=" background-color:lavender;width: 1642px;height: <?php echo count($articleArray) * 50;
                 echo 'px' ?>;" xmlns="http://www.w3.org/2000/svg"><!-- svg框，需要改变 height 属性增加滚动条的量,width固定长度 -->
                <!--                           <g><rect width="51" height="17" x="72" y="153" fill="red" rx="5" ry="5" /></g>-->
                <text style="white-space: pre; overflow-wrap: normal;" x="0" y="15" fill="black">
                    <!-- svg框，需要改变 height 属性增加滚动条的量 -->
                    <?php
                    for ($i = 0; $i < count($articleArray); $i++) {
                        echo "<tspan id='$i' x='10' dy='51'>$articleArray[$i]</tspan>";
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
    //实体标签DOM
    var numLabelCategories =<?php echo $numLabelCategories;?>;
    var labelId =<?php echo $labelId;?>;
    const jsonText = '<?php echo $row['text'];?>';
    console.log(jsonText);
    json = JSON.parse(jsonText);
    if (numLabelCategories !== 0) {
        let objLabelBox = $('#labelBox');
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
                function (e){
                    let objDialog = $('<dialog>',{
                        id: 'deleteDialog'
                    });
                    objDialog.appendTo(document.body);
                    let objForm = $('<form>',{
                        method: 'dialog'
                    })
                    objForm.appendTo(objDialog);
                    let objLabel = $('<label>要删除这个标签吗？<label>');
                    objLabel.appendTo(objForm);
                    let btnYes = $('<button>是</button>',{
                        type: 'submit'
                    })
                    btnYes.appendTo(objForm);
                    let btnNo = $('<button>否</button>',{
                        type: 'submit'
                    })
                    btnNo.appendTo(objForm);
                    objDialog.show();
                    btnYes.bind(
                        'click',
                        function (){
                            let id=labelSpan.attr('id');
                            $.ajax({
                                url: "/action/deleteLabel.php?id="+id,
                                type: 'POST',
                                data: jsonText,
                                success: successCallback,
                                error: errorCallback,
                            })

                            function successCallback(result) {
                                console.log(result);
                            }

                            function errorCallback(xhr, status) {
                                console.log('出问题了！');
                            }

                            $('#'+id).css({
                                display: 'none'
                            })

                            objDialog.remove();
                        }
                    )
                    btnNo.bind(
                        'click',
                        function (){
                            console.log('no');
                            objDialog.remove();
                        }
                    )
                    e.preventDefault();
                }
            )
        }
    }

    //添加实体标签
    function addSubstance() {
        let objDialog = $('<dialog>', {
            destroy_on_close: 'true'
        });
        objDialog.appendTo(document.body)
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
        objDialog.show();

        btnDetermine.click(function () {
            let text = objTextInput.val();
            let color = objColorInput.val();
            if (numLabelCategories === 0) {
                json.data.annotation.labelCategories = [{
                    id: labelId,
                    text: text,
                    color: color,
                    borderColor: '#999999'
                }];
            } else {
                json.data.annotation.labelCategories[labelId] = {
                    id: labelId+1,
                    text: text,
                    color: color,
                    borderColor: '#999999'
                };
            }
            jsonText2 = JSON.stringify(json);
            labelId++;
            console.log(labelId);
            $.ajax({
                url: '/action/addLabel.php',
                type: 'POST',
                data: jsonText2,
                success: successCallback,
                error: errorCallback,
            })

            function successCallback(result) {
                console.log(result);
            }

            function errorCallback(xhr, status) {
                console.log('出问题了！');
            }

            let objLabelBox = $('#labelBox');
            let labelSpan = $('<span>', {
                class: 'label_nav',
                id: 'labelSpan_' + (numLabelCategories + 1)
            });
            labelSpan.html(text);
            labelSpan.css({
                backgroundColor: color
            })
            labelSpan.appendTo(objLabelBox);
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

    var scrollHeight = document.getElementById('svgMaincontainer').scrollHeight;
    console.log(document.getElementById('svgMaincontainer').style.height);
    document.getElementById('svgMaincontainer').scroll(0, Math.round(520))

    //文本选择+打标签（分开写！！！！！！！！）
    function getSelectText() {
        //console.log(window.getSelection());
        //console.log(window.getSelection().focusNode.parentElement);//获取值 两者不相同
        //console.log(window.getSelection().anchorNode.parentElement);
        //判断是否选中
        if (window.getSelection().focusNode.parentElement === window.getSelection().anchorNode.parentElement) {
            startIndex = (window.getSelection().anchorOffset < window.getSelection().focusOffset) ? window.getSelection().anchorOffset : window.getSelection().focusOffset;
            EndIndex = (window.getSelection().anchorOffset > window.getSelection().focusOffset) ? window.getSelection().anchorOffset : window.getSelection().focusOffset;
            console.log("选取的文字：" + window.getSelection().toString() + "————起始位置" + startIndex + "终止位置" + EndIndex + "第" + window.getSelection().focusNode.parentElement.id + "行");
            var sendText = window.getSelection().focusNode.parentElement.id + "," + startIndex + "," + EndIndex;
            console.log(sendText);

            // let $('<dialog>',{
            //
            // })

            // var g=document.createElement('g');
            // var biaozhu=document.createElement('rect');
            // biaozhu.setAttribute("x","10");
            // biaozhu.setAttribute("y","102");
            // biaozhu.setAttribute("width","20");
            // biaozhu.setAttribute("height","17");
            // biaozhu.setAttribute("fill","red");
            // biaozhu.setAttribute("rx","5");
            // biaozhu.setAttribute("ry","5");
            // g.appendChild(biaozhu);
            //document.getElementById("svgArticle").appendChild(g);
            document.getElementById("selectedText").value = sendText;
            // document.getElementById("selectedTextForm").submit();
        } else {
            console.log("不能跨行选择");
        }
    }
</script>
</html>