<?php
   require('top.inc.php');
   require('admin_auth.php');
   require('pagination.php');
   auth();

            if(isset($_GET['type']) && $_GET['type'] != '')
            {
                  $type=get_safe_value($con,$_GET['type']);
                  if($type =='status'){
                     $operation= get_safe_value($con,$_GET['operation']);
                     $id = get_safe_value($con,$_GET['id']);
                     if($operation=='active'){
                        $status='1';
                     }
                     else{
                        $status='0';
                     }
                     $update_status_sql="UPDATE categories set status='$status' where id='$id' ";
                     mysqli_query($con,$update_status_sql);
                  }

                  if($type =='delete'){
                     $id = get_safe_value($con,$_GET['id']);
                     $delete_sql="DELETE from categories WHERE id='$id' ";
                     mysqli_query($con,$delete_sql);
                  }
            }
            $start=0;
            $rows_per_page=10;
            $record ="SELECT * FROM categories";
            $result = $con->query($record);
            if ($result->num_rows > 0) {
               // Output number of rows
               $nr_of_rows = $result->num_rows;
           }
            $pages=ceil($nr_of_rows/$rows_per_page);
            if(isset($_GET['page-nr'])){
               $page=$_GET['page-nr']-1;
               $start = $page*$rows_per_page;
            }
            $sql="select * FROM categories LIMIT $start,$rows_per_page";
            $res=mysqli_query($con,$sql);

        if(isset($_POST['search'])){
         $text=get_safe_value($con,$_POST['text']);
         $search_text = '%' . $text . '%';
         $sql = "SELECT categories FROM categories WHERE categories LIKE '$search_text'";
         $query=mysqli_query($con,$sql);
         while ($data = mysqli_fetch_assoc($query)) {
            echo $data['categories'] . "<br>";
        }         echo $data;         
      }

         
         
?>
<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card ">
               <div class="card-body row">
                  <div class="col-sm-3">
                     <h2 class="box-title">Categories </h2>
                  </div>
                  <div class="col-sm-7 d-flex justify-content-end">
                  <form class="form-inline" method="POST">
                     <input type="text" class="form-control" name="text" placeholder="Search">
                     <button type="submit" class="btn btn-danger" name="search">
                        <i class="fa fa-search"></i>
                     </button>
                  </form>

                  </div>
                  <div class="col-sm-2 d-flex justify-content-end">
                     <a href="manage_category.php" type="button" class="btn btn-primary">Add Category</a>
                  </div>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">Id</th>
                              <th class="text-center">Categories</th>
                              <th class="text-center">Status</th>
                              <th class="text-center">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php while($row = mysqli_fetch_assoc($res)){?>
                           <tr>
                              <td class="text-center"><?php echo $row['id']?></td>
                              <td class="text-center"><?php echo $row['categories']?></td>
                              <td class="text-center">
                              
                              <?php
                                    if($row['status'] == 1)
                                       {
                                          echo "<a href='?type=status&operation=deactive&id=".$row['id']."' class='btn btn-success'>Active</a>&nbsp;";
                                       } 
                                    else
                                       {
                                          echo "<a href='?type=status&operation=active&id=".$row['id']."' class='btn btn-warning'>Deactive</a>&nbsp;";
                                       }
                              ?>
                              </td>
                              <td class="text-center">
                                 <?php echo "<a href='manage_category.php?id=".$row['id']."' class='btn btn-primary'>Edit</a>";?>
                                 <a href="#" onclick="return confirmDelete(<?php echo $row['id']; ?>)"class='btn btn-danger'>
                                       Delete
                                 </a>
                              </td>
                           </tr>
                           <?php } ?>
                           
                        </tbody>
                     </table>
                  </div>
                 <?php if($nr_of_rows >=$rows_per_page){
                  ?> 
               <div class=" container">
                 showing 1 of <?php echo $pages?>

                  <nav aria-label="Page navigation example">
                     <ul class="pagination">
                        <li><a class="page-link text-danger" href="?page-nr-1">First page</a></li>
                     <?php 
                              if(isset($_GET['page-nr']) && $_GET['page-nr']>1 ){ ?>
                        <li class="page-item"><a class="page-link text-danger" href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a></li>
                           <?php }?>
                                 <?php for($counter=1;$counter<=$pages; $counter ++){ ?>
                        <li class="page-item"><a class="page-link text-danger" href="?page-nr=<?php echo $counter?>"><?php echo $counter?></a></li>
                                 <?php }?>
                                 <?php if (!isset($_GET['page-nr'])) {?>
                                 <a class="page-link text-danger" href="?page-nr=2">Next</a>
                                 <?php
                              } else {
                                 // If 'page-nr' is set
                                 $currentPage = $_GET['page-nr'];

                                 if ($currentPage >= $pages) {
                                    // If current page is the last page or greater than the last page, show 'NEXT' link disabled or with no link
                                    
                                 } else {
                                    // Otherwise, show 'Next' link pointing to the next page number
                                    ?>
                                    <li><a class="page-link text-danger" href="?page-nr=<?php echo $currentPage + 1 ?>">Next</a></li>
                                    <?php
                                 }
                              }
                           ?> 
                           <li><a class="page-link text-danger" href="?page-nr=<?php echo $pages?>">Last page</a>
                           </li>
                     </ul>
                  </nav>
               </div>
                  <?php }?>
               </div>
            </div>
         </div>
      </div>
   </div>
 </div>
 
<?php
require('footer.inc.php');
?>