$.get("../api/action.php?method=admin_query", function(result){
    var Eachdata = "";
    if(result.errcode == -1){
        $("#Statistics").css("display","block")
        document.getElementById('Statistics').innerHTML = result.errmsg,"json"
    }else{
        console.log(result);
        for(var i = 0; i < result.sum ; i++) {
            Eachdata = "<tr><td>" + result.data[i].name + "</td><td>" + result.data[i].sex + "</td><td>" +
            result.data[i].college + "</td><td>" + result.data[i].grade + "</td><td>" + result.data[i].tel + "</td><td>" + result.data[i].dorm + "</td><td>" + result.data[i].department + "</td><td>"
             + result.data[i].alternative + "</td><td>" + result.data[i].adjustment + "</td><td>" + result.data[i].introduction + "</td></tr>" 
        $("#table").append(Eachdata),
        $("#Statistics").text("共有" + result.sum + "人" ),"json"
    }
};
})

function isSelect(selectPress) {
    var selectValue = selectPress.options[selectPress.selectedIndex].value;
$.get("../api/action.php?method=change_department",{value:selectValue},function(result){
    var Eachdata = "";
    if(result.errcode == -1){
        $("#Statistics").css("display","block")
        document.getElementById('Statistics').innerHTML = result.errmsg,"json"
    }else{
            console.log(result.sum)
        for(var i = 0; i < result.sum ; i++) {
            Eachdata = "<tr><td>" + result.data[i].name + "</td><td>" + result.data[i].sex + "</td><td>" +
            result.data[i].college + "</td><td>" + result.data[i].grade + "</td><td>" + result.data[i].tel + "</td><td>" + result.data[i].dorm + "</td><td>" + result.data[i].department + "</td><td>"
             + result.data[i].alternative + "</td><td>" + result.data[i].adjustment + "</td><td>" + result.data[i].introduction + "</td></tr>" 
        $("#table").append(Eachdata),
        $("#Statistics").text("共有" + result.sum + "人" ),"json"
    }
};  
})
}
