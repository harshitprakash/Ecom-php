<?php
    require('top.inc.php');
    require('admin_auth.php');

    auth();

    $sql="SELECT * FROM admin_users WHERE role ='user'";
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
                                 <?php echo "<a href='manage_product.php?id=".$row['id']."' class='btn btn-warning'>Order HIstory</a>";?>
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