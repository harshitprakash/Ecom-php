<?php
require('top.inc.php');
require('admin_auth.php');

auth();


$title='';
$sub_title='';
$image_url='';
$image='';
$msg='';
$image_required='required';
if(isset($_GET['id']) && $_GET['id'] !='')
{
  $image_required='';
  $id=get_safe_value($con,$_GET['id']);
  $res=mysqli_query($con,"SELECT * FROM home_banner WHERE id='$id'");
  $check=mysqli_num_rows($res);
  if($check>0)
     {
        $row=mysqli_fetch_assoc($res);
        $title=$row['title'];
        $sub_title=$row['sub_title'];
        $image_url=$row['image_url'];
        $image=$row['image'];
     }
  else{
     header("Location: product.php");
     die();
  }
}

if(isset($_POST['submit']))
{
  $title=get_safe_value($con,$_POST['title']);
  $sub_title=get_safe_value($con,$_POST['sub_title']);
  $image_url=get_safe_value($con,$_POST['image_url']);
  $image = ''; // Initialize $image variable


  $res=mysqli_query($con,"SELECT * FROM home_banner WHERE title='$title'");
  $check=mysqli_num_rows($res);

  if($check>0)
  {
     if(isset($_GET['id']) && $_GET['id'] != ' '){
        $getdata= mysqli_fetch_assoc($res);
        if($id ==$getdata['id']){
           header("Location:home_banner.php");
        }
        else{
           $msg="Title already exist";
        }
     }
     else{
        $msg="Title already exist";
     }
        
  }
 
  if ($_FILES['image']['name'] != '') {
     if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
         $msg = "Please select only PNG, JPG, or JPEG formats.";
     }
 }

  if($msg=='')
    {
        if(isset($_GET['id']) && $_GET['id'] != '')
        {
           if ($_FILES['image']['name'] != '') {
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
                  }
           }
              $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'],HOME_BANNER_IMAGE_SERVER_PATH. $image);
              mysqli_query($con,"UPDATE home_banner SET title='$title',sub_title='$sub_title',image_url='$image_url',image='$image' WHERE id='$id'");
            }
          else {
            mysqli_query($con,"UPDATE home_banner SET title='$title',sub_title='$sub_title',image_url='$image_url' WHERE id='$id'");

          }
          
        }
        else
        {
           $image = rand(111111111, 999999999) . '_' . basename($_FILES['image']['name']);
           $target_file = HOME_BANNER_IMAGE_SERVER_PATH. $image;
           
           // Check if the directory exists, if not create it
           if (!is_dir('../media/banner/')) {
               mkdir('../media/banner/', 0777, true);
           }
           move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
           mysqli_query($con,"INSERT INTO home_banner(title,sub_title,image_url,image)
           values('$title','$sub_title','$image_url','$image')");
        }
        header("Location:home_banner.php");
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
                                 <label for="title" class=" form-control-label">Title</label>
                                 <input type="text" name="title" placeholder="Enter Title" class="form-control" value="<?php echo $title?>"required>
                              </div>
                              <div class="form-group">
                                 <label for="sub_title" class=" form-control-label">SUb Title</label>
                                 <input type="text" name="sub_title" placeholder="Enter sub_title" class="form-control" value="<?php echo $sub_title?>"required>
                              </div>
                              <div class="form-group">
                                 <label for="image_url" class=" form-control-label">Product Link </label>
                                 <input type="url" name="image_url" placeholder="Enter image URL" class="form-control" value="<?php echo $image_url?>"required>
                              </div>

                              <div class="form-group">
                                 <label for="image" class=" form-control-label">image</label>
                                 <input type="file" name="image" class="form-control">
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