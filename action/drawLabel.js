//by 二超 作用是描绘标签图像 需要参数 文本起始位置，文本终结位置，标签名称，标签Id 标签颜色
function addScript(url){
    document.write("<script language=javascript src="+url+"></script>");
}
addScript('../JS/Jquery.js');
function DrawPath(startIndex, endIndex, strLabel, labelId, color, x, y, id) {
    ///////////////////////////////////////////////////////////////
    console.log("when draw x:" + x + " y:" + y);
    ///////////////////////////////////////////////////////////////

    let g = document.createElementNS("http://www.w3.org/2000/svg", "g");
    g.setAttribute("id", labelId);
    g.setAttribute("z-index", 10);
    g.setAttribute("style", "transform: translate(" + x + "px," + y + "px)");
    document.getElementById("svgArticle").appendChild(g);

    let path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path.setAttribute("stroke", "#000000");
    path.setAttribute("fill", "none");
    path.setAttribute("d", " M " + endIndex + ",0" + "Q " + endIndex + ",-4.8," + (endIndex - 10) + ",-3.2" + "T" + (startIndex + endIndex) / 2 + ",-8" + "M " + startIndex + ",0" + "Q " + startIndex + ",-4.8," + (startIndex + 10) + ",-3.2" + "T" + (startIndex + endIndex) / 2 + ",-8");
//        path_1.d=" M "+endIndex+",0"+ "Q "+endIndex+",-4.8,"+(endIndex-5)+",-3.2"+ "T"+(startIndex+endIndex)/2+",-8"+ "M "+startIndex+",0"+"Q "+startIndex+",-4.8,"+(startIndex+5)+",-3.2"+ "T"+(startIndex+endIndex)/2+",-8"
    document.getElementById(labelId).appendChild(path);

    //<rect width="330px" height="30px" x="0px" y="0px" fill="red" opacity=".5" rx="5" ry="5" stroke-width="100"/>
    let rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
    rect.setAttribute("height", "20px");
    rect.setAttribute("width", endIndex - startIndex);
    rect.setAttribute("fill", color);
    rect.setAttribute("opacity", 0.5)
    document.getElementById(labelId).appendChild(rect);

    let text = document.createElementNS("http://www.w3.org/2000/svg", "text");
    text.setAttribute("y", -10);
    text.setAttribute("x", ((endIndex - startIndex) / 2 - (strLabel.toString().length / 2) * 16));
    text.textContent = strLabel;
    document.getElementById(labelId).appendChild(text);

    text.addEventListener(
        'contextmenu',
        (e) => {
            //DOM生成并显示
            let objDialog = $('<dialog>', {
                id: 'deleteDialog'
            });
            objDialog.appendTo(document.body);
            let objForm = $('<form>', {
                method: 'dialog'
            })
            objForm.appendTo(objDialog);
            let objLabel = $('<label>要删除这个实体吗？<label>');
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
                    $.ajax({
                        url: "/action/deleteLabel.php?id=" + id,
                        type: 'POST',
                        data: labelId,
                        success: (result) => {
                            console.log(result);
                            location.replace(location.href)
                        }
                    })
                    // setTimeout(() => {
                    //     document.getElementById(labelId).remove();
                    // }, 100);
                    objDialog.remove();
                }
            )
            btnNo.bind(
                'click',
                function () {
                    console.log('no');
                    objDialog.remove();
                }
            )
            e.preventDefault();
        }
    )
}