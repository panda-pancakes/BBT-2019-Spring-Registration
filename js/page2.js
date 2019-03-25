$(function () {
    //先定义
    // $("#attention").hide();
    $("#233").hide();
    $("#cover_user").hide();
    $("#bgimg1").hide();
    $("#hiddenbox").hide();
    $("#appear").hide();
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
        if (final_check() == false) { //真的在检查
        }
        if (final_check()) {
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
                    } else { //查询成功
                        $("#appear_info").empty()
                        $("#query").hide();
                        if (data.info.sex == "M") {
                            var info_sex = "男";
                        } else {
                            var info_sex = "女";
                        }
                        if (data.info.adjustment == "true") {
                            var info_adjustment = "是";
                        } else {
                            var info_adjustment = "否";
                        }
                        $("#appear").show();
                        $("#appear_info").append("姓名：" + data.info.name + "<br>");
                        $("#appear_info").append("性别：" + info_sex + "<br>");
                        $("#appear_info").append("年级：" + data.info.grade + "<br>");
                        $("#appear_info").append("学院：" + major[data.info.college] + "<br>");
                        $("#appear_info").append("宿舍：" + data.info.dorm + "<br>");
                        $("#appear_info").append("联系电话：" + data.info.tel + "<br>");
                        $("#appear_info").append("第一志愿：" + depa[data.info.department] + "<br>");
                        $("#appear_info").append("第二志愿：" + depa[data.info.alternative] + "<br>");
                        $("#appear_info").append("是否服从调剂：" + info_adjustment + "<br>");
                        $("#appear_info").append("个人简介：" + data.info.introduction + "<br>");
                        $("#edit").click(function () { //进入修改信息的页面
                            $("#appear").hide();
                            $("#query").show();
                            $("#hiddenbox").show();
                            $("#introduction").show();

                            $("#name").val(data.info.name);
                            $("#tel").val(data.info.tel);
                            $("#dorm").val(data.info.dorm);
                            $("#introduction").val(data.info.introduction);
                            $("input:radio[name='sex'][value=" + data.info.sex + "]").prop("checked", true);
                            $("input:radio[name='grade'][value=" + data.info.grade + "]").prop("checked", true);
                            $("input:radio[name='adjustment'][value=" + data.info.adjustment + "]").prop("checked", true);
                            $("#college").val(data.info.college);
                            $("#department").val(data.info.department);
                            $("#alternative").val(data.info.alternative);
                            $("#cover_user").show();
                        });
                        $("#sign_btn").hide();
                        //修改按钮
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
        var sex = $('input:radio[name="sex"]:checked').val();
        var college = $('#college').prop('selectedIndex');
        var grade = $('input:radio[name="grade"]:checked').val();
        var dorm = $("#dorm").val();
        var tel = $('#tel').val();
        var department = $("#department").prop('selectedIndex');
        var alternative = $("select#alternative").prop('selectedIndex');
        var adjustment = $('input:radio[name="adjustment"]:checked').val();
        var introduction = $('#introduction').val();
        var cover = "true";
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
            cover,
        });
        console.log(info);
        $.post("./api/action.php?method=signup", info, function (data, status) {
            console.log("ok");
            if (status == "success") {
                if (data.status == "failed") {
                    var missing = new RegExp('Missing');
                    var special = new RegExp('special');
                    var telephone = new RegExp('telephone');
                    var same = new RegExp('same');
                    var introduction = new RegExp('introduction');
                    attention();
                    if (missing.test(data.errmsg)) {
                        attention();
                        $("input").focus();
                        $("#attention").text("信息填写不完整，请将必填信息填完整之后再提交哦");
                    } else if (special.test(data.errmsg)) {
                        attention();
                        $("#name").focus();
                        $("#attention").text("哎呀姓名不能有特殊符号哦");
                    } else if (telephone.test(data.errmsg)) {
                        attention();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写格式不正确哦");
                    } else if (same.test(data.errmsg)) {
                        attention();
                        $("#department").focus();
                        $("#attention").text("哎呀第一志愿和第二志愿不能相同哦");
                    } else if (introduction.test(data.errmsg)) {
                        attention();
                        $("#introduction").focus();
                        $("#attention").text("哎呀个人简介不可以超过50字哦");
                    } else {
                        attention();
                        $("#attention").text("系统繁忙，请稍后再试");
                    }
                } else {
                    //success_cover();
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
    function success_cover() {
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
        } else {
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
        } else {
            var rest = true;
        }
        return rest;
    }

    function tel_check() {
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
        console.log("final_check()");
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
        //var college = $("select#college").get(0).selectedIndex;
        var college = $('#college').prop('selectedIndex');
        var grade = $('input:radio[name="grade"]:checked').val();
        var dorm = $("#dorm").val();
        var tel = $('#tel').val();
        var department = $('#department').prop('selectedIndex');
        var alternative = $('#alternative').prop('selectedIndex');
        var adjustment = $('input:radio[name="adjustment"]:checked').val();
        var introduction = $('#introduction').val();
        //打包给php 
        console.log(adjustment);
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
                    var same = new RegExp('same');
                    var introduction = new RegExp('introduction');
                    attention();
                    //change_pic(data.errmsg);
                    if (missing.test(data.errmsg)) {
                        attention();
                        $("input").focus();
                        $("#attention").text("信息填写不完整，请将必填信息填完之后再提交哦");
                    } else if (special.test(data.errmsg)) {
                        attention();
                        $("#name").focus();
                        $("#attention").text("哎呀姓名不能有特殊符号哦");
                    } else if (telephone.test(data.errmsg)) {
                        attention();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写格式不正确哦");
                    } else if (same.test(data.errmsg)) {
                        attention();
                        $("#department").focus();
                        $("#attention").text("哎呀第一志愿和第二志愿不能相同哦");
                    } else if (introduction.test(data.errmsg)) {
                        attention();
                        $("#introduction").focus();
                        $("#attention").text("哎呀个人简介不可以超过50字哦");
                        // $("#attention").append("<img src=" + URL("../img/attention/6.png") + "class="+"attention"+">" );
                    } else if (existed.test(data.errmsg)) {
                        attention();
                        $("#attention").text("哎呀您之前已经提交过报名信息了哦，不可重复提交哦!如果想要修改信息，请从进度查询页面进行修改");
                    } else {
                        attention();
                        $("#attention").text("系统繁忙，请稍后再试");
                    }
                } else {
                    attention();
                    $("#attention").text("提交成功,后续以短信形式通知，敬请查收");
                    window.location.href = 'success.html';
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
        depa[0] = "请选择部门";
        depa[1] = "技术部-代码组";
        depa[2] = "技术部-设计组";
        depa[3] = "技术部（北校专业）";
        depa[4] = "策划推广部";
        depa[5] = "编辑部-原创写手";
        depa[6] = "编辑部-摄影";
        depa[7] = "编辑部-可视化设计";
        depa[8] = "视觉设计部";
        depa[9] = "视频部-策划导演";
        depa[10] = "视频部-摄影摄像";
        depa[11] = "视频部-剪辑特效";
        depa[12] = "外联部";
        depa[13] = "节目部-国语组";
        depa[14] = "节目部-英语组";
        depa[15] = "节目部-粤语组";
        depa[16] = "人力资源部";
        depa[17] = "综合管理部-行政管理";
        depa[18] = "综合管理部-物资财物";
        depa[19] = "综合管理部-撰文记者";
        depa[20] = "综合管理部-摄影记者";
        depa[21] = "产品运营部（北校专业）";

        major[0] = "请选择学院";
        major[1] = "机械与汽车工程学院";
        major[2] = "建筑学院";
        major[3] = "土木与交通学院";
        major[4] = "电子与信息学院";
        major[5] = "材料科学与工程学院";
        major[6] = "化学与化工学院";
        major[7] = "轻工科学与工程学院";
        major[8] = "食品科学与工程学院";
        major[9] = "数学学院";
        major[10] = "物理与光电学院";
        major[11] = "经济与贸易学院";
        major[12] = "自动化科学与工程学院";
        major[13] = "计算机科学与工程学院";
        major[14] = "电力学院";
        major[15] = "生物科学与工程学院";
        major[16] = "环境与能源学院";
        major[17] = "软件学院";
        major[18] = "工商管理学院";
        major[19] = "公共管理学院";
        major[20] = "马克思主义学院";
        major[21] = "外国语学院";
        major[22] = "法学院";
        major[23] = "新闻与传播学院";
        major[24] = "艺术学院";
        major[25] = "体育学院";
        major[26] = "设计学院";
        major[27] = "医学院";
        major[28] = "国际教育学院";

    }
    //select的option value循环


    function selector() {
        for (var i = 0; i <= 21; i++) {
            $("#department").append("<option value=" + i + ">" + depa[i] + "</option>");
            $("#alternative").append("<option value=" + i + ">" + depa[i] + "</option>");
        }
        for (var i = 0; i <= 28; i++) {
            $("#college").append("<option value=" + i + ">" + major[i] + "</option>");
        }
        // $("#department option[value=0]").attr("selected", true);
        // $("#alternative option[value=0]").attr("selected", true);
        // $("#college option[value=0]").attr("selected", true);
    }

    $("#department").change(selector());
    $("#alternative").change(selector());
    $("#college").change(selector());

    // 工厂函数结束↓


    //settimeout 禁用按钮
    function dontclick() {
        setTimeout(function () {
            $("#attention").text("要等一会才能再次查询");
            console.log("禁用按钮");
            attention();
            $("#attention").focus();
        }, 4000);
        setTimeout(function () {
            console.log("启用按钮");
            $("#attention").hide();
            $("#check_btn").removeAttr('disabled');
            $("#cover_user").removeAttr('disabled');
            $("#sign_btn").removeAttr('disabled');
        }, 1200);

    }

    //attention 图片 变换
//     function change_pic(str) {
//         var missing = new RegExp('Missing');
//         var existed = new RegExp('existed');
//         var special = new RegExp('special');
//         var tel = new RegExp('telephone');
//         var intro = new RegExp('introduction');
//         var img = document.getElementById("attention_pic");
//         console.log(img.src);
//         if (missing.test(str)) {
//             img.src = "img/attention/2.png";
//         }
//         if (existed.test(str)) {
//             img.src = "img/attention/x.png"; /////等xy做这个
//         }
//         if (special.test(str)) {
//             img.src = "img/attention/3.png";
//         }
//     }
})