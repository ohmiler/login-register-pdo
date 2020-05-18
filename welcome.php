<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
    
    <div class="container text-center">
    <h2 class="mt-5">
        <?php 
            require_once("connection.php");
            session_start();

            if (!isset($_SESSION['user_login'])) {
                header("location: index.php");
            }

            $id = $_SESSION['user_login'];

            $select_stmt = $db->prepare("SELECT * FROM tbl_user WHERE id = :uid");
            $select_stmt->execute(array(':uid' => $id));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($_SESSION['user_login'])) {
        ?>
        Welcome, <?php echo $row['username']; } ?>
    </h2>
                <hr>
        <br>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>