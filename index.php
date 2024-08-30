<!DOCTYPE html>
<html lang="<?php bloginfo("language"); ?>">
<?php
 get_template_part("parts/head");
?>
<body>
    <div class="halloween-wrapper">
        <?php
            get_template_part("parts/header");
        ?>
             <main class="halloween-main">

                    <?php 
                      if ( have_posts() ) {
	                    while ( have_posts() ) {
		                  the_post(); 

                             the_title("<h1 class= 'halloween-headeing'>", "</h1>");
                             the_content();
	                    } // end while
                         }
                         else{

                          echo "Page not found";
                        }
                    ?>
             </main>

       <?php
        get_template_part("parts/footer");
       ?>

    </div>
</body>
</html>