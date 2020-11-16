<?php 
    session_start();
    require_once "../confiy/confiy.php";
    require_once "../confiy/common.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    if($_SESSION['role'] != 1){
         header("Location: login.php");
    }
    if(isset($_POST['submit'])){
        if(empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])){
            if(empty($_POST['title'])){
                $titleError = "* Title cannot be Null";
            }
            if(empty($_POST['content'])){
                $contError = "* Content cannot be Null";
            }
            if(empty($_FILES['image'])){
                $imgError = "* Image cannot be Null";
            }
        }else{
            $imgfile = "images/".($_FILES["image"]["name"]);

            $imgfileType = pathinfo($imgfile,PATHINFO_EXTENSION);

            if($imgfileType != 'png' && $imgfileType != 'jpg' && $imgfileType != 'jpeg'){
                echo "<script>alert('Image may be png,jpg,jpeg')</script>";
            }else{
                $title = $_POST['title'];
                $content = $_POST['content'];
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],$imgfile);

                $sql = "INSERT INTO posts(title,content,image,author_id) VALUES (:title,:content,:image,:author)";
                $pdostat = $pdo -> prepare($sql);
                $result = $pdostat -> execute(
                    array(':title'=>$title,':content'=>$content,':image'=>$image,':author'=>$_SESSION['user_id'])
                );
                if($result){
                    echo "<script>alert('Sussessfully Adding');window.location.href='index.php';</script>";
                }
            }
        }
    }

    

?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>
 
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Add Post</h5>
              </div>
              <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" >
                        <p style="color:red"><?php echo empty($titleError) ? '' : $titleError; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" class="form-control" id="content" cols="20" rows="5"></textarea>
                        <p style="color:red"><?php echo empty($contError) ? '' : $contError; ?></p>
                    </div>
                    <div class="form-group">
                       <label for="image">Image</label>
                        <p style="color:red"><br><?php echo empty($imgError) ? '' : $imgError; ?></p>
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="form-group float-sm-right">
                        <a href="#"><input type="submit" value="SUBMIT" name="submit" class="btn btn-primary"></a>
                        <a href="index.php"><input type="button" value="Black" class="btn btn-primary"></a>
                    </div>
                  </form>
              </div>
            </div>
          </div>
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

<!--    footer end  -->
<?php include_once ("footer.php") ?>
