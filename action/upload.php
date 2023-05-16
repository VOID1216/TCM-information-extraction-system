<?php
require_once '../db_config.php';
header("content-type:text/html; charset=UTF-8");
//if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
if (isset($_POST)){
    if ($_FILES["myFile"]["type"] == 'text/plain') {
        $fileName = $_FILES["myFile"]["name"];
//        $fileName = "抑郁症医案2.txt";
        $fileName=iconv("UTF-8",'GBK',$fileName);
//        $fileName=iconv('UTF-8','GBK',$fileName);
        move_uploaded_file($_FILES["myFile"]["tmp_name"],"../file/".$fileName);
//        $fileName='肝郁气滞.txt';
        $content=file_get_contents("../file/".$fileName);//读取txt文件
//        $content="赵××，女，51岁。初诊:1988年9月21日。主诉:半年来自汗，恶风、恶寒、心烦，气急、失眠、多梦、精神抑郁，半载从未喜笑，心慌，疲乏，胃腕不舒，纳食不香，口干舌燥，大便偏干，五心烦热。诊查:舌苔薄白，脉弦。辨证:此为气机失常，阴阳失调所致。治法:行气解郁，养心安神，和中缓急。处方:越鞠丸合甘麦大枣汤加减。苍术10g，川芎10g，香附10g，栀子10g，神曲10g，甘草5g，大枣5枚，浮小麦15g,龙骨15g，豆豉10g，地骨皮10g，珍珠母15g，夜交藤15g。服药一周后，病情有所缓解，舌脉如前，原方再选6剂，连服3周后，病人自诉半年未喜笑，现已与家人谈笑，且汗已止，饮食大增，睡眠也较以前平稳，再进6剂，以资巩固。按语:此类病人，西医诊断为“抑郁型精神病”，在祖国医学范畴内，属于“脏躁”，“郁证”，临床上并不少见，大多以养阴清热之法治之，往往效果不佳。高老认为此症阴虚内热者有之，但气郁者更多见，由心肝失调引起，因此用越鞠丸合甘麦大枣汤主之正契合病机。正如《名医删补方论》所说:“夫人以气为体，气和则上下不失其度，运行不停于其机，病从何生，若饮食不节，寒温不适，喜怒无常，忧思无度，使冲和之气升降失常，以致胃郁不思饮食，脾郁不消水谷，气血郁滞则气机失常，而致阴阳失和，卧而不寐，火郁则为热，用越鞠丸合甘麦大枣汤既解六郁，又可甘缓滋阴，柔肝缓急，宁心安神，使营卫调，气血通畅，阴阳平衡，则病自愈。出处：高辉远医话医案集";
        $fileName=iconv("GBK",'UTF-8',$fileName);
        $content = str_replace("\n", '￥', $content);
        $content = str_replace("\r", '￥', $content);
        $content = str_replace("\t", '', $content);
        $content = str_replace('"', '”', $content);
        $content = str_replace(' ', '', $content);
        $content = str_replace("'", "’", $content);
        echo $content;
        $queryString="select max(id) as maxId FROM assignment";
        $rs=mysqli_query($link,$queryString);
        $row=mysqli_fetch_assoc($rs);
        if ($row['maxId']==NULL){
            $countId=1;
        }else{
            $countId=$row['maxId']+1;
        }
        $json=array('data'=>array('id'=>$countId,'annotation'=>array('content'=>$content,'labelCategories'=>array(
            array('id'=>1,'text'=>'症状','color'=>'#20b4fe','borderColor'=>'#999999'),
            array('id'=>2,'text'=>'舌像','color'=>'#ff6666','borderColor'=>'#999999'),
            array('id'=>3,'text'=>'脉象','color'=>'#e1c747','borderColor'=>'#999999'),
            array('id'=>4,'text'=>'病位证素','color'=>'#66ffe6','borderColor'=>'#999999'),
            array('id'=>5,'text'=>'病性证素','color'=>'#c966ff','borderColor'=>'#999999')
        ))));
//        var_dump($json);
        $s=json_encode($json,JSON_UNESCAPED_UNICODE);

        $date=getdate()['year'].'-'.getdate()['mon'].'-'.getdate()['mday'];
        $queryString="insert into assignment(id,name,set_time,text,isTag)VALUES('$countId','$fileName','$date','$s',0)";
        mysqli_query($link,$queryString);
        echo mysqli_error($link);
        echo 'success';
    }
}