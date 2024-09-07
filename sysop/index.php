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

// 获取图片列表并按时间排序
$images = array_diff(scandir($uploadDir, SCANDIR_SORT_DESCENDING), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
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
            <img data-src="<?php echo $uploadDir . $image; ?>" class="lazyload" alt="图片" onclick="confirmDelete('<?php echo $image; ?>')">
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
