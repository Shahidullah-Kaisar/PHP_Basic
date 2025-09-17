<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$post) die("Post not found");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = mysqli_prepare($conn, "UPDATE posts SET title=?, content=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $id);
    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Post | Blog Admin</title>
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
    
    .form-input:focus, .form-textarea:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }
    
    .slug-preview {
      transition: all 0.3s ease;
    }
    
    .editor-toolbar {
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }
    
    .editor-content {
      border-bottom-left-radius: 0.5rem;
      border-bottom-right-radius: 0.5rem;
      min-height: 300px;
    }
  </style>
</head>
<body class="py-8">
  <div class="max-w-4xl mx-auto px-4">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-bold text-dark">Edit Post</h1>
        <p class="text-gray mt-2">Update your blog post content</p>
      </div>
      <a href="dashboard.php" class="flex items-center text-primary font-medium hover:text-primaryDark transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
      </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <form method="post" class="p-6 md:p-8">
        <!-- Title Input -->
        <div class="mb-6">
          <label for="title" class="block text-sm font-medium text-dark mb-2">
            Post Title <span class="text-secondary">*</span>
          </label>
          <input 
            type="text" 
            id="title" 
            name="title" 
            value="<?= htmlspecialchars($post['title']) ?>" 
            required
            class="form-input w-full px-4 py-3 border border-grayLight rounded-lg focus:border-primary transition-colors"
            oninput="updateSlugPreview()"
          >
        </div>

        <!-- Slug Preview -->
        <div class="mb-6 slug-preview">
          <label class="block text-sm font-medium text-dark mb-2">Slug Preview</label>
          <div class="px-4 py-2 bg-gray-50 border border-grayLight rounded-lg text-gray">
            <span id="slug-preview-text"><?= htmlspecialchars($post['slug']) ?></span>
          </div>
          <p class="text-xs text-gray mt-2">This is how the URL for your post will look</p>
        </div>

        <!-- Content Textarea -->
        <div class="mb-6">
          <label for="content" class="block text-sm font-medium text-dark mb-2">
            Content <span class="text-secondary">*</span>
          </label>
          
          <!-- Simple Editor Toolbar (visual only) -->
          <div class="editor-toolbar bg-gray-50 border border-grayLight border-b-0 rounded-t-lg p-2 flex space-x-2">
            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center">
              <i class="fas fa-bold text-sm"></i>
            </button>
            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center">
              <i class="fas fa-italic text-sm"></i>
            </button>
            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center">
              <i class="fas fa-underline text-sm"></i>
            </button>
            <div class="border-l border-gray-300 h-6 my-auto"></div>
            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center">
              <i class="fas fa-list-ul text-sm"></i>
            </button>
            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center">
              <i class="fas fa-list-ol text-sm"></i>
            </button>
            <div class="border-l border-gray-300 h-6 my-auto"></div>
            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center">
              <i class="fas fa-link text-sm"></i>
            </button>
            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 flex items-center justify-center">
              <i class="fas fa-image text-sm"></i>
            </button>
          </div>
          
          <textarea 
            id="content" 
            name="content" 
            rows="12" 
            required
            class="form-textarea w-full px-4 py-3 border border-grayLight rounded-b-lg focus:border-primary transition-colors editor-content"
          ><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <!-- Character Count -->
        <div class="mb-8 flex justify-between items-center">
          <div class="text-sm text-gray">
            <span id="char-count"><?= strlen($post['content']) ?></span> characters
          </div>
          <div class="text-sm">
            <span class="text-secondary">*</span> indicates required field
          </div>
        </div>

        <!-- Post Meta Information -->
        <div class="bg-blue-50 rounded-lg p-4 mb-6">
          <h3 class="font-medium text-dark mb-2 flex items-center">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i> Post Information
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
              <span class="text-gray">Created: </span>
              <span class="text-dark"><?= date('F j, Y g:i A', strtotime($post['created_at'])) ?></span>
            </div>
            <div>
              <span class="text-gray">Last Updated: </span>
              <span class="text-dark"><?= date('F j, Y g:i A', strtotime($post['updated_at'] ?? $post['created_at'])) ?></span>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4">
          <a href="dashboard.php" class="px-6 py-3 border border-grayLight text-dark font-medium rounded-lg text-center hover:bg-gray-50 transition-colors">
            Cancel
          </a>
          <button 
            type="submit" 
            class="px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primaryDark transition-colors flex items-center justify-center"
          >
            <i class="fas fa-save mr-2"></i> Update Post
          </button>
        </div>
      </form>
    </div>

    <!-- Tips Section -->
    <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-100">
      <h3 class="font-semibold text-dark mb-3 flex items-center">
        <i class="fas fa-lightbulb text-blue-500 mr-2"></i> Editing Tips
      </h3>
      <ul class="text-sm text-dark space-y-2">
        <li class="flex items-start">
          <i class="fas fa-check text-blue-500 mt-1 mr-2 text-xs"></i>
          <span>Make sure your title is clear and engaging</span>
        </li>
        <li class="flex items-start">
          <i class="fas fa-check text-blue-500 mt-1 mr-2 text-xs"></i>
          <span>Break up long paragraphs for better readability</span>
        </li>
        <li class="flex items-start">
          <i class="fas fa-check text-blue-500 mt-1 mr-2 text-xs"></i>
          <span>Check for spelling and grammar errors</span>
        </li>
        <li class="flex items-start">
          <i class="fas fa-check text-blue-500 mt-1 mr-2 text-xs"></i>
          <span>Preview your post before saving changes</span>
        </li>
      </ul>
    </div>
  </div>

  <script>
    // Update slug preview as user types
    function updateSlugPreview() {
      const titleInput = document.getElementById('title');
      const slugPreview = document.getElementById('slug-preview-text');
      
      if (titleInput.value) {
        const slug = titleInput.value
          .toLowerCase()
          .trim()
          .replace(/[^a-z0-9\s-]/g, '')
          .replace(/[\s-]+/g, '-');
        
        slugPreview.textContent = slug;
      } else {
        slugPreview.textContent = 'your-title-will-appear-here';
      }
    }
    
    // Character count for content
    const contentTextarea = document.getElementById('content');
    const charCount = document.getElementById('char-count');
    
    contentTextarea.addEventListener('input', () => {
      charCount.textContent = contentTextarea.value.length;
    });
  </script>
</body>
</html>