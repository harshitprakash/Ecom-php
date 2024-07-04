<?php
require('top.inc.php');
require('admin_auth.php');

auth();
if(isset($_GET['type'])&& $_GET['type'] != '')
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
         $update_status_sql="UPDATE home_banner set status='$status' where id='$id' ";
         mysqli_query($con,$update_status_sql);
      }

      if($type =='delete'){
         $id = get_safe_value($con,$_GET['id']);
         $select_sql = "SELECT * FROM home_banner WHERE id='$id'";
         $result = mysqli_query($con, $select_sql);
         $row = mysqli_fetch_assoc($result);
         $image_filename = $row['image'];
        if($image_filename == ''){
            header('Location:home_banner.php');
        }else{
            $image_path = HOME_BANNER_IMAGE_SERVER_PATH . $image_filename;
            if (file_exists($image_path)) {
               unlink($image_path); // This deletes the file
               }else {
   
                   echo "Image file not found.";
               } 
   
            $delete_sql="DELETE from home_banner WHERE id='$id' ";
            mysqli_query($con,$delete_sql);
        }
        
      }
}

    $sql="SELECT * from home_banner";
    $res=mysqli_query($con,$sql);


?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card ">
               <div class="card-body row">
                  <div class="col-sm-6">
                     <h2 class="box-title">Products List </h2>
                  </div>
                  <div class="col-sm 6 d-flex justify-content-end">                  
                     <a href="manage_home_banner.php" type="button" class="btn btn-primary">Add Products</a>
                  </div>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">Id</th>
                              <th class="text-center">Title</th>
                              <th class="text-center">Sub_title</th>
                              <th class="text-center">Product Link</th>
                              <th class="text-center">Image</th>
                              <th class="text-center">Status</th>
                              <th class="text-center">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php while($row = mysqli_fetch_assoc($res)){?>
                           <tr>
                              <td class="text-center"><?php echo $row['id']?></td>
                              <td class="text-center"><?php echo $row['title']?></td>
                              <td class="text-center"><?php echo $row['sub_title']?></td>
                              <td class="text-center"><?php echo $row['image_url']?></td>
                              <td class="text-center"><img src="<?php echo HOME_BANNER_IMAGE_SITE_PATH.$row['image']?>"></td>
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
                                 <?php echo "<a href='manage_home_banner.php?id=".$row['id']."' class='btn btn-primary'>Edit</a>";?>
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