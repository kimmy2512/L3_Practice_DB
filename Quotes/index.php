    <!DOCTYPE HTML>

<html lang="en">

<?php include("content/head.php"); ?>
    
<body>
    
    <div class="wrapper">
    
            <?php include("content/heading_navigation.php"); ?>
        
        <div class="box main">

            <?php 

            if(!isset($_REQUEST['page'])) {
                include("content/home.php");
            }     // end of if that includes home page

            else {
                // prevents users from navigating through file system
                $page=preg_replace('/[^0-9a-zA-Z]-/','',$_REQUEST['page']);
                include("content/$page.php");

            }    // end of else that includes requested content
            
            ?>

        </div>    <!-- / main -->
        
        <?php include("content/footer.php"); ?>
    
    </div>  <!-- / wrapper  -->
    
</body>        
