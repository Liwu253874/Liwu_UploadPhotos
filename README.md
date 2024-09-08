# Liwu_UploadPhotos
 一个简单的本地开放上传图片的图床项目，有简洁的前台页面和后台管理

## 项目简介

本项目是一个简单易用的本地图片上传系统，用户可以通过拖拽、文件选择、粘贴（`Ctrl+v`）等方式上传图片，并自动生成图片链接用于展示。该系统适用于个人或团队快速搭建的图片上传平台，具有简洁的前台和管理后台，提供图片上传、预览、粘贴上传、图片管理等功能。

2024年9月6号起telegra.ph禁止了上传媒体文件，曾经一直使用的里屋社区图床工具被终结。之前试过各种图床工具都太过于复杂，或者也非常不稳定。遂决定自己做一个极简的基于本地上传的图床工具。

本图床不提供图片列表，上传的图片仅在上传后给出图片地址。这样可以最大限度的减少爬虫带来的风险。

也没有用户帐户系统，最大想限度的方便普通用户随时使用。

图床提供了简单的懒加载的后台管理。图床所有者可以随时翻阅和管理（删除）图床内的图片。


## 功能特点

- **多种图片上传方式**：
  - 支持通过文件选择按钮上传图片。
  - 支持用户通过拖拽方式上传图片（如果需要拓展）。
  - 支持用户通过复制粘贴（`Ctrl+v`）上传剪贴板中的图片。
  
- **图片懒加载**：前台图片预览和后台管理均使用懒加载技术，提升页面加载性能。
  
- **后台管理**：
  - 图片管理后台支持查看已上传的图片。
  - 通过手机、平板和桌面端适配，每行显示的图片数量会根据设备不同进行调整。
  - 点击图片时，用户可以选择删除该图片，并在确认后执行删除操作。
  
- **安全登录机制**：后台管理页面需要账号和密码登录，确保图片管理的安全性。

## 项目结构

```bash
project/
│
├── admin/               # 后台管理页面
│   ├── index.php        # 图片管理主页面
│   ├── login.php        # 登录页面
│   └── delete.php       # 删除图片的处理脚本
│
├── uploads/             # 图片上传目录
│
├── index.php            # 前台图片上传页面
├── upload.php           # 图片上传处理脚本
└── README.md            # 项目简介文档
```

## 安装与配置

1. **克隆或下载项目代码**
   - 可以将项目代码克隆到本地或者上传到服务器上：
   
   ```bash
   git clone https://github.com/Liwu253874/Liwu_UploadPhotos.git
   ```

2. **配置上传目录**
   - 确保 `/uploads/` 目录存在，并具有写入权限。可以通过以下命令设置写权限：
   
   ```bash
   chmod 777 uploads/
   ```

3. **运行 **
   访问指向根目录的域名即可。

## 使用说明

### 1. 前台图片上传页面

- 访问 `http://[yourdomain.com]/` 进入前台图片上传页面。
- 用户可以通过以下几种方式上传图片：
  - 通过文件选择按钮选择本地图片文件进行上传。
  - 将图片粘贴（`Ctrl+V`）到页面上，系统会自动检测剪贴板中的图片并上传。
- 图片上传后，页面会显示上传成功的图片链接，用户可以复制该链接进行分享或使用。

### 2. 后台图片管理页面

- 访问 `http://[yourdomain.com]/admin/` 进入图片管理后台。
- 用户需要输入账号和密码进行登录，默认账号和密码如下：
  - 用户名：`admin`
  - 密码：`abc123`
- 登录后可以看到已上传的图片，图片按时间顺序显示，点击图片可以选择删除。

### 3. 删除图片

- 在后台管理页面，点击图片后，会弹出确认删除的提示框，用户确认后即可删除该图片，删除后图片无法恢复。

## 技术细节

- **前端技术**：
  - 使用 `HTML5` 和 `CSS3` 构建页面结构和样式。
  - 使用 `JavaScript` 进行用户交互、文件上传和粘贴图片处理。
  - 通过 `lazysizes` 库实现图片懒加载。
  - 使用 `Bootstrap` 进行简单的页面布局和按钮样式美化。
  
- **后端技术**：
  - 使用 `PHP` 处理图片上传、删除等操作。
  - 使用会话控制用户的后台登录。

## 未来优化方向

- **拖拽上传**：目前支持文件选择和粘贴上传，可以进一步拓展为支持拖拽上传功能。
- **文件类型和大小限制**：可以进一步完善图片文件类型检查及大小限制，避免上传不符合规范的文件。
- **用户认证**：当前登录系统较为简单，可以考虑通过更复杂的用户认证系统来增加安全性。
