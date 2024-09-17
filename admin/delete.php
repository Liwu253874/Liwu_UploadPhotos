<?php
session_start();
header('Content-Type: application/json');

// 验证用户是否已登录
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => '未授权的访问。']);
    exit();
}

// 获取删除的图片文件名
$data = json_decode(file_get_contents('php://input'), true);
$image = $data['image'] ?? null;

if ($image) {
    $uploadDir = realpath('../uploads/') . DIRECTORY_SEPARATOR;

    // 构建待删除文件的完整路径
    $filePath = realpath($uploadDir . $image);

    // 检查文件路径是否有效并防止目录遍历
    if ($filePath && strpos($filePath, $uploadDir) === 0 && is_file($filePath)) {
        // 检查文件扩展名是否为允许的图片格式
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed_extensions)) {
            // 尝试删除文件
            if (unlink($filePath)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => '无法删除图片。']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => '不允许删除此类型的文件。']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => '文件不存在或路径非法。']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '无效的请求。']);
}
?>
