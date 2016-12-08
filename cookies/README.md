##这个案例是通过简单的php数据库操作和cookie实现用户登录跟踪
### 1. 这个小案例需要实现的功能如下：
>-  用户登录之后，下次进入该网站的任何页面都不需要重新登录，除非退出登录或者登录到期。
>-  用户登录之后，其他所有的网页显示的内容都是和该用户有关的内容。

### 2. 这个小案例的主要php文件和功能如下：
>- login.php 处理用户登录，并将用户登录的信息保存到cookie
>- index.php 网站首页，如果用户登录，则显示网站首页信息和该用户的权限。如果未登录，则跳转到登录页面。
>- page2.php 网站第二个页面，与网站首页一致。
>- page3.php 网站第三个页面，同上。
>- logout.php 退出登录页面，主要是清除cookie。
>- common.php 这个文件被除了login.php以外的所有页面引用，实现的功能是查询cookie判断用户是否登录，如果未登录，则跳转到登录页面。
>- conn_db.php 实现数据库连接。里面就一句代码：<br>
> <b> `$mysqli=new mysqli("172.16.50.28", "root", "root", "cookie_test");` </b>

### 3.案例中用到的主要函数：

* 1.创建数据库连接

```
$mysqli=new mysqli("172.16.50.28", "root", "root", "cookie_test");
```

<pre>
说明： 创建一个数据库连接的对象，通过该对象可以实现数据库的增删改查操作。
</pre>

* 2.创建cookie

```
setcookie("username",$user["username"],$time);
```

<pre>
说明： 参数分别是 cookie名称、cookie的值、cookie有效时长。
如果想删除cookie，则也是用这个函数，只是不传后两个参数，如：
<code>setcookie("username");</code>
或者传3个参数，但是第三个参数传入当前时间或者过期的时间，如：
<code>setcookie("username","",$time() - 200);</code>
</pre>

* 2.读取cookie

```
$_COOKIE["username"];
```

<pre>
说明： $_COOKIE 是一个全局的数组，用来读取cookie值，
读取时传入的key值为cookie名称。
</pre>


* 2. 查询数据库

```
$result = $mysqli->query($sql);
```

<pre>
说明：
$mysqli 是一个数据库连接对象，见1。
$sql是sql语句。
</pre>

* 3. 查询数据库

```
$result = $mysqli->query($sql);
```

<pre>
说明：
$mysqli 是一个数据库连接对象，见1。
$sql是sql语句。
$result 是query()函数返回的一个对象，里面包含了查询到的信息。
</pre>

* 3. 判断是否查询到数据

```
if($result->num_rows > 0){
   //do something
}
```

<pre>
说明：
$num_rows 查询到数据的行数，如果大于0,说明查询到了数据。
</pre>

* 4. 获取从数据库中查询到的数据

```
$row = $result -> fetch_assoc();
```
<pre>
说明：
每调用一次fetch_assoc()函数，就返回一行的数据（索引自动往后+1）。
</pre>

