<?php
/**
 * Template Name: Корзина
 */
?>
<?php

?>
<?php get_header(); ?>
<div class="parallax-cart">
    <?php // Цикл 1
    $query1 = new WP_Query('p=177');
    while($query1->have_posts()) $query1->the_post(); ;?>
    <?php the_title(); ?>
    <?php the_content(); ?>
    <?php wp_reset_query(); ?>
</div>
<div class="wrap-cart">
    <?php while (have_posts()) : the_post() ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
