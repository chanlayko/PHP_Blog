<?php
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";

    if(isset($_POST['register'])){
        if(empty($_POST['user']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 4){
            if(empty($_POST['user'])){
                $nameError = "<p style='color:red;margin-top:-10px;'>* Name cannot be Null *</p>";
            }
            if(empty($_POST['email'])){
                $emailError = "<p style='color:red;margin-top:-10px;'>* Email cannot be Null *</p>";
            }
            if(empty($_POST['password'])){
                $passError = "<p style='color:red;margin-top:-10px;'>* Password cannot be Null *</p>";
            }
            if(strlen($_POST['password']) < 4){
                $passError = "<p style='color:red;margin-top:-10px;'>* Password show be 4 characters at least *</p>";
            }
        }else{
            $name = $_POST['user'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

            $pdostat = $pdo -> prepare("SELECT * FROM users WHERE email=:email");
            $pdostat -> bindValue(":email",$email);
            $pdostat -> execute();
            $user = $pdostat -> fetch(PDO::FETCH_ASSOC);

            if($user){
                echo "<script>alert('Your Name duplicated !!')</script>";   
            }else{
                $pdostat = $pdo -> prepare("INSERT INTO users(user,email,password,role) VALUES (:user,:email,:password,:role)");
                $result = $pdostat -> execute(
                    array(':user'=>$name,':email'=>$email,':password'=>$password,':role'=>0)
                );
                if($result){
                    echo "<script>alert('Sussessfully Register, You cna now login');window.location.href='login.php';</script>";
                }
            }
        }
    }

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="login.php"><b>Blog</b><span class="span"> Admin</span></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Register New Account</p>

      <form action="register.php" method="post">
      <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
       <div class="input-group mb-3">
          <input type="text" name="user" class="form-control" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <p><?php echo empty($nameError) ? '' : $nameError; ?></p>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p><?php echo empty($emailError) ? '' : $emailError; ?></p>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <p><?php echo empty($passError) ? '' : $passError; ?></p>
        <div class="">
          <div class="form-group">
               <a href="register.php"><input type="submit" name="register" class="btn btn-primary form-control" value="Register"></a>
          </div>
          <div class="form-group">
                <a href="login.php"><input type="button" name="sigin" class="btn btn-primary form-control" value="Log In"></a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
