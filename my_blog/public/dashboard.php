<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Blog Management</title>
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
            success: '#10b981',
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
      background-color: #f8fafc;
    }
    
    .dashboard-card {
      transition: all 0.3s ease;
    }
    
    .dashboard-card:hover {
      transform: translateY(-3px);
    }
    
    .sidebar {
      transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        position: fixed;
        z-index: 50;
        height: 100vh;
      }
      
      .sidebar.open {
        transform: translateX(0);
      }
      
      .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
      }
      
      .overlay.open {
        display: block;
      }
    }
  </style>
</head>
<body class="min-h-screen bg-gray-50">
  <!-- Mobile menu button -->
  <div class="lg:hidden fixed top-4 left-4 z-50">
    <button id="menuToggle" class="p-2 rounded-md bg-primary text-white">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <!-- Overlay for mobile -->
  <div id="overlay" class="overlay"></div>

  <div class="flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar w-64 bg-dark text-white min-h-screen p-4 fixed lg:relative">
      <div class="p-4 mb-8">
        <h1 class="text-2xl font-bold">Blog Admin</h1>
        <p class="text-gray-400 text-sm">Content Management System</p>
      </div>
      
      <nav class="mb-8">
        <ul>
          <li class="mb-2">
            <a href="#" class="flex items-center p-3 rounded-lg bg-primary text-white">
              <i class="fas fa-th-large mr-3"></i> Dashboard
            </a>
          </li>
          <li class="mb-2">
            <a href="create_post.php" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700">
              <i class="fas fa-plus-circle mr-3"></i> Create Post
            </a>
          </li>
          <li class="mb-2">
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700">
              <i class="fas fa-users mr-3"></i> Users
            </a>
          </li>
          <li class="mb-2">
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700">
              <i class="fas fa-cog mr-3"></i> Settings
            </a>
          </li>
        </ul>
      </nav>
      
      <div class="mt-auto pt-8 border-t border-gray-700">
        <a href="logout.php" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700">
          <i class="fas fa-sign-out-alt mr-3"></i> Logout
        </a>
      </div>
    </div>

    <!-- Main content -->
    <div class="flex-1 lg:ml-0 p-6">
      <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
          <div>
            <h2 class="text-2xl font-bold text-dark">Manage Blog Posts</h2>
            <p class="text-gray">Create, edit and manage your content</p>
          </div>
          <a href="create_post.php" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primaryDark transition-colors">
            <i class="fas fa-plus-circle mr-2"></i> New Post
          </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-blue-100 text-primary mr-4">
                <i class="fas fa-file-alt"></i>
              </div>
              <div>
                <p class="text-gray text-sm">Total Posts</p>
                <h3 class="text-2xl font-bold"><?= mysqli_num_rows($result) ?></h3>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-green-100 text-success mr-4">
                <i class="fas fa-check-circle"></i>
              </div>
              <div>
                <p class="text-gray text-sm">Published</p>
                <h3 class="text-2xl font-bold"><?= mysqli_num_rows($result) ?></h3>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
              <div class="p-3 rounded-full bg-amber-100 text-amber-500 mr-4">
                <i class="fas fa-clock"></i>
              </div>
              <div>
                <p class="text-gray text-sm">Drafts</p>
                <h3 class="text-2xl font-bold">0</h3>
              </div>
            </div>
          </div>
        </div>

        <!-- Posts -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
          <div class="border-b border-grayLight px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-medium">All Posts</h3>
            <div class="relative">
              <input type="text" placeholder="Search posts..." class="pl-10 pr-4 py-2 border border-grayLight rounded-lg text-sm">
              <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray"></i>
            </div>
          </div>
          
          <div class="divide-y divide-grayLight">
            <?php while ($post = mysqli_fetch_assoc($result)): ?>
            <div class="dashboard-card p-6 hover:bg-gray-50">
              <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="mb-4 md:mb-0 md:mr-6 flex-1">
                  <h4 class="font-semibold text-lg mb-1"><?= htmlspecialchars($post['title']) ?></h4>
                  <p class="text-gray text-sm mb-2"><?= substr(htmlspecialchars($post['content']), 0, 100) ?>...</p>
                  <div class="flex items-center text-xs text-gray">
                    <span class="mr-4"><i class="far fa-calendar mr-1"></i> <?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                    <span><i class="far fa-clock mr-1"></i> <?= ceil(str_word_count(strip_tags($post['content'])) / 200) ?> min read</span>
                  </div>
                </div>
                
                <div class="flex space-x-2">
                  <a href="edit_post.php?id=<?= $post['id'] ?>" class="px-3 py-2 bg-blue-100 text-primary rounded-lg text-sm hover:bg-blue-200 transition-colors">
                    <i class="fas fa-edit mr-1"></i> Edit
                  </a>
                  <button onclick="confirmDelete('delete_post.php?id=<?= $post['id'] ?>')" class="px-3 py-2 bg-red-100 text-secondary rounded-lg text-sm hover:bg-red-200 transition-colors">
                    <i class="fas fa-trash mr-1"></i> Delete
                  </button>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('open');
    });
    
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('open');
      overlay.classList.remove('open');
    });
    
    // Delete confirmation
    function confirmDelete(url) {
      if (confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
        window.location.href = url;
      }
    }
  </script>
</body>
</html>