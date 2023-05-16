<?php
require_once './db_config.php';
header("content-type:text/html; charset=UTF-8");
session_start();
$userName = $_SESSION['userName'];
$group = $_SESSION['group'];
if (isset($_SESSION['level'])) {
    $level = $_SESSION['level'];
} else {
    $level = 2;
}
$nowTag = "全部";
if (isset($_GET['tag'])){
    $nowTag = $_GET['tag'];
}
$scrollOldTop_list=0;
if (isset($_GET['scrollOldTop_list'])){
    $scrollOldTop_list=$_GET["scrollOldTop_list"];
//    echo $scrollOldTop_list;
}
$queryString = "select id,name,set_time,class,isTag from assignment where articleGroup='$group';";
$rs = mysqli_query($link, $queryString);
echo mysqli_error($link);
$i = 0;
$row = false;
$rows = [];
$name = [];
$id = [];
$time = [];
$class = [];
$isTag = [];
//$isDelete = [];
while (($row = mysqli_fetch_assoc($rs)) != false) {
    $rows[$i] = $row;
    $name[$i] = $row['name'];   
//    $name[$i] = iconv('latin1','utf-8',$name[$i]);
    $id[$i] = $row['id'];
    $time[$i] = $row['set_time'];
    $class[$i] = $row['class'];
    $isTag[$i] = $row['isTag'];
//    $isDelete[$i] = $row['isDelete'];
    $i++;
}
$arrayLength = count($rows);
$i = 0;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>信息抽取平台</title>
</head>
<link rel="stylesheet" type="text/css" href="CSS/file_list.css"/>
<script src="JS/Jquery.js"></script>
<body>
<div>
    <div id="header" class="header"><!-- 网页最上方TOP-->
        <div class="headerTitlepic"><!-- 网页最上方TOP左侧LOGO位置 -->
            <img src="image/webtitle.png" width="380px" height="50px"
                 style="margin: auto;position: relative;top: 0;left: 20px;bottom: 0;right: 0;"/><!--LOGO图片-->
        </div>
        <div id="headerUser" class="headerUser">
            <img src="image/icon/user.png" height="45px" width="45px"/>
            <div id="userName"
                 style="text-align: center;margin-top: 0px ; position: absolute; top:10px;left:50px;"></div>
        </div><!-- 网页最上方TOP右侧用户位置 -->
    </div>
    <div id="leftMenu" class="leftMenu"><!-- 网页左侧Left跳转功能栏 -->
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
    <div>
        <div class="operateContainer"><!-- 主要操作区上方的长条操作板块样式 -->
            <div id="operateContainerBlock">
                <div style="float: right;height: 45px;margin-top: 10px">
                    <form id="formUpload" name="formUpload" action="/action/upload.php" target="iframeUpload"
                          method="post" enctype="multipart/form-data">
                        <input type="file" id="myFile" name="myFile"  style="font-size: 16px">
                        <button type="submit" id="btnUpload" name="btnUpload" style="margin-right: 30px; font-size: 16px">添加文件
                        </button>
                    </form>
                </div>
                <div style="display: inline-block;position: relative; float: right;margin-top: 10px;height: 45px ">
                    <div style="position: relative;float: right;margin-left: 10px">
                        <input id="fileRearch" type="button" style="margin-left: 10px;margin-right: 30px;font-size: 16px"
                               value="查询"/>
                    </div>
                    <div style="font-size: 16px;position: absolute;float:left;background: #efefef;background-color:#ffffff8a;border: 3px double rgb(201, 191, 181)" >分类</div>
                    <select id="selectDisease" name="selectDisease" style="height: 25px;margin-left: 40px;margin-top: 1px">
                        <option value="全部">全部</option>
                        <option value="便秘">便秘</option>
                        <option value="胆结石">胆结石</option>
                        <option value="肺病">肺病</option>
                        <option value="肝脏疾病">肝脏疾病</option>
                        <option value="冠心病">冠心病</option>
                        <option value="咳嗽">咳嗽</option>
                        <option value="溃疡">溃疡</option>
                        <option value="类风湿关节炎">类风湿关节炎</option>
                        <option value="梅核气">梅核气</option>
                        <option value="乳房疾病">乳房疾病</option>
                        <option value="失眠">失眠</option>
                        <option value="糖尿病">糖尿病</option>
                        <option value="头痛">头痛</option>
                        <option value="胃痛">胃痛</option>
                        <option value="哮喘">哮喘</option>
                        <option value="肋痛">肋痛</option>
                        <option value="心悸">心悸</option>
                        <option value="心衰">心衰</option>
                        <option value="荨麻疹">荨麻疹</option>
                        <option value="月经症">月经症</option>
                        <option value="中风">中风</option>
                        <option value="腹痛">腹痛</option>
                        <option value="高血压">高血压</option>
                        <option value="内科病">内科病</option>
                        <option value="皮肤病">皮肤病</option>
                        <option value="痛风">痛风</option>
                        <option value="胸痹心痛">胸痹心痛</option>
                        <option value="眩晕症">眩晕症</option>
                        <option value="腰间盘突出">腰间盘突出</option>
                        <option value="抑郁症">抑郁症</option>
                        <option value="支气管炎">支气管炎</option>
                    </select>
                </div>
            </div>
        </div>
        <div style="overflow-y: scroll" class="mainContainer" id="fileListitemGroup_list"><!-- 页面调转菜单栏右侧的主要操作区样式 -->
            <div id="fileListitemGroup">
                <!--根据数据库内数据DOM动态加载-->
            </div>
        </div>
    </div>
</div>
<!--<iframe src="action/upload.php" id="iframeUpload" name="iframeUpload" style="display: none"></iframe>-->
<input type="hidden" id="hiddenInput" name="hiddenInput" value="success">
</body>
<script type="text/javascript">
    let nowTag = "<?php echo $nowTag;?>";
    let recordClass = $('#selectDisease');
    recordClass.val(nowTag);
    console.log('<?php echo $_SESSION['userName']?>');
    $('#userName').html('<?php echo $userName?>');
    var level;
    level = 2;
    level = <?php echo $level;?>;
    if (level === 2) {
        $('#uerAdmin').css({
            display: 'none'
        })
    }
    const jsonStrName = '<?php echo json_encode($name, JSON_UNESCAPED_UNICODE);?>';
    jsonName = JSON.parse(jsonStrName);//数组--存储文章姓名

    const jsonStrTime = '<?php echo json_encode($time, JSON_UNESCAPED_UNICODE);?>';
    jsonTime = JSON.parse(jsonStrTime);//数组--存储上传时间
    const jsonStrId = '<?php echo json_encode($id, JSON_UNESCAPED_UNICODE);?>';
    jsonId = JSON.parse(jsonStrId);//数组--存储文章ID
    const jsonStrClass = '<?php echo json_encode($class, JSON_UNESCAPED_UNICODE);?>';
    jsonClass = JSON.parse(jsonStrClass);//数组--存储医案
    // console.log(jsonStrClass);
    const jsonStrIsTag = '<?php echo json_encode($isTag, JSON_UNESCAPED_UNICODE);?>';
    jsonIsTag = JSON.parse(jsonStrIsTag);//数组--存储是否标记
    const fileListitemGroup = $("#fileListitemGroup");

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
    var scrollTop_list = 0;
    document.getElementById('fileListitemGroup_list').onscroll = function () {
        scrollTop_list = document.getElementById('fileListitemGroup_list').scrollTop || document.getElementById('fileListitemGroup_list').scrollTop;
        document.cookie="scrollTop_list=" + scrollTop_list;
        // console.log(document.cookie);
    }
    //滚动 清空
    var scrollOldTop_list=getCookie("scrollTop_list");
    document.getElementById('fileListitemGroup_list').scrollTop=scrollOldTop_list;
    ///////////////////////////////////////////////cookie操作记录滚动条的值//////////////////////////////////////////
    //从数据库取文件列表，DOM生成在页面

    for (let i = 0; i < <?php echo $arrayLength;?>; ++i) {
        if (recordClass.val() === '全部' || jsonClass[i] === recordClass.val()) {
            let objDiv1 = $("<div>", {
                id: 'div_' + i,
                class: "fileListitem"
            });
            objDiv1.appendTo(fileListitemGroup);
            let objDiv2 = $("<div>", {
                css: {
                    position: "relative",
                    float: "left",
                    width: "50px",
                    height: "40px",
                }
            });
            objDiv2.appendTo(objDiv1);
            let objImg = $("<img>", {
                alt: "",
                src: "image/icon/txt_icon.png",
                height:"40px",
                width:"43px",
                css: {
                    position: "absolute",
                    marginLeft: "3px",
                    marginTop:"2px"
                }
            });
            objImg.appendTo(objDiv2);
            let objSpan = $("<span>", {
                css: {
                    position: "relative",
                    float: "left",
                    fontsize: "12px",
                    marginTop: "10px"
                }
            });
            objSpan.html(jsonName[i]);
            objSpan.appendTo(objDiv1);

            let objDiv3 = $("<div>");
            objDiv3.css({
                position: 'relative',
                float: 'right',
                marginTop: '10px',
                marginRight: '10px',
                marginLeft: '10px'
            })
            objDiv3.appendTo(objDiv1);

            let objRadio = $('<div>');
            objRadio.appendTo(objDiv3);
            objRadio.css({
                position: 'relative',
                float: 'left',
                marginRight: '5px'
            })
            if (jsonIsTag[i] === '1') {
                console.log('1');
                objRadio.html('已标注');
                objRadio.css({
                    backgroundColor: '#39C5BB'
                })
            } else {
                // console.log('0');
                objRadio.html('未标注');
                objRadio.css({
                    backgroundColor: '#999999'
                })
            }

            let objSpanTime = $("<span>");
            objSpanTime.appendTo(objDiv3);
            objSpanTime.html('创建时间:' + jsonTime[i] + '   ');
            let objInputEdit = $("<input style='font-size: 16px' type='button' value='编辑'>")
            objInputEdit.appendTo(objDiv3);
            objInputEdit.click(function () {
                location.href = "file_annotation_test.php?id=" + jsonId[i] + "&isTag=" + jsonIsTag[i] + "&scrollOldTop_list=" + scrollTop_list + "&tag=" + recordClass.val();
            })
            let objInputDel = $("<input style='font-size: 16px' type='button' value='删除'>")
            objInputDel.css({
                fontsize: "16"
            })
            objInputDel.bind(
                'click',
                () => {
                    //生成dialog，对操作进行确认
                    let objDialog = $('<dialog>');
                    let objSpan = $('<span>是否确认删除文章？</span>');
                    let btnYes = $('<button>确认</button>');
                    let btnNo = $('<button>取消</button>');
                    objDialog.appendTo($('body'));
                    objSpan.appendTo(objDialog);
                    btnYes.appendTo(objDialog);
                    btnNo.appendTo(objDialog);
                    btnYes.bind('click', () => {
                        $.ajax({
                            url: '/action/deleteArticle.php?id=' + jsonId[i],
                            success: (res) => {
                                if (res === 'success') {
                                    location.replace(location.href);
                                }
                            }
                        });
                        objDialog.remove();
                    });
                    btnNo.bind('click', () => {
                        objDialog.remove();
                    });
                    objDialog.show();
                }
            )
            objInputDel.appendTo(objDiv3);
        }
    }

    $('#fileRearch').bind(
        'click',
        () => {
            for (let i = 0; i < <?php echo $arrayLength;?>; ++i) {
                let divId = '#div_' + i;
                if (recordClass.val() === '全部') {
                    $(divId).show();
                } else if (jsonClass[i] !== recordClass.val()) {
                    $(divId).hide();
                }else {
                    $(divId).show();
                }
            }
        }
    )

    function loadPage() {
        location.reload();
    }

    //页面跳转
    function pageJump(page) {
        //传入Page名
        //作用页面跳转
        if (page === "") {
            alert("页面开发中，敬请期待!");
        } else {
            window.location.href = page + ".php";
        }
    }

    $("#btnUpload").bind(
        'click',
        function () {
            // var formData1 = new FormData($("#formUpload")[0]);
            // $.ajax({
            //     type: "post",
            //     url: "/action/upload.php",
            //     dataType: "json",
            //     data: formData1,
            //     //是否缓存
            //     cache: false,
            //     //当设置为false的时候,jquery 的ajax 提交的时候会序列化 data
            //     processData: false,
            //     /*contentType都是默认的值：application/x-www-form-urlencoded；
            //     *表单中设置的contentType为"multipart/form-data"；
            //      * ajax 中 contentType 设置为 false ，是为了避免 JQuery对要提交
            //      * 的表单中的enctype值修改*/
            //     contentType: false
            // });
            // setTimeout(() => {
            //     location.reload()
            // }, 50);
            // setTimeout(() => {
            //     location.reload();
            // }, 50);
        }
    )
    document.getElementById('fileListitemGroup_list').scrollTop=<?php echo $scrollOldTop_list ?>;
</script>
</html>