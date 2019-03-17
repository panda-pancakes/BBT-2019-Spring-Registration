# API Document
## Signup
### Description
* 提交报名信息.

### URL
* `/api/action.php?method=signup`

### Method
* `POST`

### Encoding
* `JSON`

### Parameters
| Parameter    | Type    | Required | Description   |
| ------------ | ------- | -------- | ------------- |
| name         | String  | Yes      | 姓名			|
| sex          | String  | Yes      | 性别			|
| tel          | String  | Yes      | 电话			|
| grade        | Integer | Yes      | 年级			|
| college      | Integer | Yes      | 学院(编号)		|
| dorm         | String  | Yes      | 宿舍号			|
| department   | Integer | Yes      | 第一志愿(编号)	|
| alternative  | Integer | Optional | 第二志愿(编号)	|
| adjustment   | Boolean | Yes      | 是否接受调剂 	|
| introduction | String  | Optional | 自我介绍		|
| cover        | Boolean | Optional | 是否覆盖记录 	|

### Response
| Parameter    | Type    | Description                  |
| ------------ | ------- | ---------------------------- |
| status       | Boolean | 成功返回ok，否则返回failed.	|
| errmsg       | String  | API调用失败时返回的错误信息.	|

errmsg值为 `existed` 时表明该用户信息已存在(若姓名和手机号相同则认为是相同用户).

当cover值为 `True` 时将会覆盖已存在的信息而不会返回错误信息.

## Query
### Description
* 查询报名信息.

### URL
* `/api/action.php?method=query`

### Method
* `POST`

### Encoding
* `JSON`

### Parameters
| Parameter    | Type    | Required | Description   |
| ------------ | ------- | -------- | ------------- |
| name         | String  | Yes      | 姓名			|
| phone        | String  | Yes      | 电话			|

### Response
| Parameter    | Type    | Description                  |
| ------------ | ------- | ---------------------------- |
| status       | Boolean | 成功返回ok，否则返回failed.	|
| errmsg       | String  | API调用失败时返回的错误信息.	|
| exist        | Boolean | 是否查询到对应记录.			|
| data         | Array   | 查询到的对应记录.				|

* 注意: 即便没有查询到对应记录，只要API调用成功就会返回ok.

## Admin Login
### Description
* 后台管理登录.

### URL
* `/api/action.php?method=admin_login`

### Method
* `POST`

### Encoding
* `JSON`

### Parameters
| Parameter    | Type    | Required | Description   |
| ------------ | ------- | -------- | ------------- |
| department   | String  | Yes      | 部门名			|
| password     | String  | Yes      | 密码			|

### Response
| Parameter    | Type    | Description                  |
| ------------ | ------- | ---------------------------- |
| status       | Boolean | 成功返回ok，否则返回failed.	|
| errmsg       | String  | API调用失败时返回的错误信息.	|

* 注意: 即便没有查询到对应记录，只要API调用成功就会返回ok.


## Admin Query
### Description
* 查询报名信息.

### URL
* `/api/action.php?method=admin_query`

### Method
* `GET`

### Encoding
* `JSON`

### Response
| Parameter    | Type    | Description                  |
| ------------ | ------- | ---------------------------- |
| status       | Boolean | 成功返回ok，否则返回failed.	|
| errmsg       | String  | API调用失败时返回的错误信息.	|
| data         | Array   | 返回所有报名信息.				|

##Change department
###Description
* 内部查询切换按钮

### URL

* `/aoi/action.php?method=change_department`

###Method
* `GET`

### Encoding

* `JSON`

### Response
| Parameter    | Type    | Description                  |
| ------------ | ------- | ---------------------------- |
| status       | Boolean | 成功返回ok，否则返回failed.	|
| errmsg       | String  | API调用失败时返回的错误信息.	|
| data         | Array   | 返回所有报名信息.				|