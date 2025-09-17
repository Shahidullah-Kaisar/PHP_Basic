<?php
require_once "../config/db.php";
$result = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Blog | Thoughtful Content</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6366f1',
            primaryDark: '#4f46e5',
            secondary: '#f43f5e',
            dark: '#1e293b',
            light: '#f8fafc',
            gray: '#64748b',
            grayLight: '#e2e8f0',
          }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    body {
      font-family: 'Inter', sans-serif;
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    
    .post-card {
      transition: all 0.3s ease;
    }
    
    .post-card:hover {
      transform: translateY(-5px);
    }
    
    .title-underline {
      position: relative;
      display: inline-block;
    }
    
    .title-underline::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 5px;
      background: #f43f5e;
      border-radius: 5px;
    }
    
    .post-image {
      background: linear-gradient(120deg, #6366f1 0%, #f43f5e 100%);
    }
    
    .read-more-arrow {
      transition: transform 0.3s ease;
    }
    
    .read-more:hover .read-more-arrow {
      transform: translateX(5px);
    }
    
    .header-circle-1 {
      position: absolute;
      top: -50px;
      right: -80px;
      width: 150px;
      height: 150px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(244, 63, 94, 0.1) 100%);
      z-index: -1;
    }
    
    .header-circle-2 {
      position: absolute;
      bottom: -30px;
      left: -60px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(244, 63, 94, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
      z-index: -1;
    }
  </style>
</head>
<body class="gradient-bg min-h-screen">
  <div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <header class="text-center mb-12 relative">
      <div class="inline-block relative">
        <div class="header-circle-1"></div>
        <div class="header-circle-2"></div>
        <h1 class="text-4xl md:text-5xl font-bold text-dark mb-2 title-underline">Modern Thoughts</h1>
        <p class="text-xl text-gray mt-4">Exploring ideas, creativity and innovation</p>
      </div>
    </header>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
      <?php while ($post = mysqli_fetch_assoc($result)): ?>
        <div class="post-card bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl flex flex-col h-full">
          <div class="post-image h-48 flex items-center justify-center text-white text-6xl">
            <i class="fas fa-feather-alt"></i>
          </div>
          <div class="p-6 flex flex-col flex-grow">
            <h2 class="text-xl font-bold text-dark mb-3">
              <a href="post.php?slug=<?= $post['slug'] ?>" class="hover:text-primaryDark transition-colors duration-300">
                <?= htmlspecialchars($post['title']) ?>
              </a>
            </h2>
            <p class="text-gray flex-grow mb-4"><?= substr(htmlspecialchars($post['content']), 0, 150) ?>...</p>
            <div class="flex justify-between items-center pt-4 border-t border-grayLight">
              <span class="text-sm text-gray"><i class="far fa-calendar mr-1"></i> <?= date('M j, Y', strtotime($post['created_at'])) ?></span>
              <a href="post.php?slug=<?= $post['slug'] ?>" class="read-more text-primary font-semibold flex items-center">
                Read more <i class="fas fa-arrow-right read-more-arrow ml-2"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-16 py-8 text-gray border-t border-grayLight">
      <p>&copy; <?= date('Y') ?> Modern Thoughts. All rights reserved.</p>
    </footer>
  </div>
</body>
</html>