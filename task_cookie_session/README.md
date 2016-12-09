##cooke session作业



## 作业内容
1 会话控制（理解cookie 和session的运行原理）

作业：
1 封装 cookie 类
2 封装 session 类
3 写一个登录和退出功能（设计一个登录页，一个首页，未经过登录不允许访问首页，回到登录页，还有退出）

## 作业如下：
1. Cookie.php 封装的cookie类，包括：<br>
   - 创建Cookie的函数
   - 获取Cookie值的函数
   - 删除cookie的函数
2. Session.php 封装的Session类,包括
   - 开启session的函数
   - 创建Session的函数
   - 获取Session值的函数
   - 销毁Session的函数
   
3. cookie文件夹，写的一个小案例，用cookie实现的用户登录跟踪
   - 在案例中使用到了一个数据库，数据库的表设计如下：<br>
   
   ![表设计](http://img.blog.csdn.net/20161209153625184)
#####这个小案例的主要php文件和功能如下：
>- login.php 处理用户登录，并将用户登录的信息保存到cookie
>- index.php 网站首页，如果用户登录，则显示网站首页信息和该用户的权限。如果未登录，则跳转到登录页面。
>- page2.php 网站第二个页面，与网站首页一致。
>- page3.php 网站第三个页面，同上。
>- logout.php 退出登录页面，主要是清除cookie。
>- common.php 这个文件被除了login.php以外的所有页面引用，实现的功能是查询cookie判断用户是否登录，如果未登录，则跳转到登录页面。
>- conn_db.php 实现数据库连接。里面就一句代码：<br>
> <b> `$mysqli=new mysqli("172.16.50.38", "root", "root", "cookie_test");` </b>


