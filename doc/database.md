# Database Document
## [Table] Attendee
| Column       | Type    | Description   |
| ------------ | ------- | ------------- |
| name         | String  | 姓名          |
| sex          | Char    | 性别(F/M)     |
| tel          | String  | 电话          |
| grade        | Integer | 年级          |
| college      | Integer | 学院(编号)     |
| dorm         | String  | 宿舍号         |
| department   | Integer | 第一志愿(编号)  |
| alternative  | Integer | 第二志愿(编号)  |
| adjustment   | Boolean | 是否接受调剂    |
| introduction | String  | 自我介绍        | 
| timestamp    | Time    | 报名时间        |
| information  | String  | 返回给用户的信息 |
| note         | String  | 后台备注的信息   |

### [Column] college
* 确定好对应关系后请写在下面

### [Column] department / alternative
* 确定好对应关系后请写在下面

## [Table] Admin
| Column       | Type    | Description   |
| ------------ | ------- | ------------- |
| userid       | String  | 管理账号名称   |
| password     | String  | MD5后的密码    |
| permission   | Integer | 所属部门       |

### [Column] permission
同上的对应关系，0表示管理员账号。