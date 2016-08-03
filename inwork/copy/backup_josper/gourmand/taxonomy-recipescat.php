<?php
/*
Template Name: Recipes
*/
get_header(); 
global $post, $wpdb;
$term =	$wp_query->queried_object->name
?>
    <div class="large_intro recipeshead" style="background-size: cover; background-attachment: fixed; background-image: url(<?php if(of_get_option('homepageimg')) : echo of_get_option('homepageimg'); else: echo get_stylesheet_directory_uri().'/img/large.jpg'; endif;?>  );">
	<h1><?php echo $wp_query->queried_object->name; ?> Collection</h1>
    </div>     
    <!-- begin main -->
    <section class="main">
	
        <!-- begin .col-left -->
        <div class="col-left">
		
		<h3 class="recipetitle">Currently browsing : <strong><?php echo $wp_query->queried_object->name; ?> (<?php $recipecount = get_queried_object(); echo $recipecount->count; ?>)</strong></h3>

			<div class="recipescollection">
				                      
				<?php 
					
						$featuredrecipes_paged = $paged;
						$the_query = new WP_Query("order=DESC&orderby=date&post_type=recipes&recipescat={$term}&paged={$featuredrecipes_paged}&posts_per_page=-1");
					
						echo '<ul>';
						if (have_posts()) :  while ( $the_query->have_posts() ) : $the_query->the_post();
						
						global $post;
						
					
						$cooktime = get_post_meta($post->ID,'gourmand_cooktime',true);
						$difficulty = get_post_meta($post->ID,'gourmand_difficulty',true);

							echo '<li>';
							echo '<div class="recipescollection_pic"><a href="'.get_the_permalink().'">';
								if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(),'recipes-item');
							echo '</a><span class="recipesitem"><i class="fa fa-cutlery"></i></span></div>';
							echo '<div class="entry_details">';
							echo '<h4><a href="'.get_the_permalink().'">' . get_the_title() . '</a></h4>';
							echo '<span class="cooktime"><i class="fa fa-clock-o"></i> ' . $cooktime . '</span> <span class="difficulty"><strong>Difficulty:</strong> ' . $difficulty . '</span>';
							if(function_exists('the_ratings')) { the_ratings(); };
							//echo ''.the_excerpt(15).'';
							echo '</div>';
							echo '</li>';
							endwhile;  wp_reset_postdata();
						echo '</ul>';

					
				?>
				
				
			</div>

        <!-- begin #pagination -->
        <?php if (function_exists("emm_paginate")) {
                emm_paginate();
             } else { ?>
        <div class="navigation">
            <div class="alignleft"><?php next_posts_link('Older') ?></div>
            <div class="alignright"><?php previous_posts_link('Newer') ?></div>
        </div>
        <?php } ?>
        <!-- end #pagination -->


        </div>
        <!-- end colleft -->
		
		<?php endif;?>

       <?php get_sidebar(); ?>

    </section>
    <!-- end main -->

<div class="clear"></div>
<?php get_footer(); ?>