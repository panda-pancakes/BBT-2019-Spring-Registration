$(function(){
    function sign()
    {
    var name = $('#name').text();
    var gender = $('#gender').val();
    var college = $('#major option:selected').val();
    var phone = $('#tel').text();
    var ChoiceOne = $('#depa1 option:selected').val();
    var ChoiceTwo = $('#depa2 option:selected').val();
    var adjust =$('#adjust').val();
    var introduction =$('#selfintro').text();
    var info = JSON.stringify({
        name,gender,college,phone,ChoiceOne,ChoiceTwo,adjust,introduction
    });
    $.ajax({
        type: 'POST',
        url: "api/action.php",
        data: info,
        success: function(status,errmsg){
            if(status!== "ok"){
                console.log("failed");
            }else{
                console.log(errmsg);
            }
            var missing = new RegExp("Missing");
            var existed = new RegExp('existed');
            if(missing.test(errmsg)){
                $("attention").innerhtml = "你漏填了什么，检查一下再提交";
            }else if(existed.test(errmsg)){
                $("attention").innerhtml = "哎呀出现小故障，不要慌，稍候重试";
            }else{
                $("#attention").innerhtml = "提交成功,后续以短信形式通知，敬请查收"
            }
        },
      })

    }
    })