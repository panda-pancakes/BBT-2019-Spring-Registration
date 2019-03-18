写在前： 四百多行的js文件的确有点23333 技术不行 深感抱歉

# Page2.js

#####  -------line 8---------前端过滤  function oninput绑定输入框 

 调用函数  name_check() ; dorm_check() ; tel_check() ; 

##### ---------line 23----------- 首页的查询进度按钮 隐藏元素 显示查询页  #check_user

##### ---------line 37----------- 查询页 的查询进度按钮 点击查询用户是否存在  #check_btn

调用函数 final_check()  ====> true时通过检查 false拒绝查询 禁用按钮

【每个click按钮 都有 dontclick()禁用函数】

查询成功时  调用setcookie()；getcookie(); 储存获取的用户信息  

window.location.href跳转到报名页  并把cookie值取出放进输入框

##### -------line 101----------已跳转到报名页 的修改按钮 隐藏原先的 提交按钮    #cover_user

##### -------line 147----------function cover() 用于显示成功小树 

##### -------line157 ~ 173--------- function check*() 前端检查 过滤函数

isblank() 空时返回true  ；  check_num 数字时返回true ; check_uni 非法字符时返回true

name_check() 调用以上函数  调用attention()把提示信息写出来 focus()将焦点聚到输入框；

name/dorm/tel_check()过滤通过时返回true

##### -------line 214--------- 报名按钮 在注册页面  #sign_btn

### ------line 225------- final_check()终极检查   通过时返回true

##### ------line 238--------  attention() 显示提示框

### -------line 248----- check() 报名+获取值

##### -------line 401--------- cookie()

## -------line 418 ------ dontclick() 不要按按钮 函数

##### 