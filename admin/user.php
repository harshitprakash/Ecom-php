<?php
    require('top.inc.php');
    require('admin_auth.php');

    auth();
    $start=0;
    $rows_per_page=10;
    $record ="SELECT * FROM admin_users WHERE role ='user'";
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
    $sql="SELECT * FROM admin_users WHERE role ='user' LIMIT $start,$rows_per_page";
    $res=mysqli_query($con,$sql); 
?>
<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card ">
               <div class="card-body row">
                  <div class="col-sm-6">
                     <h2 class="box-title">Users List </h2>
                  </div>
                 
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">Id</th>
                              <th class="text-center">Name</th>
                              <th class="text-center">Email</th>
                              <th class="text-center">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php while($row = mysqli_fetch_assoc($res)){?>
                           <tr>
                              <td class="text-center"><?php echo $row['id']?></td>
                              <td class="text-center"><?php echo $row['username']?></td>
                              <td class="text-center"><?php echo $row['email']?></td>
                              <td class="text-center">
                                 <?php echo "<a href='user_order_history.php?id=".$row['id']."' class='btn btn-warning'>Order HIstory</a>";?>
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