$(function(){
    function sign(){
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
    $.post("../api/action.php", info);
    }
})