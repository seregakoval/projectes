<?php get_header(); ?>

	<div class="large_intro recipeshead" style="background-size: cover; background-attachment: fixed; background-image: url(<?php $get = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full'); if($get[0]!="") : echo $get[0]; else: echo get_stylesheet_directory_uri().'/img/large.jpg'; endif;?>   );">
		<h1><?php the_title(); ?></h1>
	</div>

	<!-- begin main -->
	<section class="main">

		<!-- begin .col-left -->
		<div class="col-left">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<!-- begin .post -->
				<article <?php post_class(); ?>>

				<?php the_content(); ?>

			<?php endwhile; ?>
				<?php comments_template(); ?>

				</article>
				<!-- end .post -->

			<?php endif;?>

		</div>
		<!-- end colleft -->
	</section>
	<!-- end main -->

	<div class="clear"></div>
<?php get_footer(); ?>