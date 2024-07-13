<div class="clearfix"></div>
<footer class="site-footer">
            <div class="footer-inner bg-white">
               <div class="row">
                  <div class="col-sm-6">
                     Copyright &copy; <?php echo date('Y')?> Harshit Prakash 
                  </div>
                  <div class="col-sm-6 text-right">
                     Designed by <a href="https://colorlib.com/">Colorlib</a>
                  </div>
               </div>
            </div>
         </footer>
      </div>
      <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this item?")) {
                // Redirect to the deletion URL or perform deletion action
                window.location.href = '?type=delete&id=' + id;
                return true; // Continue with the link action
            } else {
                return false; // Cancel the link action
            }
        }
    </script>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>