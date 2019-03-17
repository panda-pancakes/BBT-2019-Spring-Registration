$(function () {
    //先定义
    // $("#attention").hide();
    $("#233").hide();
    $("#cover_user").hide();
    $("#bgimg1").hide();
    $("#successbox").hide();
    //js混用
    $("#name").bind('input propertychange', function() { 
        $("#name").val().replace("/[\'\"\\\/\b\f\n\r\t]/g","");
        $("#name").val().replace("(/[\@\#\$\%\^\&\*\{\}\:\"\L\<\>\?","");
        $("#name").attr("value",$("#name").val());
        cc();
       });
    $("#dorm").bind('input propertychange', function(){
        $("#dorm").val().replace("/[\'\"\\\/\b\f\n\r\t]/g","");
        $("#dorm").val().replace("(/[\@\#\$\%\^\&\*\{\}\:\"\L\<\>\?","");
        $("#dorm").attr("value",$("#dorm").val());
        cc();
    })
    $("#tel").bind('input propertychange', function(){
        $("#tel").val().replace("/[\'\"\\\/\b\f\n\r\t]/g","");
        $("#tel").val().replace("(/[\@\#\$\%\^\&\*\{\}\:\"\L\<\>\?","");
        $("#tel").attr("value",$("#tel").val());
        cc();
    })
    $("#introduction").bind('input propertychange', function(){
        $("#introduction").val().replace("/[\'\"\\\/\b\f\n\r\t]/g","");
        $("#introduction").val().replace("(/[\@\#\$\%\^\&\*\{\}\:\"\L\<\>\?","");
        $("#introduction").attr("value",$("#introduction").val());
        cc();
    })

    console.log("------14----js错误检查程序loading--------");
    console.log("------15----查询进度 页面 输入手机号和姓名 --------");
    //查询进度 页面 输入手机号和姓名 
    $("#check_user").click(function () {
        $("#bbt").hide();
        // $("#check_box").show();
        $("#check_box").css({
            "margin-top": "1%",
            "display": "table",
            "vertical-align": " middle",
            "text-align": "center",
            "padding-left": "10%",
            "padding-top": "25%",
            "max-width": "200%",
        });
        $("#prev").css({
            "vertical-align": "middle"
        });
        $("#check_btn").css({
            "vertical-align": "middle",
            "background": "none",
        })
        $(".text").css({
            "appearance": "none",
            "-moz-appearance": "none",
            '-webkit-appearance': "none",
            " width": "110%",
            "margin-bottom": " 1%",
            "padding": "2.3%",
            "background-color": " #dee6a8",
            "border-radius": "2em",
            "border:1px solid": " #c8cccf",
            "font-size": " 0.8em",

        })
        $("#bgimg1").show();
    }) //显示查询页面
    console.log("到达checkbtn函数上空");

    //真的查询
    $("#check_btn").click(function () {
        console.log("你点了这个按钮");
        var name = $('#name').val();
        var tel = $('#tel').val();
        var info = JSON.stringify({
            name,
            tel,
        });
        console.log(info);
        $.post("./api/action.php?method=query", info, function (data, status) {
            if (status == "success") {
                if (data.status == "failed") {
                    $("#233").show(); //直接报名按钮
                    var missing = new RegExp('Missing');
                    var telephone = new RegExp('telephone');
                    if (missing.test(data.errmsg)) {
                        attention();
                        $(".text").focus();
                        $("#attention").text("你漏填了什么，请检查一下再提交哦");
                    } else if (telephone.test(data.errmsg)) {
                        attention();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写格式不正确哦");
                    } else if (data.errcode == '233') {
                        $("#233").show();
                        attention();
                        $("#attention").text("不好意思，没有您的报名信息哦");
                    } else {
                        attention();
                        $("#attention").text("查询成功");
                        console.log(data.info);
                    }
                } else {
                    attention();
                    $("#attention").text("系统繁忙，请稍后再试");
                }
            }
        })
    })

    //覆盖
    console.log("------96----路过覆盖函数上空 --------");
    $("#cover_user").click(function () {
        console.log("覆盖");
        var name = $('#name').val();
        var tel = $("#tel").val();
        var info = JSON.stringify({
            name,
            tel,
        });
        $.post("/api/action.php?method=admin_query`", info, function (data, status) {
            if (status == "success") {
                if (data.status == "failed") {
                    $("#233").show(); //直接报名按钮
                    $("#cover_user").show(); //修改按钮
                    var missing = new RegExp('Missing');
                    var telephone = new RegExp('telephone');
                    if (missing.test(data.errmsg)) {
                        attention();
                        $(".text").focus();
                        $("#attention").text("你漏填了什么，请检查一下再提交哦");
                    } else if (telephone.test(data.errmsg)) {
                        attention();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写格式不正确哦");
                    } else if (data.errcode == '233') {
                        $("#233").show();
                        attention();
                        $("#attention").text("不好意思，没有您的报名信息哦");
                    } else {
                        attention();
                        $("#attention").text("查询成功");
                        cover();
                        $("#successbox:first-child").show();
                        // console.log(data.info);
                    }
                } else {
                    attention();
                    $("#attention").text("系统繁忙，请稍后再试");
                }
            }
        })
    })
    console.log("------138----路过覆盖css函数上空 --------");

    function cover() {
        $("#cover_user").show();
        $("#successbox:first-child").hide();
        $("#successbox").css({
            "visibility": "visible",
            "display": "table-cell",
            "z-index": "10",
            "max-width": "100% ",
            "color": " #707070",
            "font-size": "1em",
            "text-align": "center"
        });
    }
    console.log("----152------前端检查字符函数上空 --------");
    //前端检查字符
    function isBlank(str) {
        return (!str || /^\s*$/.test(str));
    }
    function check_uni(str){
        var patt_illegal = new RegExp("[^a-zA-Z\_\u4e00-\u9fa5]");    
        return (!str || !patt_illegal.test(str));
    }
    function prevent(){
        var name=$("#name").val();
        var tel=$("#tel").val();
        var dorm=$("#dorm").val();
        var rest =true;
        if(isBlank(name)){
            $("#name").focus();
            rest=false;
            if(!check_uni(name)){
                $("#name").focus();
                rest=false;
            }
        }else if(isBlank(dorm)){
            rest=false;
            if(!check_uni(dorm)){
                rest=false;
            }
        }else if(isBlank(tel)){
            rest=false;
        }
        if(rest){
            return 0;
        }else{
            return 1;
        }
    }
    console.log("-------172---oninput上空 --------");

    function cc(){
        var a=prevent();
        // console.log("------a="+a+"------------");
        if(a==1){
            $("attention").text("请再检查一下自己填的内容！");
            $("#attention").show();
            attention();    
        }else{
            
        }
    }

    console.log("-------182---oninput上空 --------");

    function attention() {
        console.log($("#attention").val());
        $("#attention").show();
        $("#cover_user").show();
        $("#attention").css({
            "display": "table-cell",
        });
    }
    console.log("------194----check上空 --------");
    //注册
    function check() {
        var name = $('#name').val();
        var sex = $('.sex').val();
        var college = $('#college option:selected').val();
        var grade = $(".grade").val();
        var dorm = $("#dorm").val();
        var tel = $('#tel').val();
        var department = $('#department option:selected').val();
        var alternative = $('#alternative option:selected').val();
        var adjustment = $('.adjustment').val();
        var introduction = $('#introduction').val();
        //打包给php 
        console.log("正在执行check：");
        var info = JSON.stringify({
            name,
            sex,
            tel,
            college,
            grade,
            dorm,
            department,
            alternative,
            adjustment,
            introduction,
        });
        $.post("./api/action.php?method=signup", info, function (data, status) {
            if (status == "success") {
                if (data.status == "failed") {
                    var missing = new RegExp('Missing');
                    var existed = new RegExp('existed');
                    var special = new RegExp('special');
                    var telephone = new RegExp('telephone');
                    var introduction = new RegExp('introduction');
                    attention();
                    if (missing.test(data.errmsg)) {
                        attention();
                        $("input").focus();
                        $("#attention").text("你漏填了什么，请检查一下再提交哦");
                    } else if (existed.test(data.errmsg)) {
                        attention();
                        $("#attention").text("您已经报名过，是否选择覆盖上次报名信息");
                    } else if (special.test(data.errmsg)) {
                        attention();
                        $("#name").focus();
                        $("#attention").text("哎呀姓名不能有特殊符号哦");
                    } else if (telephone.test(data.errmsg)) {
                        attention();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写不正确哦");
                    } else if (introduction.test(data.errmsg)) {
                        attention();
                        $("#introduction").focus();
                        $("#attention").text("哎呀个人简介不能超过50字哦");
                    }
                } else {
                    attention();
                    $("#attention").text("提交成功,后续以短信形式通知，敬请查收");
                }
            } else {
                attention();
                $("#attention").text("系统繁忙，请稍后再试");
            }
        });
    }
    console.log("------260----signbtn上空 --------");

    //前端提示 msg 
    //所有部门 数组
    var depa = new Array();
    depa[0] = "技术部-代码组";
    depa[1] = "技术部-设计组";
    depa[2] = "技术部（北校专业）";
    depa[3] = "策划推广部";
    depa[4] = "编辑部-原创写手";
    depa[5] = "编辑部-摄影";
    depa[6] = "编辑部-可视化设计";
    depa[7] = "视觉设计部";
    depa[8] = "视频部-策划导演";
    depa[9] = "视频部-摄影摄像";
    depa[10] = "视频部-剪辑特效";
    depa[11] = "外联部";
    depa[12] = "节目部-国语组";
    depa[13] = "节目部-英语组";
    depa[14] = "节目部-粤语组";
    depa[15] = "人力资源部";
    depa[16] = "综合管理部-行政管理";
    depa[17] = "综合管理部-物资财物";
    depa[18] = "综合管理部-撰文记者";
    depa[19] = "综合管理部-摄影记者";
    depa[20] = "产品运营部（北校专业）";

    var major = new Array();
    major[0] = "机械与汽车工程学院";
    major[1] = "建筑学院";
    major[2] = "土木与交通学院";
    major[3] = "电子与信息学院";
    major[4] = "材料科学与工程学院";
    major[5] = "化学与化工学院";
    major[6] = "轻工科学与工程学院";
    major[7] = "食品科学与工程学院";
    major[8] = "数学学院";
    major[9] = "物理与光电学院";
    major[10] = "经济与贸易学院";
    major[11] = "自动化科学与工程学院";
    major[12] = "计算机科学与工程学院";
    major[13] = "电力学院";
    major[14] = "生物科学与工程学院"
    major[15] = "环境与能源学院";
    major[16] = "软件学院";
    major[17] = "工商管理学院";
    major[18] = "公共管理学院";
    major[19] = "马克思主义学院";
    major[20] = "外国语学院";
    major[21] = "法学院";
    major[22] = "新闻与传播学院";
    major[23] = "艺术学院";
    major[24] = "体育学院";
    major[25] = "设计学院";
    major[26] = "医学院";
    major[27] = "国际教育学院";

    //select的option value循环
    function selector() {
        for (var i = 0; i <= 20; i++) {
            $("#department").append("<option value=" + i + ">" + depa[i] + "</option>");
            $("#alternative").append("<option value=" + i + ">" + depa[i] + "</option>");
        }
        for (var i = 0; i <= 20; i++) {
            $("#college").append("<option value=" + i + ">" + major[i] + "</option>");
        }
    }
    $("#department").change(selector());
    $("#alternative").change(selector());
    $("#college").change(selector());

    // 工厂函数结束↓
})