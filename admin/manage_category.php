<?php
    require('top.inc.php');
    require('admin_auth.php');

    auth();
    
    $categories='';
    $msg='';
   if(isset($_GET['id']) && $_GET['id'] !='')
   {
      $id=get_safe_value($con,$_GET['id']);
      $res=mysqli_query($con,"SELECT * FROM categories WHERE id='$id'");
      $check=mysqli_num_rows($res);
      if($check>0)
         {
            $row=mysqli_fetch_assoc($res);
            $categories=$row['categories'];
         }
      else{
         header("Location: categories.php");
         die();
      }
   }

   if(isset($_POST['submit']))
   {
      $categories=get_safe_value($con,$_POST['categories']);

      $res=mysqli_query($con,"SELECT * FROM categories WHERE categories='$categories'");
      $check=mysqli_num_rows($res);

      if($check>0)
      {
         if(isset($_GET['id']) && $_GET['id'] != ' '){
            $getdata= mysqli_fetch_assoc($res);
            if($id ==$getdata['id']){
               header("Location:categories.php");
            }
            else{
               $msg="Category already exist";
            }
         }
         else{
            $msg="Category already exist";
         }
            
      }
      else
      {
            if(isset($_GET['id']) && $_GET['id'] !=' ')
            {
               mysqli_query($con,"UPDATE categories set categories='$categories' where id='$id'");
            }
            else
            {
               mysqli_query($con,"INSERT into categories(categories,status) values('$categories',1)");
            }
            header("Location:categories.php");
            die();
            }
      
   }
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Category</strong><small> Form</small></div>
                        <form action="" method="POST">
                           <div class="card-body card-block">
                              <div class="form-group">
                                 <label for="company" class=" form-control-label">Category</label>
                                 <input type="text" name="categories" placeholder="Enter Category" class="form-control" value="<?php echo $categories?>" required>
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