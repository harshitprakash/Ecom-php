<?php
   require('top.inc.php');
   require('admin_auth.php');

   auth();
   $id=get_safe_value($con,$_GET['id']);

            // $sql="select * FROM categories ORDER BY categories ASC";
            // $res=mysqli_query($con,$sql);


   $sql = "SELECT 
   order_details.*, 
   product.name, 
   product.image,
   `order`.total_price,
   `order`.payment_type,
   `order`.user_id
      FROM 
            order_details
        JOIN 
            `order` ON order_details.order_id = `order`.id
        JOIN 
            product ON order_details.product_id = product.id
        WHERE 
            `order`.user_id = $id";

         $req=mysqli_query($con,$sql);
         $data=array();
         while($row=mysqli_fetch_assoc($req)){
               $data[]=$row;

            }
            $first_row=$data[0];
            $id=$id;
            $quary="SELECT * from admin_users where id= $id";
            $execute=mysqli_query($con,$quary);
            $result=mysqli_fetch_assoc($execute);
                                            
                                            

         
         
?>
<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card ">
               <div class="card-body row">
                  <div class="col-sm-6">
                     <h1 class="box-title">User Details</h1>
                     <div class=" container">
                        <h6>Gmail: <?php echo $result['email']?> </h6>
                        <h6>Name: <?php echo $result['username']?> </h6>
                     </div>

                  </div>
                  
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">Product</th>
                              <th class="text-center">qty</th>
                              <th class="text-center">Price</th>
                              <th class="text-center">Total price</th>
                              <th class="text-center">payment method</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($data as $data){?>
                              
                           <tr>
                           <td class="text-center">
                              <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$data['image']?>" alt="full-image" style="width: 100px; height:auto;"><br>
                              <h6>
                                 <span class="amount"><?php echo $data['name']?></span>
                              </h6>
                           </td>
                              <td class="text-center"><?php echo $data['qty']?></td>
                              <td class="text-center"><?php echo $data['price']?></td>

                              <td class="text-center"><?php echo $data['total_price']?></td>
                              <td class="text-center"><?php echo $data['payment_type']?></td>
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