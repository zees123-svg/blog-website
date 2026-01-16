<?php 
    session_start();
    include './admin/config.php';
    if(isset($_SESSION['user_data'])) {
        header('location: http://localhost/blog/admin/index.php');
    }
    if(isset($_POST['login_btn'])) {
        $email = mysqli_real_escape_string($config,$_POST['email']);
        $password = mysqli_real_escape_string($config,sha1($_POST['password']));
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM  user WHERE email = '$email' AND password = '$password'";
        $query = mysqli_query($config,$sql);
        $data = mysqli_num_rows($query);
        if($data) {
            $result = mysqli_fetch_assoc($query);
            $user_data = array($result['user_id'],$result['username'],$result['role']);
            $_SESSION['user_data'] = $user_data;
            header('location: admin/index.php');
        }
        else {
            $_SESSION['error'] = "Invalid email/password";
            header('Location: login.php');
        }
    }
?>

<?php include 'header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-md-4 m-auto p-5 mt-5 bg-info">
                <form action="" method="POST">
                    <p class="text-center">Blog! Login your account</p>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Enter Your Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" name="login_btn" value="Login">
                    </div>
                    <?php
                        if(isset($_SESSION['error'])) {
                            $error = $_SESSION['error'];
                            echo "<p class='bg-danger p-2 text-white'>".$error."</p>";
                            unset($_SESSION['error']);
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>