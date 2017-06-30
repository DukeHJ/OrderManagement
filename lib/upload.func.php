<?php
/**
 * 构建文件上传数组
 * @return mixed
 */
function buildInfo()
{
    $i = 0;
    foreach ($_FILES as $fileInfo) {
        if (is_string($fileInfo['name'])) {
            $files[$i] = $fileInfo;
            $i++;
        } else {
            foreach ($fileInfo as $key => $val) {
                foreach ($val as $k => $v) {
                    $files[$k][$key] = $v;
                }
            }
        }
    }
    return $files;
}

/**
 * 文件上传
 * @param $fileInfo
 * @param array $allowExt
 * @param int $maxSize
 */

function uploadFile($path = "uploads", $allowExt = array("gif", "jpg", "xls", "pdf"), $maxSize = 2097152)
{
    $mes = '';
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
$i=0;
    $files = buildInfo();
    foreach ($files as $fileInfo) {
        if ($fileInfo['error'] == UPLOAD_ERR_OK) {
            $ext = getExt($fileInfo['name']);
            if (!in_array($ext, $allowExt)) {
                exit("非法文件类型");
            }

            //判断文件真是扩展名？？？？？？？？？？？
            if ($fileInfo['size'] > $maxSize) {
                exit ("上传文件过大");
            }
            if (!is_uploaded_file($fileInfo['tmp_name'])) {
                exit("不是通过HTTP POST方式上传上来的");
            }
            $filename = getUniName() . "." . $ext;
            $destination = $path . "/" . $filename;
            if (move_uploaded_file($fileInfo['tmp_name'], $destination)) {
                $fileInfo['name']=$filename;
                unset($fileInfo['error'],$fileInfo['tmp_name'],$fileInfo['size'],$fileInfo['type']);
                $uploadFiles[$i]=$fileInfo;
                $i++;
            }
        } else {
            switch ($fileInfo['error']) {
                case 1:
                    $mes = "超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                    break;
                case 2:
                    $mes = "超过了表单配置上传文件的大小";//UPLOAD_ERR_FORM_SIZE
                    break;
                case 3:
                    $mes = "文件部分被上传";//UPLOAD_ERR_PARTIAL
                    break;
                case 4:
                    $mes = "没有文件被上传";//UPLOAD_ERR_NO_FILE
                    break;
                case 6:
                    $mes = "没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                    break;
                case 7:
                    $mes = "文件不可写";//UPLOAD_ERR_CANT_WRITE
                    break;
                case 8:
                    $mes = "由于PHP的扩展程序";//UPLOAD_ERR_EXTENSION
                    break;
            }
        }
    }
    return $uploadFiles;
}




























