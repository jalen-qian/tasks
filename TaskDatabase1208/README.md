##数据库练习与作业
###第一题
* 1.建立通讯录库
```sql
CREATE DATABASE addr_book;
```
* 2.建立员工表
```sql
CREATE TABLE staff(
id INT(4) AUTO_INCREMENT COMMENT '员工id',
deparId INT(4) NOT NULL DEFAULT 0 COMMENT '所在部门id',
jobId INT(4) NOT NULL DEFAULT 0 COMMENT '职位id',
familyAddr varchar(255) NOT NULL DEFAULT '' COMMENT '家庭住址',
phone varchar(11) NOT NULL DEFAULT '' COMMENT '电话号码',
eMail varchar(80) NOT NULL DEFAULT '' COMMENT '电子邮箱',
PRIMARY KEY (id));
```
* 3.建立部门表
```sql
CREATE TABLE IF NOT EXISTS department(
id INT(4) AUTO_INCREMENT COMMENT '部门id',
deparName varchar(30) NOT NULL DEFAULT '' COMMENT '部门名称',
PRIMARY KEY (id));
```
* 4.建立职位表
```sql
CREATE TABLE IF NOT EXISTS job(
id INT(4) AUTO_INCREMENT COMMENT '职位id',
jobName varchar(30) NOT NULL DEFAULT '' COMMENT '职位名称',
PRIMARY KEY (id));
```

###第二题
* 1.创建学生数据库 stuDb;
```sql
CREATE DATABASE stuDb;
```

* 2.创建一张学生表，包含以下信息，学号，姓名，年龄，性别，家庭住址，联系电话
```sql
CREATE TABLE IF NOT EXISTS students(
   stuNo INT(4) UNSIGNED AUTO_INCREMENT COMMENT '学号',
   name VARCHAR(30) NOT NULL DEFAULT '' COMMENT '姓名',
   birthday INT(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '出生日期',
   sex INT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别 0 表示男 1表示女',
   familyAddr VARCHAR(255) NOT NULL DEFAULT '' COMMENT '家庭住址',
   phone CHAR(11) NOT NULL DEFAULT '' COMMENT '联系电话',
   PRIMARY KEY(stuNo));
```

* 3.修改学生表的结构，添加一列信息，学历

```sql
ALTER TABLE students ADD education VARCHAR(20) NOT NULL DEFAULT '' COMMENT '学历';

```

* 4.修改学生表的结构，删除一列信息，家庭住址 

```sql
ALTER TABLE students DROP familyAddr;
```

* 5.向学生表添加数据

```sql
INSERT INTO students VALUES
('1','A','787939200','0','123456','小学'),
('2','B','819475200','0','119','中学'),
('3','C','756489600','0','110','高中'),
('4','D','914169600','1','114','大学');
```

* 6.修改学生表的数据，将电话号码以11开头的学员的学历改为“大专” 

```sql
UPDATE students set education = '大专' where phone like '11%';

```

* 7.删除学生表的数据，姓名以C开头，性别为‘男’的记录删除 

```sql
DELETE FROM students WHERE name like 'C%' AND sex = '0';
```

* 8.查询学生表的数据，将所有年龄小于22岁的，学历为“大专”的，学生的姓名和学号示出来

```sql
SELECT name,stuNo FROM students WHERE birthday > 787996829;
```
查询结果如下：
<pre>
+------+-------+
| name | stuNo |
+------+-------+
| B    |     2 |
| D    |     4 |
+------+-------+
</pre>

*  9.查询学生表的数据，查询所有信息，列出前25%的记录 

 - 分析：要查询出前25%的数据，需要使用关键字 limit，而不能用 id < xxx的方式，因为id可能不是和行数等同的，我们是要查出行数 在 前25%的数据。
比如：select * from tableName limit 10; 就是查询前10条数据
前 25% 可以用ceil 如 ceil((select count(*) from students)*0.25);来获取。
所以SQL如下：

```sql
PREPARE selectStmt FROM 'SELECT * FROM students limit ?';
set @a = ceil((select count(*) from students)*0.25);
EXECUTE selectStmt USING @a;
```
- 查询结果如下：
<pre>
+-------+--------+-----------+-----+-------------+-----------+
| stuNo | name   | birthday  | sex | phone       | education |
+-------+--------+-----------+-----+-------------+-----------+
|     1 | A      | 787939200 |   0 | 123456      | 小学      |
|     5 | 小明   | 787939200 |   0 | 18825641254 | 本科      |
|     6 | 小鸿   | 819475200 |   1 | 1882541125  | 硕士      |
|     7 | 小雅   | 787939200 |   1 | 18825642453 | 本科      |
+-------+--------+-----------+-----+-------------+-----------+
</pre>

* 10.查询出所有学生的姓名，性别，年龄降序排列
说明：因为用的时间搓存的出生日期，所以这里用FROM_UNIXTIME()函数转成年龄,降序排列加上`desc`
```sql
 SELECT name,sex,(2016 - FROM_UNIXTIME(birthday, '%Y')) as age FROM students ORDER BY age desc;
```
- 查询结果如下：
<pre>
+--------+-----+------+
| name   | sex | age  |
+--------+-----+------+
| A      |   0 |   22 |
| 小明   |   0 |   22 |
| 小雅   |   1 |   22 |
| 小强   |   0 |   22 |
| 小明   |   0 |   22 |
| 小雅   |   1 |   22 |
| 小强   |   0 |   22 |
| 小鸿   |   1 |   21 |
| B      |   0 |   21 |
| 小鸿   |   1 |   21 |
| 小芬   |   1 |   18 |
| D      |   1 |   18 |
| 小芬   |   1 |   18 |
+--------+-----+------+
</pre>

* 11.按照性别分组查询出所有的平均年龄
 MySQL中分组用GROUP BY，求平局值用AVG函数，SQL语句和结果如下：

```sql
SELECT sex,AVG(2016 - FROM_UNIXTIME(birthday, '%Y')) AS 平均年龄 FROM students GROUP BY sex;
```
<pre>
+-----+--------------+
| sex | 平均年龄      |
+-----+--------------+
|   0 |      21.8333 |
|   1 |      20.0000 |
+-----+--------------+
</pre>

###第三题
* 1.建立管理岗位数据库`CREATE DATABASE manageDb;`
* 2.建立三个表：user(userNo,userName,currentUnit,age) userNo,userName,currentUnit,age 分别代表学号、学员姓名、所属单位、学员年龄
course(courseNo,courseName)ourseNo,courseName 分别代表课程编号、课程名称
point(userNo,courseNo,grade ) userNo,courseNo,point分别代表学号、所选修的课程编号、学习成绩
```sql
CREATE TABLE IF NOT EXISTS user(
userNo varchar(30) NOT NULL COMMENT '学号',
userName varchar(30) NOT NULL DEFAULT '' COMMENT '学生姓名',
currentUnit varchar(30) NOT NULL DEFAULT '' COMMENT '所属单位',
age INT(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '学院年龄',
PRIMARY KEY (userNo));

CREATE TABLE IF NOT EXISTS course(
courseNo varchar(30) NOT NULL COMMENT '课程编号',
courseName varchar(30) NOT NULL DEFAULT '' COMMENT '课程名称',
PRIMARY KEY (courseNo));

CREATE TABLE IF NOT EXISTS point(
pointId INT(4) AUTO_INCREMENT COMMENT '成绩编号',
userNo varchar(30) DEFAULT '' COMMENT '学号',
courseNo varchar(30) NOT NULL DEFAULT '' COMMENT '课程编号',
grade FLOAT(4,2) NOT NULL DEFAULT 0.0 COMMENT '成绩',
PRIMARY KEY (pointId));
```
* 3.使用标准SQL嵌套语句查询选修课程名称为’税收基础’的学员学号和姓名
```sql
SELECT userNo,userName FROM user
WHERE userNo in(
   SELECT userNo FROM course,point WHERE course.courseName = '税收基础'
);
```
查询结果如下：
<pre>
+----------+----------+
| userNo   | userName |
+----------+----------+
| 223453aa | 小明     |
| 223453bb | 小敏     |
+----------+----------+
</pre>

* 4.使用标准SQL嵌套语句查询选修课程编号为’C2’的学员姓名和所属单位
```sql
SELECT userName,currentUnit FROM user
WHERE userNo in (
   SELECT userNo FROM point WHERE courseNo = 'C2'
);
```
查询结果如下：
<pre>
+----------+-------------+
| userName | currentUnit |
+----------+-------------+
| 小敏     | 学术部      |
+----------+-------------+
</pre>

* 5.使用标准SQL嵌套语句查询**不选修课程编号为'C5'**的学员姓名和所属单位
```sql
SELECT userName,currentUnit FROM user
WHERE userNo in (
   SELECT userNo FROM point WHERE courseNo != 'C5'
);
```
查询结果如下：
<pre>
+----------+-------------+
| userName | currentUnit |
+----------+-------------+
| 小明     | 技术部      |
| 小敏     | 学术部      |
+----------+-------------+
</pre>

* 6.使用标准SQL嵌套语句查询**选修全部课程的学员姓名和所属单位**
```sql
SELECT userName,currentUnit FROM user WHERE NOT EXISTS (
    SELECT * FROM course WHERE NOT EXISTS(
    SELECT * FROM point WHERE userNo = user.userNo AND courseNo = course.courseNo);
```

* 7.选修了课程的学员人数
```sql
SELECT COUNT(*) FROM user WHERE userNo IN(
   select userNo from point
);
```

* 8.查询选修课程超过5门的学员学号和所属单位
```sql
SELECT userNo,currentUnit FROM user WHERE userNo in(
    SELECT userNo FROM point group by point.userNo having count(courseNo) > 5
);
```

