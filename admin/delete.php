<?php
header('Content-Type: application/json');

// 获取删除的图片文件名
$data = json_decode(file_get_contents('php://input'), true);
$image = $data['image'] ?? null;

if ($image) {
    $filePath = '../uploads/' . $image;

    // 检查文件是否存在并删除
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => '无法删除图片']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => '文件不存在']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '无效的请求']);
}
