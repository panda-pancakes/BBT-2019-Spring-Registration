# Database Document
## [Table] Attendee
| Column       | Type    | Description   |
| ------------ | ------- | ------------- |
| name         | String  | 姓名          |
| sex          | Boolean | 性别          |
| phone        | String  | 电话          |
| grade        | Integer | 年级          |
| college      | Integer | 学院(编号)     |
| dorm         | String  | 宿舍号         |
| choiceOne    | Integer | 第一志愿(编号)  |
| choiceTwo    | Integer | 第二志愿(编号)  |
| adjust       | Boolean | 是否接受调剂    |
| introduction | String  | 自我介绍       |

### [Column] sex
* 1表示男，0表示女

### [Column] grade
* 四位数表示年级

### [Column] college
* 确定好对应关系后请写在下面

### [Column] choiceOne / choiceTwo
* 确定好对应关系后请写在下面

## [Table] Admin
| Column       | Type    | Description   |
| ------------ | ------- | ------------- |
| userid       | String  | 管理账号名称   |
| password     | String  | MD5后的密码    |
| permission   | Integer | 所属部门       |

### [Column] permission
同上的ChoiceOne / ChoiceTwo的对应关系，0表示管理员账号。