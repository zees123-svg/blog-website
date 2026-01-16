<?php

    include 'header.php';
    if($admin != 1) {
        header('location: index.php');
    }
    if(isset($_POST['add_user'])) {
        $username = mysqli_real_escape_string($config,$_POST['username']);
        $email = mysqli_real_escape_string($config,$_POST['email']);
        $pass = mysqli_real_escape_string($config,sha1($_POST['password']));
        $c_pass = mysqli_real_escape_string($config,sha1($_POST['c_pass']));
        $role = mysqli_real_escape_string($config,$_POST['role']);
        if(strlen($username) < 4 || strlen($username) > 100) {
            $error = "Username must be between 4 to 100 character";
        }
        elseif (strlen($pass) < 4) {
            $error = "Password must be at least 4 character long";
        }
        elseif ($pass != $c_pass) {
            $error = "Password does not match";        
        }
        else {
            $sql = "SELECT * FROM user WHERE email='$email'";
            $query = mysqli_query($config,$sql);
            $row = mysqli_num_rows($query);
            if($row >= 1) {
                $error = "Email already exist";
            }
            else {
                $sql2 = "INSERT INTO user (username,email,password,role) VALUES ('$username','$email','$pass','$role')";
                $query2 = mysqli_query($config,$sql2);
                if($query2) {
                    $msg = ['User added sucessfully :)','alert-success'];
                    $_SESSION['msg'] = $msg;
                    header('location: users.php');
                }
                else {
                    $msg = ['User does not added, try again :)','alert-danger'];
                    $_SESSION['msg'] = $msg;
                    header('location: users.php');
                }
            }
        }
    }

?>

<div class="container">
    <div class="row">
        <div class="col-md-5 m-auto bg-info p-4">
            <?php
                if(!empty($error)) {
                    echo "<p class='bg-danger text-white p-2'>".$error."</p>";
                }
            ?>
            <form action="" method="POST">
                <p class="text-center fw-bold">Create New User</p>
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" value="<?= (!empty($error)) ? $username : ''; ?>" placeholder="Enter Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" value="<?= (!empty($error)) ? $email : ''; ?>" placeholder="Enter Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="c_pass" class="form-control" placeholder="Enter Confirmed Password" required>
                </div>
                <div class="mb-3">
                    <select name="role" class="form-control" required>
                        <option value="">Select Role</option>
                        <option value="1">Admin</option>
                        <option value="0">Co-Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="submit" name="add_user" value="Create" class="btn btn-primary">                
                </div>
            </form>
        </div>
    </div>
</div>

<?php

    include 'footer.php';

?>