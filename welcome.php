<?php
    session_start();
    if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] != true) {
        header("location: login.php");
        exit;
    }
?>

<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "users19";
$conn = mysqli_connect($server, $username, $password, $database);
$user = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO `$user` (`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome - <?php echo $_SESSION['username'] ?></title>
  </head>
  <body>
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id = 'editForm' action="/dhruv/edit_user.php" method="POST">
                    <div class="form-group">
                        <label for="titleEdit">Note Title</label>
                        <input type="text" name="titleEdit" class="form-control" id="titleEdit" aria-describedby="emailHelp">
                        <div style="display:none;">
                        <label for="titleEditOld">Note Title</label>
                        <input type="text" name="titleEditOld" class="form-control" id="titleEditOld" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descriptionEdit">Note Description</label>
                        <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="3"></textarea>
                        <div style="display:none;">
                        <label for="descriptionEditOld">Note Description</label>
                        <textarea class="form-control" name="descriptionEditOld" id="descriptionEditOld" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id='saveChanges'>Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php require 'nav.php' ?>
    <div class="container my-4">
        <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Hello - <b><?php echo $_SESSION['username']; ?></b></h4>
        <p>What's up, How are you doing? Welcome to iSecure, you are logged in as <b><?php echo $_SESSION['username']; ?></b></p>
        <hr>
        <p class="mb-0">Whenever you need to, be sure to log out <a href="/dhruv/logout.php">using this link</a></p>
        </div>
    </div>
    <div class="container my-4">
        <h2 class="color">Add a Note</h2>
        <form action="/dhruv/welcome.php" method="POST">
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
    <form id="deleteForm" method="POST" action="delete_user.php" style="display:none;">
        <input type="hidden" name="usernameToDelete" id="usernameToDelete">
    </form>
    <form id="editForm" method="POST" action="edit_user.php" style="display:none;">
        <input type="hidden" name="titleToEdit" id="titleToEdit">
        <input type="hidden" name="descriptionToEdit" id="descriptionToEdit">
    </form>
    <div class="container my-4">
        <?php
        $sql = "SELECT * from `$user`";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error in Fetching";
            exit();
        }
        $count = 1;
        while($row = mysqli_fetch_assoc($result)) {
            $s_no = $count;
            $tit = $row['title'];
            $des = $row['description'];
            $dat = $row['date'];
            echo "<div class='card note-item'>
            <div class='card-body'>
            <h5 class='card-title'>". $tit ."</h5>
            <p class='card-text'> ". $des ."</p>
            <p class='card-text'>". $dat . "</p>
            <button type='button' class='btn btn-primary editBn'>Edit</button>
            <button type='button' id= '$count' class='btn btn-danger deleteBn'>Delete</button>
            </div>
        </div>";
        $count = $count+1;
        }
        ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        let deleteBtn = document.getElementsByClassName('deleteBn');
        let editBtn = document.getElementsByClassName('editBn');
        for (let i = 0; i< deleteBtn.length; i++) {
            deleteBtn[i].addEventListener("click", (evt)=> {
                deleteFunction(evt.target.parentElement.firstElementChild.textContent);
            })
        }
        for (let i=0; i<editBtn.length; i++) {
            editBtn[i].addEventListener("click", (evt)=> {
                editFunction(evt.target.parentElement.firstElementChild.textContent, evt.target.parentElement.children[1].textContent);
            })
        }
        let deleteFunction = (username) => {
        document.getElementById('usernameToDelete').value = username;
        document.getElementById('deleteForm').submit();
        }
        let editFunction = (title, description) => {
            document.getElementById('titleEdit').value = title;
            document.getElementById('descriptionEdit').value = description;
            document.getElementById('titleEditOld').value = title;
            document.getElementById('descriptionEditOld').value = description;
            $('#editModal').modal('toggle');

        }
    </script>
</body>
</html>