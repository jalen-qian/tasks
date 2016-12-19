# 金陵贸易网站开发
-----
主要分为前台开发和后台管理系统的开发
一。前台
   主要是一些数据查询的操作
二。后台
>admin目录下面的所有页面是后台管理页面，系统使用Session进行会话控制，Sessio类的封装见session/session.php

> 数据库连接采用PDO，见dao/MyPDO.class.php

> 后台管理系统的产品更新与添加，需要上传图片，图片上传相关操作见fileupload/FileUpload.class.php

本系统的数据库设计详见 : 表设计.md
