$(document).ready(function(){
    $("button").click(function(){
      $.post("/BBT-2019-Spring-Registration/BBT-2019-Spring-Registration/api/action.php?method=admin_login",
      {
         department: $("#department").val(),
         password: $("#password").val()
      },
      function(result){
        if(result.errcode == 0){
          $("#errmsg").css("display","block")
          window.location.href='/BBT-2019-Spring-Registration/BBT-2019-Spring-Registration/admin/index.html';
        }else{
          $("#errmsg").css("display","block")
          document.getElementById('errmsg').innerHTML = result.errmsg,"json"
        }
      }    
    )
  })
})