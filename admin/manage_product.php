<?php
    require('top.inc.php');
    require('admin_auth.php');

    auth();


    $categories_id='';
    $name='';
    $mrp='';
    $price='';
    $qty='';
    $image='';
    $short_desc='';
    $description='';
    $meta_title='';
    $meta_desc='';
    $meta_keyword='';
    $msg='';
    $image_required='required';
   if(isset($_GET['id']) && $_GET['id'] !=' ')
   {
      $image_required='';
      $id=get_safe_value($con,$_GET['id']);
      $res=mysqli_query($con,"SELECT * FROM product WHERE id='$id'");
      $check=mysqli_num_rows($res);
      if($check>0)
         {
            $row=mysqli_fetch_assoc($res);
            $categories_id=$row['categories_id'];
            $name=$row['name'];
            $mrp=$row['mrp'];
            $price=$row['price'];
            $qty=$row['qty'];
            $image=$row['image'];
            $short_desc=$row['short_desc'];
            $description=$row['description'];
            $meta_title=$row['meta_title'];
            $meta_desc=$row['meta_desc'];
            $meta_keyword=$row['meta_keyword'];

         }
      else{
         header("Location: product.php");
         die();
      }
   }

   if(isset($_POST['submit']))
   {
      $categories_id=get_safe_value($con,$_POST['categories_id']);
      $name=get_safe_value($con,$_POST['name']);
      $mrp=get_safe_value($con,$_POST['mrp']);
      $price=get_safe_value($con,$_POST['price']);
      $qty=get_safe_value($con,$_POST['qty']);
      $image = ''; // Initialize $image variable
      $short_desc=get_safe_value($con,$_POST['short_desc']);
      $description=get_safe_value($con,$_POST['description']);
      $meta_title=get_safe_value($con,$_POST['meta_title']);
      $meta_desc=get_safe_value($con,$_POST['meta_desc']);
      $meta_keyword=get_safe_value($con,$_POST['meta_keyword']);


      $res=mysqli_query($con,"SELECT * FROM product WHERE name='$name'");
      $check=mysqli_num_rows($res);

      if($check>0)
      {
         if(isset($_GET['id']) && $_GET['id'] != ' '){
            $getdata= mysqli_fetch_assoc($res);
            if($id ==$getdata['id']){
               header("Location:product.php");
            }
            else{
               $msg="Product already exist";
            }
         }
         else{
            $msg="product already exist";
         }
            
      }
     
      if ($_FILES['image']['name'] != '') {
         if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/webp') {
             $msg = "Please select only PNG, JPG,webp or JPEG formats.";
         }
     }

      if($msg=='')
        {
            if(isset($_GET['id']) && $_GET['id'] != '')
            {
               if ($_FILES['image']['name'] != '') {
                  $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                  move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH. $image);
                  $update_sql = "UPDATE product SET categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword', image='$image' WHERE id='$id'";
              } 
              else {
                  $update_sql = "UPDATE product SET categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword' WHERE id='$id'";
              }
                mysqli_query($con,$update_sql);
            }
            else
            {
               $image = rand(111111111, 999999999) . '_' . basename($_FILES['image']['name']);
               $target_file = PRODUCT_IMAGE_SERVER_PATH. $image;
               
               // Check if the directory exists, if not create it
               if (!is_dir('../media/product/')) {
                   mkdir('../media/product/', 0777, true);
               }
               move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
               mysqli_query($con,"INSERT INTO product(categories_id,name,mrp,price,qty,short_desc,description,meta_title,meta_desc,meta_keyword,status,image)
               values('$categories_id','$name','$mrp','$price','$qty','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword',1,'$image')");
            }
            header("Location:product.php");
            die();
        }
      
    }
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form action="" method="POST" enctype="multipart/form-data">
                           <div class="card-body card-block">
                              <div class="form-group">
                                <label for="company" class=" form-control-label">Category</label>
                                <select name="categories_id" id="" class="form-control">
                                    <option value="">Select category</option>
                                        <?php
                                            $res = mysqli_query($con, "SELECT id, categories FROM categories ORDER BY categories DESC");
                                            while($row = mysqli_fetch_assoc($res)) {
                                                if($row['id']==$categories_id){
                                                    echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                                                }else{
                                                    echo "<option value='".$row['id']."'>".$row['categories']."</option>";
                                                }
                                            }
                                        ?>
                                </select>
                                </div>
                              <div class="form-group">
                                 <label for="name" class=" form-control-label">Product Name</label>
                                 <input type="text" name="name" placeholder="Enter product name" class="form-control" value="<?php echo $name?>"required>
                              </div>
                              <div class="form-group">
                                 <label for="mrp" class=" form-control-label">MRP</label>
                                 <input type="text" name="mrp" placeholder="Enter mrp" class="form-control" value="<?php echo $mrp?>"required>
                              </div>
                              <div class="form-group">
                                 <label for="price" class=" form-control-label">price</label></label>
                                 <input type="text" name="price" placeholder="Enter price" class="form-control" value="<?php echo $price?>"required>
                              </div>
                              <div class="form-group">
                                 <label for="qty" class=" form-control-label">qty</label>
                                 <input type="text" name="qty" placeholder="Enter qty" class="form-control" value="<?php echo $qty?>"required>
                              </div>
                              <div class="form-group">
                                 <label for="image" class=" form-control-label">image</label>
                                 <input type="file" name="image" class="form-control" <?php echo $image_required?>>
                              </div>
                              <div class="form-group">
                                 <label for="short_desc" class=" form-control-label">short desc</label>
                                 <textarea name="short_desc" placeholder="Enter Short description" class="form-control"required><?php echo $short_desc?></textarea>
                              </div>
                              <div class="form-group">
                                 <label for="description" class=" form-control-label">description</label>
                                 <textarea name="description" placeholder="Enter description" class="form-control"required><?php echo $description?></textarea>
                              </div>
                              <div class="form-group">
                                 <label for="meta_title" class=" form-control-label">meta title</label>
                                 <input type="text" name="meta_title" placeholder="Enter meta title" class="form-control" value="<?php echo $meta_title?>"required>
                              </div>
                              <div class="form-group">
                                 <label for="meta_desc" class=" form-control-label">meta desc</label>
                                 <input type="text" name="meta_desc" placeholder="Enter meta desc" class="form-control" value="<?php echo $meta_desc?>"required>
                              </div>
                              
                              <div class="form-group">
                                 <label for="meta_keyword" class=" form-control-label">meta keyword</label>
                                 <textarea name="meta_keyword" placeholder="Enter meta keyword" class="form-control"><?php echo $meta_keyword?></textarea>
                              </div>
                              <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" name="submit">
                              <span id="payment-button-amount">Submit</span>
                              </button>
                              <div class="text-danger mt-4"><?php echo $msg?></div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
</div>

<?php
require('footer.inc.php');
?>