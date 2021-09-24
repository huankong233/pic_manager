<?php
    @$scale = $_GET['q']/10;
    @$path = $_GET['path'];
    if (isset($path) && isset($scale)){
        if (!file_exists($path)) {
            $path = '.' . $path;
            if (!file_exists($path)) {
                die('接口使用错误：路径错误或文件不存在');
            }
        }

        $allow_type = ['image/jpeg', 'image/png', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        @$type = finfo_file($finfo, $path);
        //压缩的文件
        if ($type == 'image/jpeg') {
            $src_img = imagecreatefromjpeg($path);
        } else if ($type == 'image/png') {
            $src_img = imagecreatefrompng($path);
        } else if ($type == 'image/gif') {
            $src_img = imagecreatefromgif($path);
        } else {
            die('接口使用错误：文件非允许压缩格式');
        }
        //获取宽高
        $src_w = imagesx($src_img);
        $src_h = imagesy($src_img);
        //创建的画布
        $dst_w = $src_w * $scale;
        $dst_h = $src_h * $scale;
        $dst_img = imagecreatetruecolor($dst_w,$dst_h);
        imagecopyresampled($dst_img,$src_img,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
        header('Content-type:image/png');
        imagepng($dst_img);
        //销毁画布
        imagedestroy($dst_img);
        imagedestroy($src_img);
    }else{
        die('接口使用错误：路径未填写或压缩质量未填写');
    }


