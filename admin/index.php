<?php 
    session_start();
    require_once "../confiy/confiy.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }

?>

<!-- header -->
<?php include_once ("header.php"); ?>
<!-- nvabar include -->
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
                <h5 class="m-0">Featured</h5>
              </div>
              <?php 
                if(!empty($_GET['pageno'])){
                    $pageno = $_GET['pageno'];
                }else{
                    $pageno = 1;
                }
                $numOfrecs = 2;
                $offset = ($pageno - 1) * $numOfrecs;
                
                if(empty($_POST['search'])){
                    $sql = "SELECT * FROM posts ORDER BY id DESC";
                    $pdostat = $pdo -> prepare($sql);
                    $pdostat -> execute();
                    $RowResult = $pdostat -> fetchAll();
                    $total_pages = ceil(count($RowResult) / $numOfrecs);

                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs";
                    $pdostat = $pdo -> prepare($sql);
                    $pdostat -> execute();
                    $result = $pdostat -> fetchAll();
                }else{
                    $searchkey = $_POST['search'];
                    $sql = "SELECT * FROM posts WHERE title LIKE '%$searchkey%' ORDER BY id DESC";
                    $pdostat = $pdo -> prepare($sql);
                    $pdostat -> execute();
                    $RowResult = $pdostat -> fetchAll();
                    $total_pages = ceil(count($RowResult) / $numOfrecs);

                    $sql = "SELECT * FROM posts WHERE title LIKE '%$searchkey%' ORDER BY id DESC LIMIT $offset,$numOfrecs";
                    $pdostat = $pdo -> prepare($sql);
                    $pdostat -> execute();
                    $result = $pdostat -> fetchAll();
                } 
                
                ?>
              <div class="card-body">
                   <div class="form-group">
                       <a href="add.php"><input type="submit" value="New Blog Posts" class="btn btn-success"></a>
                   </div>
                   <div class="form-group">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 200px">Title</th>
                                <th>Content</th>
                                <th colspan="2" style="width: 50px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php 

                                if($result){
                                    $i = 1;
                                    foreach($result as $value){
                                ?>
                                      <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo substr($value['content'],0,100); ?>...</td>
                                        <td style="width: 50px"><a href="edit.php?id=<?php echo $value['id']; ?>"><input type="submit" value="Edit" class="btn btn-primary text-center"></a></td>
                                        <td style="width: 50px"><a href="delete.php?id=<?php echo $value['id']; ?>"><input type="submit" value="Delete" class="btn btn-primary text-center" onclick="return confirm('Are you sure you want to delete this item')"></a></td>

                                    </tr>  

                                <?php
                                    $i++;
                                    }
                                }



                            ?>

                        </tbody>
                    </table>

                   </div>
              </div>
              <!-- /.card-body -->
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

 <?php include_once("footer.php"); ?>