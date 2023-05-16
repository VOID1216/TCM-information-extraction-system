//by 二超 作用是描绘标签图像 需要参数 文本起始位置，文本终结位置，标签名称，标签Id 标签颜色 标签的相对文章位置X 标签的相对文章位置Y
function addScript(url){
    document.write("<script language=javascript src="+url+"></script>");
}
addScript('../JS/Jquery.js');
function DrawPath(startIndex, endIndex, strLabel, labelId, color, x, y, id,over) {
    /////////////////////////////////////////////////////////////
    // console.log("when draw x:" + x + " y:" + y+" is over:"+over);
    /////////////////////////////////////////////////////////////

    let g = document.createElementNS("http://www.w3.org/2000/svg", "g");
    g.setAttribute("id", labelId);
    g.setAttribute("style", "transform: translate(" + x + "px," + y + "px)");
    document.getElementById("gLabel").appendChild(g);

    let rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
    rect.setAttribute("height", "20px");
    rect.setAttribute("width", endIndex - startIndex);
    rect.setAttribute("fill", color);
    rect.setAttribute("opacity", 0.5)
    g.appendChild(rect);

    let path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    let text = document.createElementNS("http://www.w3.org/2000/svg", "text");
    let rect_text=document.createElementNS("http://www.w3.org/2000/svg", "rect");

    if (over=="false"){
        // console.log(over);
        path.setAttribute("stroke", "#000000");
        path.setAttribute("fill", "none");
        path.setAttribute("d", " M " + endIndex + ",-24" + "Q " + endIndex + ",-28.8," + (endIndex - 10) + ",-27.2" + "T" + (startIndex + endIndex) / 2 + ",-32" + "M " + startIndex + ",-24" + "Q " + startIndex + ",-28.8," + (startIndex + 10) + ",-27.2" + "T" + (startIndex + endIndex) / 2 + ",-32");
//        path_1.d=" M "+endIndex+",0"+ "Q "+endIndex+",-4.8,"+(endIndex-5)+",-3.2"+ "T"+(startIndex+endIndex)/2+",-8"+ "M "+startIndex+",0"+"Q "+startIndex+",-4.8,"+(startIndex+5)+",-3.2"+ "T"+(startIndex+endIndex)/2+",-8"
        g.appendChild(path);
        text.setAttribute("y", -34);
        text.setAttribute("x", ((endIndex - startIndex) / 2 - (strLabel.toString().length / 2) * 16));
        // text.setAttribute("class","labelText");
        text.textContent = strLabel;
        g.appendChild(text);
        rect_text.setAttribute("id",labelId+"rect")
        rect_text.setAttribute("y", -48);
        rect_text.setAttribute("x", ((endIndex - startIndex) / 2 - (strLabel.toString().length / 2) * 16));
        rect_text.setAttribute("height", "17px");
        rect_text.setAttribute("width", (strLabel.toString().length) * 16);
        rect_text.setAttribute("fill", color);
        rect_text.setAttribute("stroke",color);
        rect_text.setAttribute("rx","3");
        rect_text.setAttribute("opacity", 0.5)
        g.appendChild(rect_text);

    }
    if (over=="true"){
        // console.log(over);
        path.setAttribute("stroke", "#000000");
        path.setAttribute("fill", "none");
        path.setAttribute("d", " M " + endIndex + ",0" + "Q " + endIndex + ",-4.8," + (endIndex - 10) + ",-3.2" + "T" + (startIndex + endIndex) / 2 + ",-8" + "M " + startIndex + ",0" + "Q " + startIndex + ",-4.8," + (startIndex + 10) + ",-3.2" + "T" + (startIndex + endIndex) / 2 + ",-8");
//        path_1.d=" M "+endIndex+",0"+ "Q "+endIndex+",-4.8,"+(endIndex-5)+",-3.2"+ "T"+(startIndex+endIndex)/2+",-8"+ "M "+startIndex+",0"+"Q "+startIndex+",-4.8,"+(startIndex+5)+",-3.2"+ "T"+(startIndex+endIndex)/2+",-8"
        g.appendChild(path);
        //<rect width="330px" height="30px" x="0px" y="0px" fill="red" opacity=".5" rx="5" ry="5" stroke-width="100"/>
        text.setAttribute("y", -10);
        text.setAttribute("x", ((endIndex - startIndex) / 2 - (strLabel.toString().length / 2) * 16));
        text.textContent = strLabel;
        g.appendChild(text);
        rect_text.setAttribute("id",labelId+"rect")
        rect_text.setAttribute("y", -24);
        rect_text.setAttribute("x", ((endIndex - startIndex) / 2 - (strLabel.toString().length / 2) * 16));
        rect_text.setAttribute("height", "17px");
        rect_text.setAttribute("width", (strLabel.toString().length) * 16);
        rect_text.setAttribute("fill", color);
        rect_text.setAttribute("stroke",color);
        rect_text.setAttribute("rx","3");
        rect_text.setAttribute("opacity", 0.5)
        g.appendChild(rect_text);
    }
    rect_text.addEventListener(
        'contextmenu',
        (e) => {
            delete_label(e);
        }
    )
    rect.addEventListener(
        'contextmenu',
        (e) => {
            delete_label(e);
        }
    )
    function delete_label(e){
        e.preventDefault();
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
    }

}