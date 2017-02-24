
<?php
/*
 * Template name: Шаблон записей
 */
get_header();?>


<?php while ( have_posts() ) : the_post(); ?>
    <div class="post">
        <div class="img">
            <?php get_the_post_thumbnail(); ?>
        </div>
        <div class="content-post">
            <div class="header-post">
                <h3><?php the_title(); ?></h3>
            </div>
            <div class="body-post">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
    <!--//	get_template_part( 'content', get_post_format() );-->

    <?php
endwhile;

do_action( 'storefront_loop_after' ); ?>