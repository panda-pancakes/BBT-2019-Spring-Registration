$(function () {
    //先定义
    var name = $('#name').text();
    var sex = $('#sex').val();
    var college = $('#college option:selected').val();
    var tel = $('#tel').text();
    var department = $('#department option:selected').val();
    var alternative = $('#alternative option:selected').val();
    var adjustment = $('#adjustment').val();
    var introduction = $('#introduction').text();
    var patt_num = new RegExp("0123456789");
    var patt_illegal = new RegExp("[^a-zA-Z0-9\_\u4e00-\u9fa5]");

    function check_num(e) {
        var result = patt_num.test(e);
        return result;
    }

    function check_uni(a) {
        var result = patt_illegal.test(a);
        return result;
    }


    function speakloud() {
        var msg = String;
        $("attention").innerhtml = msg;
    }

    function sign() {
        //打包给php 
        var info = JSON.stringify({
            name,
            sex,
            college,
            tel,
            department,
            alternative,
            adjustment,
            introduction
        });
        $.ajax({
            type: 'POST',
            url: "/BBT-2019-Spring-Registration/api/action.php",
            data: info,
            success: function (status, errmsg) {
                if (status != "ok") {
                    console.log("failed");
                }
                if (status == "ok") {
                    console.log(errmsg);
                }
                var missing = new RegExp("Missing");
                var existed = new RegExp('existed');
                if (missing.test(errmsg)) {
                    $("attention").innerhtml = "你漏填了什么，检查一下再提交";
                } else if (existed.test(errmsg)) {
                    $("attention").innerhtml = "哎呀出现小故障，不要慌，稍候重试";
                } else {
                    $("#attention").innerhtml = "提交成功,后续以短信形式通知，敬请查收";
                }
            },
        })
    } //至此 sign()

    $("#sign_btn").click(sign(), speakloud());

    //所有部门 数组
    var depa = new Array(20);
    depa[0] = "技术部-代码组";
    depa[1] = "技术部-设计组";
    depa[2] = "技术部（北校专业）";
    depa[3] = "策划推广部";
    depa[4] = "编辑部-原创写手";
    depa[5] = "编辑部-摄影";
    depa[6] = "编辑部-可视化设计";
    depar[7] = "视觉设计部";
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