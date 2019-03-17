$(document).ready(function(){
    $("button").click(function(){
      $.post("../api/action.php?method=admin_login",
      {
         department: $("#department").val(),
         password: $("#password").val()
      },
      function(result){
        if(result.errcode == 0){
          window.location.href='index.html';
        }else{
          $("#errmsg").css("display","block")
          document.getElementById('errmsg').innerHTML = result.errmsg,"json"
        }
      }    
    )
  })
})