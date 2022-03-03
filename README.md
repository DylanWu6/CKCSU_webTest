# 开发日志

### 2.1.0003 by BaldFish

- 完成接单模块，用户点击超链接以后可以看到具体单内容

### 2.1.0002 by Ebola

- 添加了登录后修改密码的功能

### 2.1.0001 by Ebola

- 建立了注册与登录功能，登录之后可以显示已经完成的锅

- 需要建立一个名为`login_test`的数据库，在里面建立`register`、`finished_pots`两个表

- `register`设计如下：

  ![](http://image.wenchong-huang.com/i/2021/02/14/iq4fj3.png)

  `varchar`类型的字段均设置`utf-8`编码

  `username`是用户名，建议统一注册，命名为`xw2101`、`xw2102`等

  `password`保存`SHA256`散列后的密码，散列算法在前端完成，将散列结果发送至后端，以保证传输过程安全

  `name`是用户的真实姓名

- `finished_pots`设计如下：

  ![](http://image.wenchong-huang.com/i/2021/02/14/ir864u.png)

  `varchar`类型中，中`potid`设为`ascii`编码，其它均设为`utf-8`编码

  `finisher`是接锅人的`username`，**注意不是`id`**

  其它的看字面意思应该能明白
