<?php
    //默认漫画储存路径
    $res = "./pic";
    //缓存目录
    $cache = "./cache";
    //可以作为封面的文件
    $cover = ['cover.jpg', 'cover.png', 'cover.jpeg', 'COVER.jpg', 'COVER.png', 'COVER.jpeg', 'COVER.JPG', 'COVER.JPEG', 'COVER.PNG', '1.jpg', '1.png', '1.jpeg', '01.jpg', '01.png', '01.jpeg', '1.JPG', '1.PNG', '1.JPEG','01.JPG', '01.PNG', '01.JPEG','0.jpg','0.jpeg','0.png','0.JPG','0.PNG','0.JPEG'];
    //若无法获取或者不存在封面，自动使用第一个图片作为封面
    $auto_cover = false;
    //默认画质比
    $q = 8;
    //分类文件名称
    $classify = "classify.txt";
    //多长时间后删除(单位为秒，30分钟即设置值为30*60)
    $cached_time = 30*60;
    //转换为base64格式
    $to_base64 = false;