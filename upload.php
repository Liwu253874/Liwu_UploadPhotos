<?php
// 引入配置文件
include 'config.php'; 

// 获取当前年份和月份，格式为 YYYYMM，例如 202409
$current_month = date('Ym');

// 设置目标目录为 uploads/当前年月/
$target_dir = "uploads/" . $current_month . "/";

// 如果目录不存在，创建目录
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// 生成当前日期格式和随机的6位字符串作为文件名
$date = date('Ymd');
$random_str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
$new_filename = $date . $random_str . "." . $imageFileType;
$target_file = $target_dir . $new_filename;

// 检查文件是否为图片
if (isset($_FILES["fileToUpload"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo json_encode(['success' => false, 'message' => '文件不是图片。']);
        $uploadOk = 0;
    }
}

// 检查文件是否已存在
if (file_exists($target_file)) {
    echo json_encode(['success' => false, 'message' => '抱歉，文件已存在。']);
    $uploadOk = 0;
}

// 检查文件大小
if ($_FILES["fileToUpload"]["size"] > 5000000) { // 5MB 大小限制
    echo json_encode(['success' => false, 'message' => '文件太大了，不能超过5MB。']);
    $uploadOk = 0;
}

// 允许上传的文件格式
$allowed_extensions = array("jpg", "jpeg", "png", "gif", "webp");
if (!in_array($imageFileType, $allowed_extensions)) {
    echo json_encode(['success' => false, 'message' => '仅允许 JPG, JPEG, PNG, GIF, WEBP 文件格式。']);
    $uploadOk = 0;
}

// 如果检查通过，进行文件上传
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // 使用 $base_url 变量来构建图片的完整 URL
        $imageUrl = $base_url . "/" . $target_file;

        // 去掉“uploads/”这一部分路径
        $relativePath = str_replace("uploads/", "", $target_file);

        // 构建展示用的域名URL
        $displayImageUrl = $display_url . "/" . $relativePath;

        // 返回使用新域名且无“uploads”路径的 URL
        echo json_encode(['success' => true, 'imageUrl' => $displayImageUrl]);
    } else {
        echo json_encode(['success' => false, 'message' => '上传过程中出现错误。']);
    }
}
?>
