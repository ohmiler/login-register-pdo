<?php 

    require_once('connection.php');

    if (isset($_REQUEST['btn_register'])) {
        $username = strip_tags($_REQUEST['txt_username']);
        $email = strip_tags($_REQUEST['txt_email']);
        $password = strip_tags($_REQUEST['txt_password']);

        if (empty($username)) {
            $errorMsg[] = "Please enter username";
        } else if (empty($email)) {
            $errorMsg[] = "Please enter email";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg[] = "Please enter a valid email address";
        } else if (empty($password)) {
            $errorMsg[] = "Please enter password";
        } else if (strlen($password) < 6) {
            $errorMsg[] = "Password must be atleast 6 characters";
        } else {
            try {
                $select_stmt = $db->prepare("SELECT username, email FROM tbl_user WHERE username = :uname OR email = :uemail");
                $select_stmt->execute(array(':uname' => $username, ':uemail' => $email));
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

                if ($row['username'] == $username) {
                    $errorMsg[] = "Sorry username already exists";
                } else if ($row['email'] == $email) {
                    $errorMsg[] = "Sorry email already exists";
                } else if (!isset($errorMsg)) {
                    $new_password = password_hash($password, PASSWORD_DEFAULT);
                    $insert_stmt = $db->prepare("INSERT INTO tbl_user (username, email, password) VALUES (:uname, :uemail, :upassword)");
                    if ($insert_stmt->execute(array(
                        ':uname' => $username,
                        ':uemail' => $email,
                        ':upassword' => $new_password
                    ))) {
                        $registerMsg = "Register successfully... Please click on login account link";
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>


    <div class="container text-center">
        <h1 class="mt-5">Register Page</h1>
    <form action="" class="form-horizontal mt-3" method="post">
        <?php 
            if (isset($errorMsg)) {
                foreach($errorMsg as $error) {
        ?>
            <div class="alert alert-danger">
                <strong><?php echo $error; ?></strong>
            </div>
        <?php 
                }
            }
        ?>

        <?php 
            if (isset($registerMsg)) {
        ?>
            <div class="alert alert-success">
                <strong><?php echo $registerMsg; ?></strong>
            </div>
        <?php 
            }
        ?>
        <div class="form-group">
            <div class="row">
                <label for="username" class="col-sm-3 control-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_username" class="form-control" placeholder="Enter your username...">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_email" class="form-control" placeholder="Enter your email...">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="password" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="txt_password" class="form-control" placeholder="Enter your password...">
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <input type="submit" name="btn_register" class="btn btn-primary" value="Register">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <p>You have a account login here <a href="index.php">Login</a></p>
                </div>
            </div>
        </div>
        
    </form>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>