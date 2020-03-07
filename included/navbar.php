<?php
   
   session_start();
    $stmt = $connec->prepare("SELECT * FROM  categories  where parent=0");
    $stmt->execute();
    $parents = $stmt->fetchAll();
   
?>

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

        <?php   foreach ($parents as $parent) {  ?>
        
       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $parent['category']; ?><span class="caret"></span></a>

           <ul class="dropdown-menu">

         <?php
              
                $stmt = $connec->prepare("SELECT * FROM  categories  where parent=?");
                $stmt->execute(array($parent['cat_id']));
                $childs = $stmt->fetchAll();

               foreach ($childs as $child) {?>
         
                    <li><a href="category.php?catid=<?php echo $child['cat_id']; ?>"><?php echo $child['category'] ?></a></li>

           
            <?php  }  ?>
           
          </ul>
        </li>

        <?php  }  ?>


         <?php
               if(isset($_SESSION['buser_name'])) {?>

         <ul class="nav navbar-nav navbar-right">
                 <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['buser_name'];?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href='profile.php'>My Profile</a></li>
            <li><a href='newad.php'>Add Item</a></li>
              <li><a href='profile.php#myads'>My Items</a></li>
            <li> <a href='logout.php'>Logout</a></li>

          </ul>
        </li>

        </ul>

              
                  
                  

                    

                  
             <?php   }

                else {

            ?>
   
        <ul class="nav navbar-nav navbar-right">
           <li> <a href="my_cart.php"><i class="fa fa-shopping-cart fa-fw"></i>My Cart</a></li>
         </ul>
          






         <?php } ?>
  
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

   

   <!--  <div class="header">
        <div class="logo"></div>
     </div>

     END HEADER -->

     <!-- START FEATURES -->

      

          <div class="container-fluid">