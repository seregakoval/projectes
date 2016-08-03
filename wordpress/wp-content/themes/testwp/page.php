<?php get_header(); ?>
<div class="header contact">
    <div class="wrapper">
        <div class="top clearfix">
            <div class="nav">
                <?php wp_nav_menu(); ?>
                <!--<ul>
                    <li><a href="#" class="active">Главная</a></li>
                    <li><a href="#">Галерея</a></li>
                    <li><a href="#">Контакты</a></li>
                </ul>-->
            </div>
            <div class="tel">
                <p><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp.png" alt=""></span><span><img src="<?php echo get_template_directory_uri(); ?>/img/tel.png" alt=""></span>8 923 460 8362</p>
                <div style="clear: both;"></div>
                <p><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp.png" alt=""></span><span><img src="<?php echo get_template_directory_uri(); ?>/img/tel.png" alt=""></span>8 950 574 2861</p>
            </div>
        </div>
        <div class="title">
            <h1><?php wp_title("",true); ?></h1>
            <p class="sub-text" style="margin-top:0;">По фотографиям в галерее вы можете определить, каким материалом вы обладаете</p>
        </div>
    </div>
</div>
<div class="gallery-block">
    <div class="right-gallery">
    <?php while (have_posts()) : the_post() ?>
       <div class="box">
           <?php echo get_the_post_thumbnail(); ?>
           <?php the_content(); ?>
       </div>
    <?php endwhile;?>
    </div>
</div>
<div style="clear: both;"></div>
<?php get_footer(); ?>

