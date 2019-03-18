$(function () {
    //先定义
    // $("#attention").hide();
    $("#233").hide();
    $("#cover_user").hide();
    $("#bgimg1").hide();
    $("#successbox").hide();
    //前端过滤
    function oninput() {
        $("#name").bind('input propertychange', function () {
            name_check();
        });
        $("#dorm").bind('input propertychange', function () {
            dorm_check();
        })
        $("#tel").bind('input propertychange', function () {
            tel_check();
        })
    }
    oninput();
    console.log("------14----js错误检查程序loading--------");
    //查询进度 页面 输入手机号和姓名 
    $("#check_user").click(function () {
        $("#bbt").hide();
        // $("#check_box").show();
        $("#check_box").css({
            "display": "block",
        });
        $("#prev").css({
            "vertical-align": "middle"
        });
        $("#bgimg1").show();
    }) //显示查询页面
    // console.log("到达checkbtn函数上空");

    //真的查询
    $("#check_btn").click(function () {
        console.log("你点了信息查询按钮");
        $("#check_btn").attr('disabled', 'disabled');
        console.log("禁用信息查询按钮");
        var name = $('#name').val();
        var tel = $('#tel').val();
        var info = JSON.stringify({
            name,
            tel,
        });
        console.log(info);
        if (final_check()==false) {//真的在检查
        }
        if(final_check()){
            $.post("./api/action.php?method=query", info, function (data, status) {
            console.log("到达ajax");
            if (status == "success") {
                if (data.status == "failed") {
                    var missing = new RegExp('Missing');
                    var telephone = new RegExp('telephone');
                    var noinfo = new RegExp('infomation');
                    if (missing.test(data.errmsg)) {
                        attention();
                        $(".text").focus();
                        $("#attention").text("你漏填了什么，请检查一下再提交哦");
                    } else if (telephone.test(data.errmsg)) {
                        attention();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写格式不正确哦");
                    } else if (noinfo.test(data.errmsg)) {
                        $("#233").show();
                        attention();
                        $("#attention").text("不好意思，没有您的报名信息哦");
                    } else {
                        attention();
                        $("#attention").text("系统繁忙，请稍后再试");
                        console.log(data.info);
                    }
                } else {//查询成功
                    console.log(data.info);
                    setcookie(data.info.name);
                    setcookie(data.info.tel);
                    setCookie(data.info.dorm);
                    setcookie(data.info.introduction);
                    alert("感谢"+getCookie("name")+"同学的报名！");
                    window.location.href="../signup.html";
                    $("#name").val(getCookie("name"));
                    $("#tel").val(getCookie("tel"));
                    $("#dorm").val(getCookie("dorm"));
                    $("#introduction").val(getCookie("intro"));
                    // TO-DO:data里面存了返回的查询信息，跳转到另一页面，把该用户查询的信息给显示出来
                    $("#sign_btn").hide();
                    $("#cover_user").show(); //修改按钮
                }
            }
        }).always(function () {
            //模拟请求延时 防止 按钮重复按
            dontclick();
        });
    }
    })

    //覆盖
    // console.log("------96----路过覆盖函数上空 --------");
    $("#cover_user").click(function () {
        console.log("覆盖");
        $("#cover_user").attr('disabled', 'disabled');
        console.log("禁用覆盖按钮");
        var name = $('#name').val();
        var tel = $('#tel').val();
        var info = JSON.stringify({
            name,
            tel,
        });
        var cover = "true";
        $.post("./api/action.php?method=signup", info, function (data, status) {
            if (status == "success") {
                if (data.status == "failed") {
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
                        $("#attention").text("系统繁忙，请稍后再试");
                        // console.log(data.info);
                    }
                } else {
                    cover();
                    attention();
                    $("#successbox:first-child").show();
                    $("#attention").text("修改信息成功");
                }
            }
        }).always(function () {
            dontclick();
        })
    })

    //显示cover按钮和树
    function cover() {
        $("#check_box").hide();
        // $("#cover_user").show();
        $("#successbox:first-child").hide();
        $("#successbox").css({
            "visibility": "visible",
        });
        console.log("正在显示cover按钮");
    }
    //前端检查字符
    function isBlank(str) {
        return (!str || /^\s*$/.test(str));
    }

    function check_num(a) {
        //var patt_num = new RegExp(/^1[34578]\d{9}$/s);
        var patt_num = new RegExp(/^[0-9]*$/g);
        return (patt_num.test(a));
    }
    // var tes1 = "@";
    // var tes2 ="?";
    function check_uni(str) {
        var patt_illegal = new RegExp(/[\@\#\$\%\^\&\*{\}\:\\L\<\>\?}\'\"\\\/\b\f\n\r\t]/g);
        return patt_illegal.test(str);
    }
    // console.log("tes1"+":"+check_uni(tes1)+"-----tes2="+check_uni(tes2));
    function name_check() {
        var name = $("#name").val();
        if ((isBlank(name)) || (check_uni(name)) || (check_num(name))) {
            $("#name").focus();
            $("#attention").text("填名字！");
            attention();
            rest = false;
        }else {
            var rest = true;
        }
        return rest;
    }

    function dorm_check() {
        var dorm = $("#dorm").val();
        if ((isBlank(dorm)) || (check_uni(dorm))) {
            $("#dorm").focus();
            $("#attention").text("宿舍号！");
            attention();
            rest = false;
        }else {
            var rest = true;
        }
        return rest;
    }

    function tel_check(){
        var tel = $("#tel").val();
        if ((isBlank(tel)) || (check_uni(tel)) || (!check_num(tel))) {
            $("#tel").focus();
            $("#attention").text("手机号！");
            attention();
            rest = false;
        } else {
            var rest = true;
        }
        return rest;
    }
 

    //报名按钮
    $("#sign_btn").click(function () {
        if (final_check()) {
            check();
        } else {
            $("attention").text("请再检查一下自己填的内容！");
            $("#attention").show();
            attention();
        }
    })

    //调用检查字符的各个函数 并在attention写入提示信息  返回布尔值 正确时允许按下按钮发送请求
    function final_check() {
        console.log("prevent()");
        if (name_check() && tel_check()) {
            rest = true;
        } else {
            $("attention").text("请再检查一下自己填的内容！");
            $("#attention").show();
            attention();
            rest = false;
        }
        return rest;
    }

    function attention() {
        console.log($("#attention").text());
        $("#attention").show();
        // $("#cover_user").show();
        $("#attention").css({
            "display": "block",
        });
    }
    console.log("------194----check上空 --------");
    //注册
    function check() {
        $("#sign_btn").attr('disabled', 'disabled');
        console.log("禁用报名按钮");
        $("#attention").text("请稍等……");
        attention();
        var name = $('#name').val();
        var sex = $('input:radio[name="sex"]:checked').val();
        var college = $("select#college").get(0).selectedIndex;
        var grade = $('input:radio[name="grade"]:checked').val();
        var dorm = $("#dorm").val();
        var tel = $('#tel').val();
        var department = $("select#department").get(0).selectedIndex;
        var alternative = $("select#alternative").get(0).selectedIndex;
        var adjustment = $('input:radio[name="adjustment"]:checked').val();
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
        console.log(info);
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
                        // $("#attention").append("<img src=" + URL("../img/attention/6.png") + "class="+"attention"+">" );
                    } else if (existed.test(data.errmsg)) {
                        attention();
                        $("#attention").text("您已经报名过，是否选择覆盖上次报名信息");
                        console.log("到达覆盖");
                        cover();
                    }
                } else {
                    attention();
                    $("#attention").text("提交成功,后续以短信形式通知，敬请查收");
                }
            } else {
                attention();
                $("#attention").text("系统繁忙，请稍后再试");
            }
        }).always(function () {
            //模拟请求延时 防止 按钮重复按
            dontclick();
        });
    }
    // console.log("------260----signbtn上空 --------");

    //前端提示 msg 
    //所有部门 数组
    var major = new Array();
    var depa = new Array();
    addarray();

    function addarray() {
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


    }
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

    //cook cookies
    function setCookie(cname,cvalue){
        document.cookie=cname+"="+cvalue+";";
        if(document.cookie.length<=0){
            return false;
        }
    }
    function getCookie(cname){
        var a = cname+"=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++){
            var c = ca[i].trim();
            if (c.indexOf(name)==0){
                return c.substring(a.length,c.length);
            }
        }
        return "";
    }
    //settimeout 禁用按钮
    function dontclick(){
        setTimeout(function () {
            $("#attention").text("要等一会才能再次查询");
            attention();
            $("#attention").focus();
        }, 5000);
        setTimeout(function () {
            console.log("启用按钮");
            $("#check_btn").removeAttr('disabled');
            $("#cover_user").removeAttr('disabled');
            $("#sign_btn").removeAttr('disabled');
        }, 23333);

    }
})