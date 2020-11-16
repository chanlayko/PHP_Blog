<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog Site</title>
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
       <div class="col-md-12">
           <div class="text-center">
               <h1>Blog Site</h1>
           </div>
       </div><br>
        <div class="col-md-12">
            <div class="row">
               <?php 
                    
                    if(!empty($_GET['pageno'])){
                            $pageno = $_GET['pageno'];
                        }else{
                            $pageno = 1;
                        }
                        $numOfrecs = 6;
                        $offset = ($pageno - 1) * $numOfrecs;
                
                    $sql = "SELECT * FROM posts ORDER BY id DESC";
                    $pdostat = $pdo -> prepare($sql);
                    $pdostat -> execute();
                    $RowResult = $pdostat -> fetchAll();
                    $total_pages = ceil(count($RowResult) / $numOfrecs);

                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs";
                    $pdostat = $pdo -> prepare($sql);
                    $pdostat -> execute();
                    $result = $pdostat -> fetchAll();

                
                    if($result){
                        $i = 1;
                        foreach($result as $value){
                    ?>
                       <div class="col-md-4">
                            <div class="card card-widget">
                                <div class="card-header text-center">
                                    <h4><?php echo escape($value['title']); ?></h4>
                                </div>
                                <div class="card-body">
                                    <a href="blogdetail.php?id=<?php echo $value['id']; ?>">
                                        <img src="admin/images/<?php echo $value['image']; ?>" width="150px" height="150px" alt="" style="width:393px;height: 251px; !important">
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php
                        $i++;
                        }
                    }

                ?>
            </div>
        </div>
        <div class="col-md-12">
             <div class="card-footer clearfix">
                   <nav aria-label="Page naigation example">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
                            <li class="page-item <?php if($pageno <= 1){ echo 'disabled';} ?>">
                                <a href="<?php if($pageno <= 1){ echo '#';}else{ echo '?pageno='.($pageno-1);} ?>" class="page-link">Previous</a>
                            </li>
                            <li class="page-item"><a href="#" class="page-link"><?php echo $pageno; ?></a></li>
                            <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>">
                                <a href="<?php if($pageno >= $total_pages){echo '#';}else{echo '?pageno='.($pageno+1);} ?>" class="page-link">Next</a>
                            </li>
                            <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
                        </ul>  
                   </nav>
              </div>
        </div>
    </div>
</div>


  <footer class="main-footer" style="margin-left:0 !important">
    <div class="float-right d-none d-sm-block">
      <a href="logout.php">
            <input type="button" value="Log Out" class="btn btn-default">
        </a>
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
    <div class="float-right">
        
    </div>
  </footer>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
