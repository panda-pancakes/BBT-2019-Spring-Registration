$(function(){
    //先定义
    var name = $('#name').text();
    var sex = $('#gender').val();
    var college = $('#major option:selected').val();
    var grade = $("#garde").text();
    var dorm = $("#dorm").text();
    var phone = $('#tel').text();
    var ChoiceOne = $('#depa1 option:selected').val();
    var ChoiceTwo = $('#depa2 option:selected').val();
    var adjust =$('#adjust').val();
    var introduction =$('#selfintro').text();
    var patt_num =new RegExp("0123456789");
    var patt_illegal=new RegExp("[^a-zA-Z0-9\_\u4e00-\u9fa5]");

    function check_num(e){
        var result=patt_num.test(e);
        return result;
    }
    function check_uni(a){
        var result=patt_illegal.test(a);
        return result;
    }


    function speakloud(){
        var msg =String;
        $("attention").innerhtml = msg;
    }
    function sign()
    {
   //打包给php 
    var info = JSON.stringify({
        name,sex,grade,dorm,phone,college,ChoiceOne,ChoiceTwo,adjust,introduction
    });
    $.ajax({
        type: 'POST',
        url: "/BBT-2019-Spring-Registration/api/action.php",
        data: info,
        success: function(status,errmsg){
            if(status!= "ok"){
                console.log("failed");
            }
            if(status == "ok"){
                console.log(errmsg);
            }
            var missing = new RegExp("Missing");
            var existed = new RegExp('existed');
            if(missing.test(errmsg)){
                $("attention").innerhtml = "你漏填了什么，检查一下再提交";
            }else if(existed.test(errmsg)){
                $("attention").innerhtml = "哎呀出现小故障，不要慌，稍候重试";
            }else{
                $("#attention").innerhtml = "提交成功,后续以短信形式通知，敬请查收";
            }
        },
      })
    }//至此 sign()

    $("#sign_btn").click(sign(),speakloud());

    //所有部门 数组
    var department = new Array(20);
    department[0]="技术部-代码组";
    department[1]="技术部-设计组";
    department[2]="技术部（北校专业）";
    department[3]="策划推广部";
    department[4]="编辑部-原创写手";
    department[5]="编辑部-摄影";
    department[6]="编辑部-可视化设计";
    department[7]="视觉设计部";
    department[8]="视频部-策划导演";
    department[9]="视频部-摄影摄像";
    department[10]="视频部-剪辑特效";
    department[11]="外联部";
    department[12]="节目部-国语组";
    department[13]="节目部-英语组";
    department[14]="节目部-粤语组";
    department[15]="人力资源部";
    department[16]="综合管理部-行政管理";
    department[17]="综合管理部-物资财物";
    department[18]="综合管理部-撰文记者";
    department[19]="综合管理部-摄影记者";
    department[20]="产品运营部（北校专业）";

    var major = new Array();

    //select的option value循环
    function selector(){
        for(var i = 0;i<=20;i++){
            $("#depa1").append("<option value="+i+">"+department[i]+"</option>");
            $("#depa2").append("<option value="+i+">"+department[i]+"</option>");
        }
    }
    $("#depa1").change(selector());
    $("#depa2").change(selector());

    // 工厂函数结束↓
    })