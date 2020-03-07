<?php
    
    $stmt = $connec->prepare("SELECT * FROM  categories  where parent=0");
    $stmt->execute();
    $parents = $stmt->fetchAll();
   
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
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
         
                    <li><a href="#"><?php echo $child['category'] ?></a></li>

           
            <?php  }  ?>
           
          </ul>
        </li>

        <?php  }  ?>
      </ul>
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

