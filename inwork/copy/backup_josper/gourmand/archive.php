<?php get_header(); 
global $post, $wpdb;
$term =	$wp_query->queried_object->name
?>
	
	<div class="large_intro artciles" style="background-size: cover; background-attachment: fixed; background-image: url(<?php if(of_get_option('homepageimg')) : echo of_get_option('homepageimg'); else: echo get_stylesheet_directory_uri().'/img/large.jpg'; endif;?>  );">
	<h1><?php echo $wp_query->queried_object->name; ?> Archive</h1>
    </div>
	
        <!-- begin main -->
		<section class="main">
		    <?php if (is_category()) { ?>
                <div id="archive-title">
                Browsing posts in: <span><?php single_cat_title(); ?></span> 
                </div>
                <?php } elseif (is_tag()) { ?> 
                <div id="archive-title">
                Posts tagged with: <span><?php single_cat_title(); ?></span>
                </div>
                <?php } elseif (is_author()) { ?> 
                <div id="archive-title">
                Browsing posts by: 
                <span>
                <?php
                   $post_tmp = get_post($post_id);
                    $user_id = $post_tmp->post_author;
                    the_author_meta('first_name',$user_id); 
                    echo "&nbsp;";
                    the_author_meta('last_name',$user_id); 
                ?>
                </span>
            </div>
            <?php } elseif (is_month()) { ?>
            <div id="archive-title">
                    Monthly Archives: <span><?php the_time('F Y'); ?></span>
            </div>
            <?php } elseif (is_year()) { ?>
            <div id="archive-title">
                   Yearly Archives: <span><?php the_time('Y'); ?></span> 
            </div>
            <?php } elseif (is_Search()) { ?>
            <div id="archive-title">
                    Search Results: <span><?php echo esc_attr(get_search_query()); ?></span> 
            </div>
            <?php } ?>
            
		
			<!-- begin .col-left -->
			<div class="col-left">
			
			

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<!-- begin .post -->
			<article <?php post_class(); ?>>
			
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					
					<!-- begin .post-meta -->
                    <div class="meta">
                        <?php echo '<span class="date">'.get_the_date('M d, Y').'</span>'; ?>

						<?php $categories_list = get_the_category_list( __( ', ', 'site5framework' ) ); if ( $categories_list) : ?> <span class="cat-links"> <?php printf( __( 'Posted in %1$s', 'site5framework' ), $categories_list ); ?> </span> <?php endif; ?>
	
						<?php echo '<a href="'.get_comments_link().'" class="comments"><i class="fa fa-comment-o"></i>
    '.get_comments_number(get_the_id()).' Комментариев</a>'; ?> 
                    </div>
                    <!-- end .post-meta -->
					
				    <!-- begin .post-thumb -->
					<div class="post-thumb">
						<?php if(has_post_thumbnail()): the_post_thumbnail('large', array('class'=>'blog-thumb')); else: ?><?php endif; ?>
					</div>
					<!-- end .post-thumb -->
					
					<!-- begin .post-meta -->
					<div class="meta">
						<?php echo '<span class="date">'.get_the_date('M d, Y').'</span><a href="'.get_comments_link().'" class="comments"><i class="fa fa-comment"></i>
 '.get_comments_number(get_the_id()).'</a>'; ?>
					</div>
					<!-- end .post-meta -->
				

					<div class="post-content">
						<?php
						global $more;
	        			$more = 0;
	        			the_content(__('Keep Reading &gt;','site5framework')); ?>
        			</div>
			</article>
			<!-- end .post -->

			<?php endwhile; ?>

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
			
			<?php endif;?>

			</div>
			<!-- end colleft -->
			
			<?php get_sidebar(); ?>
			
		</section>
		<!-- end main -->

<div class="clear"></div>
<?php get_footer(); ?>