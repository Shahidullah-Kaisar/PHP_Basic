<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_app";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  echo "Database not Connected: " . mysqli_connect_error();
}

// Start session to use for redirects
session_start();

// Initialize alert variables
$insert = false;
$update = false;
$delete = false;

// Check if we have alert messages from redirect
if (isset($_SESSION['insert']) && $_SESSION['insert']) {
  $insert = true;
  unset($_SESSION['insert']);
}

if (isset($_SESSION['update']) && $_SESSION['update']) {
  $update = true;
  unset($_SESSION['update']);
}

if (isset($_SESSION['delete']) && $_SESSION['delete']) {
  $delete = true;
  unset($_SESSION['delete']);
}

// Handle delete operation
if (isset($_GET['delete'])) {

  $sno = $_GET['delete'];

  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $_SESSION['delete'] = true;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['snoEdit'])) {
    
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $_SESSION['update'] = true;
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    }

  } else {
    // Insert operation
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $_SESSION['insert'] = true;
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <title>iNotes - PHP CRUD Application</title>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .navbar-brand {
      font-weight: 600;
    }

    .hero-section {
      background: linear-gradient(135deg, #6c5ce7, #a29bfe);
      color: white;
      padding: 3rem 0;
      margin-bottom: 2rem;
      border-radius: 0 0 20px 20px;
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .btn-primary {
      background-color: #6c5ce7;
      border-color: #6c5ce7;
    }

    .btn-primary:hover {
      background-color: #5649c0;
      border-color: #5649c0;
    }

    .action-buttons .btn {
      margin-right: 5px;
    }

    .table th {
      background-color: #6c5ce7;
      color: white;
    }

    footer {
      background-color: #343a40;
      color: white;
      padding: 1rem 0;
      margin-top: 2rem;
    }
  </style>
</head>

<body>

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="/phpF/crudApp/index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">

            <div class="mb-3">
              <label for="titleEdit" class="form-label">Note Title</label>
              <input type="text" class="form-control" name="titleEdit" id="titleEdit" required>
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Note Description</label>
              <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="5" required></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>


  <!-- View Details Modal -->
  <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title" id="detailsModalLabel">Note Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h4 id="detailsTitle" class="mb-3"></h4>
          <div class="card">
            <div class="card-body">
              <p id="detailsDescription" class="card-text"></p>
            </div>
          </div>
          <div class="mt-3">
            <small class="text-muted" id="detailsDate"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Hero Section -->
  <div class="hero-section">
    <div class="container text-center">
      <h1 class="display-4 fw-bold">Manage Your Notes</h1>
      <p class="lead">A simple and powerful CRUD application to manage your notes</p>
    </div>
  </div>

  <div class="container">
    <?php
    if ($insert) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <i class='bi bi-check-circle-fill me-2'></i><strong>Success!</strong> Your note has been added successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
    }
    if ($update) {
      echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
                    <i class='bi bi-check-circle-fill me-2'></i><strong>Updated!</strong> Your note has been updated successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
    }
    if ($delete) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <i class='bi bi-check-circle-fill me-2'></i><strong>Success!</strong> Your note has been deleted successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
    }
    ?>    
  </div>


  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header bg-white">
            <h5 class="card-title mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Note</h5>
          </div>
          <div class="card-body">
            <form action="/phpF/crudApp/index.php" method="POST">
              <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" name="title" id="title" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Add Note</button>
            </form>
          </div>
        </div>

        <div class="card">
          <div class="card-header bg-white">
            <h5 class="card-title mb-0"><i class="bi bi-list-check me-2"></i>Your Notes</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="myTable">
                <thead>
                  <tr>
                    <th scope="col">SNo</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM notes";
                  $result = mysqli_query($conn, $sql);
                  $cnt = 1;

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <th scope='row'>" . $cnt . "</th>

                            <td>" . $row['title'] . "</td>

                            <td>" . substr($row['description'], 0, 50) . (strlen($row['description']) > 50 ? '...' : '') . "</td>

                            <td class='action-buttons text-center'>
                            <div class='d-flex flex-nowrap justify-content-center gap-2'>
                                <button class='view btn btn-sm btn-info' id=v" . $row['sno'] . " data-title='" . htmlspecialchars($row['title'], ENT_QUOTES) . "' data-description='" . htmlspecialchars($row['description'], ENT_QUOTES) . "' data-date='" . (isset($row['dt']) ? $row['dt'] : 'Not specified') . "'><i class='bi bi-eye me-1'></i><span>Details</span></button>  
                                <button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . "><i class='bi bi-pencil-square me-1'></i>Edit</button> 
                                <button class='delete btn btn-sm btn-danger' id=d" . $row['sno'] . "><i class='bi bi-trash me-1'></i>Delete</button>
                            </div> 
                            </td>

                          </tr>";
                    $cnt++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="mt-5">
    <div class="container text-center">
      <p class="mb-0">© 2023 iNotes - PHP CRUD Application. All rights reserved.</p>
    </div>
  </footer>

  <!-- JavaScript -->
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable({
        "language": {
          "search": "Filter:",
          "lengthMenu": "Show _MENU_ entries",
          "info": "Showing _START_ to _END_ of _TOTAL_ entries",
          "paginate": {
            "previous": "<i class='bi bi-chevron-left'></i>",
            "next": "<i class='bi bi-chevron-right'></i>"
          }
        }
      });
    });

    // Add update functionality
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        tr = e.target.closest('tr');
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;

        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');

      });
    });

    // Add delete functionality
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        if (confirm("Are you sure you want to delete this note?")) {
          sno = e.target.id.substr(1);
          window.location = `/phpF/crudApp/index.php?delete=${sno}`;
        }
      });
    });

        
    // Add view details functionality
    views = document.getElementsByClassName('view');
    Array.from(views).forEach((element) => {
      element.addEventListener("click", (e) => {
        // Get data attributes from the button
        const title = element.getAttribute('data-title');
        const description = element.getAttribute('data-description');
        const date = element.getAttribute('data-date');
        
        // Populate the details modal
        document.getElementById('detailsTitle').textContent = title;
        document.getElementById('detailsDescription').textContent = description;
        document.getElementById('detailsDate').textContent = 'Created: ' + date;
        
        // Show the modal
        $('#detailsModal').modal('toggle');
      });
    });

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>