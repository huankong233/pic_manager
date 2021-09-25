# pic_manager
个人使用的漫画管理程序

# 计划
- [x] 1.简单的检索功能
- [x] 2.通过config.php自义定一些功能
- [x] 3.压缩下载漫画文件夹功能
- [x] 4.缩略图（需要手动打开GD库进行支持）
- [x] 5.图片压缩功能
- [x] 6.隐藏图片直连（使用转写base64格式，可能存在加载速度缓慢的问题）
- [x] 7.手机端预加载提示
- [x] 8.搜索漫画名称，分类功能（分类需要手动分类）
- [x] 9.添加自适应封面
- [ ] 10.收藏指定漫画
- [ ] 11.优化体验 etc... 

# config.php配置具体教程
1.漫画储存路径：
<pre>
    $res = "./pic";
    从config.php所在路径寻找该文件夹
</pre>
2.缓存路径：
<pre>
    $cache = "./cache";
    从config.php所在路径寻找该文件夹
</pre>
3.可以作为封面的文件
<pre>
    $cover = ['cover.jpg', 'cover.png', 'cover.jpeg', 'COVER.jpg', 'COVER.png', 'COVER.jpeg', 'COVER.JPG', 'COVER.JPEG', 'COVER.PNG', '1.jpg', '1.png', '1.jpeg', '01.jpg', '01.png', '01.jpeg', '1.JPG', '1.PNG', '1.JPEG','01.JPG', '01.PNG', '01.JPEG','0.jpg','0.jpeg','0.png','0.JPG','0.PNG','0.JPEG'];
    从$res文件夹下的漫画文件夹下寻找数组内的文件
</pre>
4.自动封面
<pre>
    $auto_cover = true;
    从config.php所在路径寻找该文件夹
</pre>
5.默认画质压缩比
<pre>
    $q=8;
    画质压缩，压缩比例是1-10
</pre>
6.读取的分类/标签文件名称
<pre>
    $classify = "classify.txt";
    从$res文件夹下的漫画文件夹下寻找名称为该字符串的文件
</pre>
7.读取的分类/标签文件名称
<pre>
    $cached_time = 30*60;
    缓存的压缩包多长时间后触发删除*(单位为秒，30分钟即设置值为30*60)
    *我这里触发删除的意思就是，下载一次会检测一次，没有人下载就一直不会检测~
</pre>
# 星星数量~
[![Stargazers over time](https://starchart.cc/huankong233/pic_manager.svg)](https://starchart.cc/huankong233/pic_manager)
