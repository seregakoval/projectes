</section> <!-- #page -->
        <!-- begin footer -->
        <footer>        
        <div class="wrapper">
            <?php if(of_get_option('twitter')) { ?>
                <a href="<?php echo of_get_option('twitter');?>" class="social twitter"><i class="fa fa-twitter"></i></a>
            <?php } ?>  
            <?php if(of_get_option('facebook')) { ?>
                <a href="<?php echo of_get_option('facebook');?>" class="social facebook"><i class="fa fa-facebook"></i></a>
            <?php } ?>  
            <?php if(of_get_option('googleplus')) { ?>
                <a href="<?php echo of_get_option('googleplus');?>" class="social googleplus"><i class="fa fa-google-plus"></i></a>
            <?php } ?>    
            <?php if(of_get_option('github')) { ?>
                <a href="<?php echo of_get_option('github');?>" class="social github"><i class="fa fa-github"></i></a>
            <?php } ?>  
            <?php if(of_get_option('dribbble')) { ?>
                <a href="<?php echo of_get_option('dribbble');?>" class="social dribbble"><i class="fa fa-dribbble"></i></a>
            <?php } ?>          
        </div>
        <!-- begin .copyright -->
        <div class="copyright">


            <?php if(of_get_option('footer_copyright') !='' ) { ?>
                <?php echo of_get_option('footer_copyright')  ?><br>
            <?php } ?>
            <!-- Site5 Credits-->
            Работает на <a href="http://atempl.com/shablony-wordpress" title="Шаблоны WordPress">WordPress</a>
            <!-- end Site5 Credits-->

        </div>
        <!-- end .copyright -->
        </footer>
    <!-- wp_footer -->
    <?php wp_footer(); ?>
    <!-- wp_footer -->
    </body>
</html>