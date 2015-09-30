-- MySQL dump 10.13  Distrib 5.1.48, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: qdm10749854_db
-- ------------------------------------------------------
-- Server version	5.1.48-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `zhx_album`
--

DROP TABLE IF EXISTS `zhx_album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zhx_album` (
  `iid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`iid`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zhx_album`
--

LOCK TABLES `zhx_album` WRITE;
/*!40000 ALTER TABLE `zhx_album` DISABLE KEYS */;
INSERT INTO `zhx_album` VALUES (20,45,'8be58819164fbb5f212386c254bde066.png'),(11,15,'9b62452ajw1euoetpqy2jj20c10bitat.jpg'),(19,44,'a5b058530c9b4750b114044aabcb2848.png'),(21,51,'613c1e27611c92b49c8d6c8b22e71b76.png'),(22,52,'9c69503ad987e44924d93193f079e888.png'),(23,53,'0d2c7f064b8bcd16adfd9835f303304f.png'),(36,99,'0d297a27c8b1c69fc7127b26a579a8d9.png'),(34,92,'d61bb21da066ac45884f83860bff74e2.jpg'),(39,106,'a9fd9e23dfe9fb512caaf492ed9f706e.png');
/*!40000 ALTER TABLE `zhx_album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zhx_comment`
--

DROP TABLE IF EXISTS `zhx_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zhx_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zhx_comment`
--

LOCK TABLES `zhx_comment` WRITE;
/*!40000 ALTER TABLE `zhx_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `zhx_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zhx_like`
--

DROP TABLE IF EXISTS `zhx_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zhx_like` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zhx_like`
--

LOCK TABLES `zhx_like` WRITE;
/*!40000 ALTER TABLE `zhx_like` DISABLE KEYS */;
INSERT INTO `zhx_like` VALUES (4,91,1),(5,92,1),(13,98,1),(14,99,1),(18,109,1);
/*!40000 ALTER TABLE `zhx_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zhx_notify`
--

DROP TABLE IF EXISTS `zhx_notify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zhx_notify` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `nuid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `type` enum('like','comment') NOT NULL,
  `readed` enum('1','0') NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zhx_notify`
--

LOCK TABLES `zhx_notify` WRITE;
/*!40000 ALTER TABLE `zhx_notify` DISABLE KEYS */;
INSERT INTO `zhx_notify` VALUES (6,1,1,91,'like','1','2015-08-21 05:13:40'),(7,1,1,92,'like','1','2015-08-21 05:15:15'),(18,1,1,98,'like','1','2015-08-21 08:10:53'),(19,1,1,99,'like','1','2015-08-22 01:18:17'),(25,1,1,109,'like','1','2015-08-24 10:47:05');
/*!40000 ALTER TABLE `zhx_notify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zhx_post`
--

DROP TABLE IF EXISTS `zhx_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zhx_post` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `post` text NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zhx_post`
--

LOCK TABLES `zhx_post` WRITE;
/*!40000 ALTER TABLE `zhx_post` DISABLE KEYS */;
INSERT INTO `zhx_post` VALUES (15,1,'2015-08-11 10:10:44','哈哈，大功告成！加上图片感觉内容丰富多了！'),(13,1,'2015-08-10 18:02:58','可以发记录啦！好的开始是成功的一半，加油哦！'),(14,1,'2015-08-11 08:15:43','想加入发图片的功能，貌似还需要多建一个表，用来存储图片名和对应的记录id'),(16,1,'2015-08-11 14:27:13','给用户上传的头像自动生成了一个50*50的缩略图，这样页面加载速度应该会快一些吧。'),(18,1,'2015-08-11 16:35:02','预防了下sql注入，还处理了其他的一些安全问题'),(49,1,'2015-08-12 20:38:12','想加上评论和点赞的功能，实现起来也该也不会太难，但怎么觉得越来越像个社交网站了？算了，还是不要了吧'),(44,1,'2015-08-11 21:48:23','给注册页面加上了验证码功能，点击图片还可以更换验证码（能发图片就是有用纳～～～）'),(45,1,'2015-08-12 09:16:54','从商城项目里直接拿来了翻页的代码，把代码封装成函数就是方便，还把外观修改了下，有没有十年后的影子呢？哈哈'),(46,1,'2015-08-12 11:49:13','加了个查看他人的页面，就是吧自己页面里的记录框换成目标用户的个人信息，然后再把记录发布日期旁边的删除按钮去掉就可以了，蛮简单的嘛～～'),(48,1,'2015-08-12 16:23:42','顶部导航栏添加了一个发现页面的连接，可以看到最新注册的用户，还有网站最新的记录'),(69,1,'2015-08-14 00:04:29','传到服务器上又出现一大堆问题，现在才算调试好，这么晚还没睡，明天５点多还怎么起得来再出去锻炼啊.'),(68,1,'2015-08-13 10:57:32','简单的做了下前端的美化工作，看起来顺眼多了，之后有时间了再加一些js代码实现一些更棒的效果．'),(97,1,'2015-08-16 18:23:46','登录和注册页面的代码整理完毕，上传到了服务器，测试确定之前的登录bug已修复'),(109,1,'2015-08-24 18:36:01','模仿新浪微博，把记录的时间和当前时间做了个对比，显示出几天前，几小时前，几秒前这类比较方便读的时间格式，鼠标放上去还可以显示原始格式的时间戳．'),(92,1,'2015-08-15 18:20:35','重新构思了下这个程序，列出了需要的所有文件夹，文件，还有某些文件里包含的函数。想再加几个功能，修改个人信息，评论和喜欢某条记录。'),(98,1,'2015-08-17 15:43:12','个人页面，发现页面，浏览他人页面代码整理完毕！'),(99,1,'2015-08-18 20:07:17','点赞和评论功能实现了！'),(100,1,'2015-08-19 13:08:36','写了一个更改用户信息的功能，可以更改头像，用户名以及密码，点击导航栏的用户头像即可打开该页面'),(103,1,'2015-08-20 12:13:54','才发现评论和赞的功能实现起来并不太难，但要这两个功能有了以后，就必须加上一个消息提醒的功能，而这个功能做起来确实有些费脑子诶...'),(107,1,'2015-08-21 14:45:20','把程序传到服务器上来测试，竟然没有出现任何报错信息，看来整洁的代码连服务器都喜欢纳，哈哈．'),(106,1,'2015-08-21 14:24:26','想好了实现思路后，开始建表，写function，写页面然后稍微调整了下前端，终于把提醒功能给做出来了．由于有分页功能，点击消息页面的记录链接后跳转到指定页数并且展开评论框着实费了不少力气才成功，');
/*!40000 ALTER TABLE `zhx_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zhx_user`
--

DROP TABLE IF EXISTS `zhx_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zhx_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `regTime` datetime NOT NULL,
  `avatar` varchar(64) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zhx_user`
--

LOCK TABLES `zhx_user` WRITE;
/*!40000 ALTER TABLE `zhx_user` DISABLE KEYS */;
INSERT INTO `zhx_user` VALUES (1,'hardi','dddb1b27f1a7d7601a6a0f7e2ca92926','2015-08-13 18:56:31','hardi_avatar.jpg');
/*!40000 ALTER TABLE `zhx_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'qdm10749854_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-14 16:26:59
