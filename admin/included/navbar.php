
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">SHANTUS BOUTIQUE</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

       <li><a href="brands.php">Brands</a></li>
       <li><a href="categories.php">Categories</a></li>
       <li><a href="products.php">Products</a></li>
       <li><a href="archived.php">Archived</a></li>
        <li><a href="members.php">Users</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['admin_user_name'];?><span class="caret"></span></a>
          <ul class="dropdown-menu">
             <li><a href="../index.php">Visit Shop</a></li>
           
            <li><a href="logout.php">log out</a></li>
           
          </ul>
        </li>
      </ul>
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

      <!-- END NAVBAR -->

     <!-- START Page Body -->

      

          <div class="container">