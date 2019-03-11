$.get("../backend/showdata.php", function(result){
    var Eachdata = "";
    if(result.sum == 0){
        $("#Statistics").text(result.errmsg)
    }else{
        for(var i = 0; i < result.sum ; i++) {
            Eachdata = "<tr><td>" + result.showdata[i].name + "</td><td>" + result.showdata[i].sex + "</td><td>" +
            result.showdata[i].college + "</td><td>" + result.showdata[i].grade + "</td><td>" + result.showdata[i].phone + "</td><td>" + result.showdata[i].dorm + "</td><td>" + result.showdata[i].ChoiceOne + "</td><td>"
             + result.showdata[i].ChoiceTwo + "</td><td>" + result.showdata[i].adjust + "</td><td>" + result.showdata[i].introduction + "</td></tr>" 
        $("#table").append(Eachdata),
        $("#Statistics").text("共有" + result.sum + "人,其中女生" + result.GirlNum + "人，男生" + result.BoyNum + "人。" ),"json"
    }
};
})