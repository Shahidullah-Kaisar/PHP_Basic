<?php
require_once "../config/db.php";

$slug = $_GET['slug'] ?? '';
$stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE slug=?");
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);

if (!$post) die("Post not found");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($post['title']) ?> | Modern Blog</title>
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
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
    }
    
    .article-content {
      line-height: 1.8;
    }
    
    .article-content p {
      margin-bottom: 1.5rem;
    }
    
    .back-btn {
      transition: all 0.3s ease;
    }
    
    .back-btn:hover i {
      transform: translateX(-5px);
    }
    
    .hero-pattern {
      background-color: #6366f1;
      background-image: 
        radial-gradient(at 47% 33%, hsl(240.00, 84%, 71%) 0, transparent 59%), 
        radial-gradient(at 82% 65%, hsl(337.66, 89%, 61%) 0, transparent 55%);
    }
  </style>
</head>
<body class="min-h-screen py-12">
  <div class="max-w-4xl mx-auto px-4 md:px-6">
    <!-- Back button -->
    <a href="index.php" class="inline-flex items-center text-primary font-medium mb-8 back-btn">
      <i class="fas fa-arrow-left mr-2 transition-transform"></i> Back to all posts
    </a>

    <!-- Article header -->
    <div class="hero-pattern rounded-xl p-8 mb-8 text-white shadow-lg">
      <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-4"><?= htmlspecialchars($post['title']) ?></h1>
        <div class="flex items-center justify-center space-x-4 text-sm md:text-base">
          <span><i class="far fa-calendar mr-1"></i> <?= date('F j, Y', strtotime($post['created_at'])) ?></span>
          <span>•</span>
          <span><i class="far fa-clock mr-1"></i> <?= ceil(str_word_count(strip_tags($post['content'])) / 200) ?> min read</span>
        </div>
      </div>
    </div>

    <!-- Article content -->
    <article class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="p-6 md:p-8 lg:p-10 article-content">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
      </div>
      
      <!-- Article footer -->
      <div class="px-6 md:px-8 lg:px-10 py-6 bg-grayLight border-t border-gray-100">
        <div class="flex flex-col sm:flex-row items-center justify-between">
          <p class="text-gray text-sm mb-4 sm:mb-0">Hope you enjoyed this article</p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray hover:text-primary transition-colors">
              <i class="fab fa-twitter text-lg"></i>
            </a>
            <a href="#" class="text-gray hover:text-primary transition-colors">
              <i class="fab fa-facebook text-lg"></i>
            </a>
            <a href="#" class="text-gray hover:text-primary transition-colors">
              <i class="fab fa-linkedin text-lg"></i>
            </a>
          </div>
        </div>
      </div>
    </article>

    <!-- Related posts suggestion -->
    <!-- <div class="mt-12 text-center">
      <h2 class="text-2xl font-bold text-dark mb-6">More to read</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
          <div class="text-primary mb-3">
            <i class="fas fa-lightbulb text-2xl"></i>
          </div>
          <h3 class="font-semibold mb-2">Creative Thinking</h3>
          <p class="text-gray text-sm">Explore techniques to boost your creativity</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
          <div class="text-primary mb-3">
            <i class="fas fa-code text-2xl"></i>
          </div>
          <h3 class="font-semibold mb-2">Web Development</h3>
          <p class="text-gray text-sm">Latest trends in modern web development</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
          <div class="text-primary mb-3">
            <i class="fas fa-pen-fancy text-2xl"></i>
          </div>
          <h3 class="font-semibold mb-2">Writing Tips</h3>
          <p class="text-gray text-sm">Improve your writing skills with our guide</p>
        </div>
      </div>
      <a href="index.php" class="inline-block mt-8 px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primaryDark transition-colors">
        View all posts
      </a>
    </div>
  </div> -->

  <!-- Global footer -->
  <footer class="mt-16 pt-12 pb-8 text-center text-gray border-t border-gray-200">
    <div class="max-w-4xl mx-auto px-4">
      <div class="flex justify-center space-x-6 mb-6">
        <a href="#" class="text-gray hover:text-primary transition-colors">
          <i class="fab fa-twitter text-lg"></i>
        </a>
        <a href="#" class="text-gray hover:text-primary transition-colors">
          <i class="fab fa-instagram text-lg"></i>
        </a>
        <a href="#" class="text-gray hover:text-primary transition-colors">
          <i class="fab fa-github text-lg"></i>
        </a>
        <a href="#" class="text-gray hover:text-primary transition-colors">
          <i class="fab fa-linkedin text-lg"></i>
        </a>
      </div>
      <p class="text-sm">&copy; <?= date('Y') ?> Modern Blog. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>