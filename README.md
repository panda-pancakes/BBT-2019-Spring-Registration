# BBT-2019-Spring-Registration
百步梯2019年春季招新报名页面，同时也是2018级第一次组队任务。

## To-do
* 前端：

  1.input非空和focus 

  2.每当输入完就检查字符 ① ------->

  所有信息填完后attention提示- ②------->解禁按钮

  3.swiper的文本框 js导进去  

  4.swiper那个导航文本js动态改变 索引值对应数组序号

  5.查询进度那个页面也同样检查字符 （这里要对应一下后端的查询php 如果存在就问要不要覆盖

  6.↑存在时的元素 {  提示框；确认按钮（覆盖php)  返回或修改按钮}

  7.确认或修改按钮按进去  （要获取值然后 让用户不要再自己重新填一次  自动填充 

  8.成功页面{ 一棵树和 提示信息}

   共9个

* 确定学院和部门列表并赋编号

* 后端：

  1.完成内部查询的分页功能（根据部门分类）

  2.测试API

  3.重新修改action.php里内部登录查询的函数（尽量简洁）

  4.把TO-DO一条条划掉

  5.完成edit

  6.重新修改API里的数据库查询代码（如何提出数据和统计数据）

## Structure
`./index.html` - 主页

`./signup.html` - 报名页

`./introduction.html` - 部门介绍页

`./login.html` - 内部人员登录页

`./index.html` - 内部人员查询页 

`./css/` - 存放样式表

`./js/` - 存放JavaScript

`./img/` - 存放图片

`./api/` - 存放后端程序

`./api/action.php` - 供前端调用的API，在这里判断传入参数的合法性

`./api/database.php` - 将数据库操作独立出来放在这个部分

## Deployment
1. git clone到相应目录.
2. 编辑 `config-sample.php` ，记入数据库连接凭证，并将其更名为 `config.php`.
3. 执行 `install.php` 以测试数据库连接并建立表.

## Members
* 设计:
* 前端:
* 后端:
