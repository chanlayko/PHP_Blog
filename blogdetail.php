<?php 
    session_start();
    require_once "confiy/confiy.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    
    $blogId = $_GET['id'];

    $shpdosta = $pdo -> prepare("SELECT * FROM posts WHERE id=$blogId");
    $shpdosta -> execute();
    $shResult = $shpdosta -> fetchAll();

    $cmpdosta = $pdo -> prepare("SELECT * FROM comments WHERE post_id=$blogId");
    $cmpdosta -> execute();
    $cmResult = $cmpdosta -> fetchAll();

//    print_r($cmResult[0]['author_id']);

    $aUser_name = $cmResult[0]['author_id'];
    $aupdosta = $pdo -> prepare("SELECT * FROM users WHERE id=$aUser_name");
    $aupdosta -> execute();
    $auResult = $aupdosta -> fetchAll();

    
    if($_POST){
        $comment = $_POST["comment"];
        $user_id = $_SESSION['user_id'];
        $pdostat = $pdo -> prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
        $result = $pdostat -> execute(
            array(":content"=>$comment,":author_id"=>$user_id,":post_id"=>$blogId)
        );
        if($result){
            header("Location:blogdetail.php?id=$blogId");
        }
    }


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="content-wrapper" style="margin-left:0px !important">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-widget">
                  <div class="card-header text-center">
                        <h4><?php echo $shResult[0]['title']; ?></h4>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                   <img src="" alt="">
                    <img src="admin/images/<?php echo $shResult[0]['image']; ?>" class="img-fluid pad"  alt="Photo">
                    <p><?php echo $shResult[0]['content']; ?></p>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer card-comments">
                   <div class="card-head">
                       <h4>Comment</h4><hr>
                   </div>
                    <div class="card-comment">

                      <div class="comment-text" style="margin-left:0px; !important">
                        <span class="username">
                              <?php echo $auResult[0]['user']; ?>
                          <span class="text-muted float-right"><?php echo $cmResult[0]['created_at']; ?></span>
                        </span><!-- /.username -->
                           <?php echo $cmResult[0]['content']; ?>
                      </div>
                      <!-- /.comment-text -->
                    </div>
                    <!-- /.card-comment -->
                  </div>
                  <!-- /.card-footer -->
                  <div class="card-footer">
                    <form action="" method="post">
                      <img class="img-fluid img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="Alt Text">
                      <!-- .img-push is used to add margin to elements next to floating images -->
                      <div class="img-push">
                        <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script srplugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script srplugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script srdist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script srdist/js/demo.js"></script>
</body>
</html>
