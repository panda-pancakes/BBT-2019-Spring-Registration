$.get("../api/action.php?method=admin_query", function (result) {
    if (result.permission == 0) {
        $("#department").css("display", "block")
    } else {
        $("#department").css("display", "none")
    }
    var Eachdata = ""
    if (result.errcode == -1) {
        $("#Statistics").css("display", "block")
        document.getElementById('Statistics').innerText = result.errmsg, "json"
    } else {
        if (result.sum == 0) {
            $("#Statistics").text("暂无报名数据噢"), "json"
        } else {
            console.log(result);
            for (var i = 0; i < result.sum; i++) {
                Eachdata = "<tr><td>" + result.data[i].name + "</td><td>" + result.data[i].sex + "</td><td>" +
                    result.data[i].college + "</td><td>" + result.data[i].grade + "</td><td>" + result.data[i].tel + "</td><td>" + result.data[i].dorm + "</td><td>" + result.data[i].department + "</td><td>" +
                    result.data[i].alternative + "</td><td>" + result.data[i].adjustment + "</td><td>" + result.data[i].introduction + "</td></tr>"
                $("#body").append(Eachdata),
                    $("#Statistics").text("恭喜！共有" + result.sum + "人报名噢！"), "json"
            }
        }
    };
})

function isSelect(selectPress) {
    var selectValue = selectPress.options[selectPress.selectedIndex].value;
    $.get("../api/action.php?method=change_department", {
        value: selectValue
    }, function (result) {
        $("#body").empty();
        var Eachdata = ""
        if (result.errcode == -1) {
            $("#Statistics").css("display", "block")
            document.getElementById('Statistics').innerHTML = result.errmsg, "json"
        } else {
            if (result.sum == 0) {
                $("#Statistics").text("暂无报名数据噢"), "json"
            } else {
                console.log(result);
                for (var i = 0; i < result.sum; i++) {
                    Eachdata = "<tr><td>" + result.data[i].name + "</td><td>" + result.data[i].sex + "</td><td>" +
                        result.data[i].college + "</td><td>" + result.data[i].grade + "</td><td>" + result.data[i].tel + "</td><td>" + result.data[i].dorm + "</td><td>" + result.data[i].department + "</td><td>" +
                        result.data[i].alternative + "</td><td>" + result.data[i].adjustment + "</td><td>" + result.data[i].introduction + "</td></tr>"
                    $("#body").append(Eachdata),
                        $("#Statistics").text("恭喜！共有" + result.sum + "人报名噢！"), "json"
                }
            }
        };
    })
}