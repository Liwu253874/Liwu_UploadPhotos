<?php
// 登录验证
session_start();

// 如果用户未登录，重定向到登录页面
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// 图片文件夹
$uploadDir = '../uploads/';

// 定义一个函数，用于递归获取所有图片文件
function getAllImages($dir, $uploadDir) {
    $images = [];
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . $file;
            if (is_dir($path)) {
                // 如果是目录，递归调用
                $images = array_merge($images, getAllImages($path . '/', $uploadDir));
            } else {
                // 如果是文件，检查扩展名是否为图片
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($ext, $allowed_extensions)) {
                    // 存储相对于 $uploadDir 的路径
                    $images[] = substr($path, strlen($uploadDir));
                }
            }
        }
    }
    return $images;
}

// 获取所有图片，并按时间倒序排序
$images = getAllImages($uploadDir, $uploadDir);

// 按文件修改时间排序（从新到旧）
usort($images, function($a, $b) use ($uploadDir) {
    return filemtime($uploadDir . $b) - filemtime($uploadDir . $a);
});
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <!-- 头部内容保持不变 -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>图片管理后台</title>
    <style>
       body {
            font-family: Arial, sans-serif;
        }
        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .image-container img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            cursor: pointer;
            position: relative;
        }
        .image-container img.lazyload {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .image-container img.lazyloaded {
            opacity: 1;
        }
        .login-info {
            text-align: center;
        }
        /* 显示图层 */
        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px;
            text-align: center;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .image-wrapper {
            position: relative;
            display: inline-block;
        }
        .image-wrapper:hover .overlay {
            opacity: 1;
        }
        /* 手机适配 - 屏幕小于600px时每行显示两张图片 */
        @media (max-width: 600px) {
            .image-container img {
                width: calc(50% - 10px);
            }
        }
    </style>
</head>
<body>
    <h1 class="login-info">欢迎进入图片管理后台</h1>
    <div class="image-container" id="imageContainer">
        <?php foreach ($images as $image): ?>
            <div class="image-wrapper">
                <img data-src="<?php echo $uploadDir . $image; ?>" class="lazyload" alt="图片" onclick="confirmDelete('<?php echo addslashes($image); ?>')">
                <div class="overlay">文件名: <?php echo htmlspecialchars($image); ?><br>上传时间: <?php echo date('Y-m-d H:i:s', filemtime($uploadDir . $image)); ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <script>
        // 确认是否删除图片
        function confirmDelete(imageName) {
            if (confirm('您确定要删除这张图片吗？')) {
                // 如果确认删除，发送请求到删除文件的脚本
                fetch('delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ image: imageName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('图片已删除');
                        location.reload(); // 刷新页面以更新图片列表
                    } else {
                        alert('删除失败: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>
