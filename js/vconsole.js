/*
Tencent is pleased to support the open source community by making vConsole available.

Copyright (C) 2017 THL A29 Limited, a Tencent company. All rights reserved.

Licensed under the MIT License (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
http://opensource.org/licenses/MIT

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
*/

/**
 * A Front-End Console Panel for Mobile Webpage
 */

// global
//import './lib/symbol.js';

// classes
//import VConsole from './core/core.js';
//import VConsolePlugin from './lib/plugin.js';

// export
//VConsole.VConsolePlugin = VConsolePlugin;
//export default VConsole;


function checkintro_login()
{
    let name = document.getElementById("name_input").value  
    let tel = document.getElementById("tel_input").value  
    $("#siginup").css("display","none")
    $("#introduction").css("display","none")
    document.getElementById("name").innerText="姓名：";
    document.getElementById("tel").innerText="电话：";
    $("#name_input").css("display","block")
    $("#tel_input").css("display","block")
    $.ajax({
        type:"POST",
        url:"./api/action.php?method=query",
        data:{'name':name,'tel':tel},
        success:function(errmsg){
            if(errmsg != "ok"){
                console.log(errmsg)
            }else{
                console.log("我好困呜呜呜")

            }
        }

    }) 
}
