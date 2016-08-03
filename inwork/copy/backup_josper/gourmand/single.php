<?php get_header(); ?>

		<div class="large_intro recipeshead" style="background-size: cover; background-attachment: fixed; background-image: url(<?php if(of_get_option('homepageimg')) : echo of_get_option('homepageimg'); else: echo get_stylesheet_directory_uri().'/img/large.jpg'; endif;?>  );">
		<h1>Articles</h1>
		</div>
		
		<!-- begin main -->
		<section class="main">
		
			<!-- begin .col-left -->
			<div class="col-left">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<!-- begin .post -->
				<article <?php post_class(); ?>>

                    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					
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
					<?php the_content(); ?>
					

					<?php endwhile; ?>
					<?php comments_template(); ?>

				</article>
				<!-- end .post -->

				<?php endif;?>
			
			</div>
			<!-- end colleft -->
			
			<?php get_sidebar(); ?>
			
		</section>
		<!-- end main -->

<div class="clear"></div>
<?php get_footer(); ?>