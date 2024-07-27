<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "users19";
$conn = mysqli_connect($server, $username, $password, $database);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$title = $_POST['title'];
$description = $_POST['description'];
$sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
$result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNotes - Writing notes make easy</title>
</head>
<body>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <style>
      .flexed-con {
        height : auto;
        width : 500px;
        border : 2px solid red;
        display : flex;
        justify-content : space-between;
        align-items : center;
      }
      .color1 {
        color : white;
        background-color : rgb(39, 39, 59);
        height : auto;
        width : 100px;
        margin-left : 1rem;
      }
      .note-item {
        margin : 14px;
      }
      .note-description {
      width: auto; /* Set width automatically */
      height: auto; /* Adjust height according to text content */
      overflow: hidden; /* Hide overflow */
      position: relative;
      }
      .note-description.full {
        height: auto; /* Override height for full content */
      }
    </style>
  </head>
  <body>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        });
    </script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">iNotes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact Us</a>
      </li>
      <li class="nav-item dropdown">
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<?php
if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Your record has been inserted successfully!</strong>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
?>
<div class="container my-4">
    <h2 class="color">Add a Note</h2>
    <form action="/dhruv/index.php" method="POST">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" name = "title" class="form-control" id="title" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="description">Note Description</label>
        <textarea class="form-control" name = "description" id="description" rows="3"></textarea>
     </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
</div>
<div class="container my-4">
  <?php
  $sql = "SELECT * from `notes`";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    echo "Error in Fetching" . mysqli_connect_error();
    exit();
  }
  $count = 1;
  while($row = mysqli_fetch_assoc($result)) {
    $s_no = $count;
    $tit = $row['title'];
    $des = $row['description'];
    $dat = $row['date'];
    // echo $count . $tit . $des . "<br>";
    echo "<div class='card note-item'>
    <div class='card-body'>
      <h5 class='card-title'>". $tit ."</h5>
      <p class='card-text'> ". $des ."</p>
      <p class='card-text'>". $dat . "</p>
      <button type='button' class='btn btn-primary'>Edit</button>
      <button type='button' id= '$count' class='btn btn-danger'>Delete</button>
    </div>
  </div>";
  $count = $count+1;
  }
  ?>
</div>
<script>
  let delBtn = document.getElementsByClassName("deleteBtn");
</script>
</body>
</html>
</body>
</html>