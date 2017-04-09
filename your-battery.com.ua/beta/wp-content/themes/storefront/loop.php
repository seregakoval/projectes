<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); // Цикл начинается. Если есть записи в цикле, то выводим их ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="wrap" style="display: flex;
  justify-content: space-between;
  align-items: center;">
            <div class="img" style="float: left;width:30%;">
                <?php echo get_the_post_thumbnail( $page->ID, 'thumbnail'); ?>
                <div class="post-info">
                    <p style="font-size: 14px;">Опубликовано: <?php echo get_the_date(); ?></p>
                </div>
            </div>
            <div class="content-post" style="float: right;width:65%;">
                <h2 style="line-height: 20px; border-bottom: 1px solid #fcd708;padding-bottom: 15px;"><a style="color:#2c2d33;font-size: 22px;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><!-- Выводим заголовок записи -->
                <div class="content">
                    <?php the_content("Читать далле"); ?>
                </div>
            </div>
        </div>

    </div>

<?php endwhile; else: ?>
    <p><?php echo 'Извините, записей нет'; ?></p>
<?php endif; ?>
<?php the_posts_pagination(); ?>
<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: http://codex.wordpress.org/The_Loop
 *
 * @package storefront
 */

//do_action( 'storefront_loop_before' );
//
//while ( have_posts() ) : the_post();
//
//	/**
//	 * Include the Post-Format-specific template for the content.
//	 * If you want to override this in a child theme, then include a file
//	 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
//	 */
//	get_template_part( 'content', get_post_format() );
//
//endwhile;
//
///**
// * Functions hooked in to storefront_paging_nav action
// *
// * @hooked storefront_paging_nav - 10
// */
//do_action( 'storefront_loop_after' );
