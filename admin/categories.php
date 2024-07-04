<?php
   require('top.inc.php');
   require('admin_auth.php');

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
            $sql="select * FROM categories ORDER BY categories ASC";
            $res=mysqli_query($con,$sql);

         
         
?>
<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card ">
               <div class="card-body row">
                  <div class="col-sm-6">
                     <h2 class="box-title">Categories </h2>
                  </div>
                  <div class="col-sm 6 d-flex justify-content-end">
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
                                 <?php echo "<a href='?type=delete&id=".$row['id']."'  class='btn btn-danger'>Delete</a>";?>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
 </div>

<?php
require('footer.inc.php');
?>