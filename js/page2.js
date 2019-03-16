$(function () {
    //先定义
    $("#attention").hide();
    var name = $('#name').val();
    var tel = $("#tel").val();
    var msg = String;
    //用来前端提示 信息
    var patt_num = new RegExp("0123456789");
    var patt_illegal = new RegExp("[^a-zA-Z\_\u4e00-\u9fa5]");
    msg = "你绝对没填完信息";

    //查询进度 页面 输入手机号和姓名 
    $("#check_user").click(function () {
        $("#bbt").hide();
        // $("#check_box").show();
        $("#check_box").css({
            "margin-top": "3%",
            "display": "table",
            "vertical-align": " middle",
            "text-align": "center",
            "padding-left": "10%",
            "padding-top": "35%"
        });
        $("#prev").css({
            "vertical-align": "middle"
        });
        $("#check_btn").css({
            "vertical-align": "middle"
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
    }) //显示查询页面
    console.log("到达checkbtn函数上空");

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
                    var missing = new RegExp('Missing');
                    var telephone = new RegExp('telephone');
                    if (missing.test(data.errmsg)) {
                        $("#attention").show();
                        $(".text").focus();
                        $("#attention").text("你漏填了什么，请检查一下再提交哦");
                    } else if (telephone.test(data.errmsg)) {
                        $("#attention").show();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写格式不正确哦");
                    } else if (data.errcode == '233') {
                        $("#attention").show();
                        $("#attention").text("不好意思，没有您的报名信息哦");
                    }else {
                        $("#attention").show();
                        $("#attention").text("查询成功");
                        console.log(data.info);
                    }
                } else {
                    $("#attention").show();
                    $("#attention").text("系统繁忙，请稍后再试");
                }
            }
        })
    });

  
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
                        $("#attention").show();
                        $(".text").focus();
                        $("#attention").text("你漏填了什么，请检查一下再提交哦");
                    } else if (existed.test(data.errmsg)) {
                        $("#attention").show();
                        $("#attention").text("您已经报名过，是否选择覆盖上次报名信息");
                    } else if (special.test(data.errmsg)) {
                        $("#attention").show();
                        $("#name").focus();
                        $("#attention").text("哎呀姓名不能有特殊符号哦");
                    } else if (telephone.test(data.errmsg)) {
                        $("#attention").show();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写不正确哦");
                    } else if (introduction.test(data.errmsgs)) {
                        $("#attention").show();
                        $("#introduction").focus();
                        $("#attention").text("哎呀个人简介不能超过50字哦");
                    }
                } else {
                    $("#attention").show();
                    $("#attention").text("提交成功,后续以短信形式通知，敬请查收");
                }
            } else {
                $("#attention").show();
                $("#attention").text("系统繁忙，请稍后再试");
            }
        });
    }
    console.log("到达attention函数上空");

    function attention() {
        $("#attention").css({
            "background-color": "#dee6a8",
            "border-radius": "3em",
            "border": "0.8em solid #c8cccf",
            "font-size": "1em",
            "max-width": "100% "
        });
        $("#attention").show();
        $("#attention").html(msg);
    }
    // $(".sign").on('click','#sign_btn',function(){
    //     alert("你点了这个按钮");
    //     sign();
    // })
    console.log("到达click函数上空");
    $("#sign_btn").click(function () {
        alert("hey")
        console.log("你点了这个按钮");
        check();
    });

    //前端提示 msg 
    //所有部门 数组
    console.log("到达selector函数上空");
    var depa = new Array(20);
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

    //select的option value循环
    function selector() {
        for (var i = 0; i <= 20; i++) {
            $("#department").append("<option value=" + i + ">" + depa[i] + "</option>");
            $("#alternative").append("<option value=" + i + ">" + depa[i] + "</option>");
        }
    }
    $("#department").change(selector());
    $("#alternative").change(selector());

    // 工厂函数结束↓
})