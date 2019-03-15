$(function () {
    //先定义
    $("#attention").hide();
    var name = $('#name').val();
    var msg = String;
    //用来前端提示 信息
    var patt_num = new RegExp("0123456789");
    var patt_illegal = new RegExp("[^a-zA-Z\_\u4e00-\u9fa5]");
    msg="你绝对没填完信息";
    function check_num(e) {
        var result = patt_num.test(e);
        if(result){
            result = 0;
        }else{
            result = 1;
        }
        return result;
    }

    function check_uni(a) {
        var result = patt_illegal.test(a);
        if(result){
            result = 0;
        }else{
            result = 1;
        }
        return result;
    }
    //当前端检查通过时   启用按钮 $("#sign_btn").removeAttr("disabled");

    //查询进度
    $("#check_user").click(function(){
        $("#bbt").hide();
        // $("#check_box").show();
        $("#check_box").css({
        "margin-top":"3%",
        "display": "table",
        "vertical-align":" middle",
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
            "appearance":"none",
            "-moz-appearance":"none",
            '-webkit-appearance':"none",
           " width": "110%",
            "margin-bottom":" 3%",
            "padding": "2.3%",
            "background-color":" #dee6a8",
            "border-radius":"2em",
            "border:1px solid":" #c8cccf",
            "font-size":" 0.8em",
        
        })
    })

    function prevent(){
        $("#attention").show();
        var a = check_num(name);
        if(a=1){
            return "不要输些奇奇怪怪的东西";
        }else{
            $("#sign_btn").removeAttr("disabled");
            sign();
            return "填完啦！正在帮你提交信息";
        }
    }

    function sign() {
        var name = $('#name').val();
        var sex = $('.sex').val();
        var college = $('#college option:selected').val();
        var grade = $(".garde").text();
        var dorm = $("#dorm").val();
        var tel = $('#tel').val();
        var department = $('#department option:selected').val();
        var alternative = $('#alternative option:selected').val();
        var adjustment = $('.adjustment').val();
        var introduction = $('#introduction').val();
        //打包给php 
        console.log("正在执行sign");
        var info = JSON.stringify({
            name,
            sex,
            grade,
            college,
            dorm,
            tel,
            department,
            alternative,
            adjustment,
            introduction,
        });
        $.post("./api/action.php?method=signup", info, function(data, status) {
            if (status == "success") {
                if (data.status == "failed") {
                    var missing = new RegExp('Missing');
                    var existed = new RegExp('existed');
                    var special = new RegExp('special');
                    var telephone = new RegExp('telephone');
                    var introduction = new RegExp('introduction');
                    if (missing.test(data.errmsg)) {
                        $("#attention").show();
                        $(".text").focus();
                        $("#attention").text ("你漏填了什么，请检查一下再提交哦");
                    } else if (existed.test(data.errmsg)) {
                        $("#attention").show();
                        $("#attention").text ("您已经报名过，是否选择覆盖上次报名信息") ;
                    } else if (special.test(data.errmsg)) {
                        $("#attention").show();
                        $("#name").focus();
                        $("#attention").text ("哎呀姓名不能有特殊符号哦");
                    } else if (telephone.test(data.errmsg)) {
                        $("#attention").show();
                        $("#tel").focus();
                        $("#attention").text("哎呀手机号填写不正确哦");
                    } else if (introduction.test(data.errmsg)) {
                        $("#attention").show();
                        $("#introduction").focus();
                        $("#attention").text  ("哎呀个人简介不能超过50字哦");   
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

    function speakloud() {
        msg = prevent();
        if(msg == " "){
            msg="呃发生了什么";
        }
        console.log(msg);
        $("#attention").css({
            "background-color": "#dee6a8",
            "border-radius":"3em",
            "border":"0.8em solid #c8cccf",
            "font-size": "1em",
            "max-width":"100% "       
        });
        $("#attention").show();
        $("#attention").text(msg);
    }

    
    $("#sign_btn").click(function(){
        speakloud();
        $("#sign_btn").attr("disabled",true);
        console.log(msg);
        //禁用按钮    
    })

    //前端提示 msg 
    //所有部门 数组
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
