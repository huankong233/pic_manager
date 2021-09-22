<?php
    require_once '../config.php';
    //删除超时文件
    $list = scandir('.' . $cache);
    $time = time();
    for ($i = 0; $i <= count($list) - 1; $i++) {
        $zip_file = '.' . $cache . '/' . $list[$i];
        if ($list[$i] !== '.' && $list[$i] !== '..') {
            if (filectime($zip_file) + 60*30 - $time <= 0) {
                var_dump($zip_file);
                unlink($zip_file);
            }
        }
    }

    //判断是否下载的是漫画文件夹
    @$name = $_GET['name'];
    $res = '.' . $res;
    if (is_dir($res)) {
        $list = scandir($res);
    } else {
        die('漫画储存路径无法访问或不存在！');
    }

    if (in_array($name, $list)) {
        $zip = new \ZipArchive;
        $file_path = '../cache/' . $name . '-' . uniqid() . '-' . time() . '.zip';
        if ($zip->open($file_path, \ZipArchive::CREATE) === true) {
            $zip->addFile('../转载声明.txt', '转载声明.txt');
            $path = $res . '/' . $name;
            $book = scandir($path);
            for ($i = 0; $i <= count($book) - 1; $i++) {
                if ($book[$i] !== '.' && $book[$i] !== '..') {
                    $img_path = $res . '/' . $name . '/' . $book[$i];
                    $zip->addFile($img_path, $name . '/' . $book[$i]);
                }
            }
            $zip->close();
        }

        //使用只读的方式打开文件
        $handle = fopen($file_path, 'rb');
        //告诉浏览器内容类型为：八位二进制数据流
        header('Content-Type:application/octet-stream');
        //告诉浏览器储存数据的方式为附件，并保存
        header("Content-Disposition:attachment;filename=$name.zip");
        //循环取出文件数据
        while ($str = fread($handle, 1024)) {
            //数据返回给客户端
            echo $str;
        }
    } else {
        die('漫画不存在');
    }