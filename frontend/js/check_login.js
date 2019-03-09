$(document).ready(function(){
    $("button").click(function(){
      $.post("../backend/check_login.php",
      {
         department: $("#department").val(),
         password: $("#password").val()
      },
      function(result){
        if(result.errcode == 0){
          document.getElementById('errmsg').style.display = "block"
          document.getElementById('errmsg').innerHTML = result.errmsg,"json"
          window.location.href='../frontend/check_show.html';
        }else{
          document.getElementById('errmsg').style.display = "block"
          document.getElementById('errmsg').innerHTML = result.errmsg,"json"
        }
      }    
    )
  })
})