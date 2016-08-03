<?php get_header(); 
global $post, $wpdb;
$cooktime = get_post_meta($post->ID,'gourmand_cooktime',true);
$difficulty = get_post_meta($post->ID,'gourmand_difficulty',true);
?>

		<div class="large_intro recipeshead" style="background-size: cover; background-attachment: fixed; background-image: url(<?php if(of_get_option('homepageimg')) : echo of_get_option('homepageimg'); else: echo get_stylesheet_directory_uri().'/img/large.jpg'; endif;?>  );">
		<h1>Recipes Collection</h1>
		</div>
	
		<!-- begin main -->
		<section class="main">
		
			<!-- begin .col-left -->
			<div class="col-left">
			
				<div class="recipescollection">

				<?php if (have_posts()) : while (have_posts()) : the_post();?>

				<!-- begin .post -->
				<article <?php post_class(); ?>>
				
					<h1><span class="recipesitemsingle"><i class="fa fa-cutlery"></i></span> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					
					<div class="recipemeta"><span class="cooktime"><i class="fa fa-clock-o"></i> <?php echo $cooktime ?></span> <span class="difficulty"><strong>Difficulty:</strong> <?php echo $difficulty ?> <?php if(function_exists('the_ratings')) { the_ratings(); }; ?></span></div>
					
					<!-- begin .post-thumb -->
                    <div class="post-thumb">
                        <?php if(has_post_thumbnail()): the_post_thumbnail('large', array('class'=>'recipe-thumb')); else: ?><?php endif; ?>
                    </div>
                    <!-- end .post-thumb -->

                    <!-- begin .post-meta -->
                    <div class="meta">
                        Categories: <?php echo custom_taxonomies_terms_links(); ?>
                    </div>
                    <!-- end .post-meta -->

					<?php the_content(); ?>
					

					<?php endwhile; ?>
					<?php comments_template(); ?>

				</article>
				<!-- end .post -->

				<?php endif;?>
				
				</div>
				<!-- end recipescollection -->
			
			</div>
			<!-- end colleft -->
			
			<?php get_sidebar(); ?>
			
		</section>
		<!-- end main -->

<div class="clear"></div>
<?php get_footer(); ?>