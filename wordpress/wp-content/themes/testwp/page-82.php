<?php get_header(); ?>
<div class="header contact">
    <div class="wrapper">
        <div class="top clearfix">
            <div class="nav">
                <?php wp_nav_menu(); ?>
            </div>
            <div class="tel">
                <p><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp.png" alt=""></span><span><img src="<?php echo get_template_directory_uri(); ?>/img/tel.png" alt=""></span>8 923 460 8362</p>
                <div style="clear: both;"></div>
                <p><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp.png" alt=""></span><span><img src="<?php echo get_template_directory_uri(); ?>/img/tel.png" alt=""></span>8 950 574 2861</p>
            </div>
        </div>
        <div class="title">
            <h1>Галерея</h1>
        </div>
    </div>
</div>
<div class="gallery-block clearfix">
    <div class="center">
        <?php get_sidebar(); ?>
        <div class="right-gallery">
            <?php query_posts( array('cat'=>6, 'paged'=>get_query_var('paged'), 'posts_per_page'=>'9' ) ); ?>
            <?php
            while (have_posts()) : the_post();?>
                <div class="box">
                    <?php
                    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');?>
                    <a target="_blank" href="<?php echo $image_url[0]; ?>"><?php echo get_the_post_thumbnail($id, array(230,180));?></a>
                    <?php the_content(); ?>
                </div>

                <?php
            endwhile;
            wp_pagenavi();
            /* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
            wp_reset_query();
            ?>
        </div>
    </div>
</div>
</div>
<div class="form-block clearfix gallery-bg">
    <div class="wrapper">
        <div class="left-content">
            <h1>мы можем изготовить <br>
                изделие индивидуально</h1>
            <p class="sub-text">Оставьте заявку и получите стоимость изделия</p>
            <div class="button clearfix">
                <a href="#" class="button1">Написать в Viber</a>
                <a href="#" class="button1">Написать в Whats App</a>
            </div>
        </div>
        <div class="form">
            <h1>Заявка на расчет</h1>
            <form action="javascript:void(null);"   id="ajaxform">
                <input type="text" placeholder="Ваше Имя" name="name">
                <input type="text" placeholder="Ваш Телефон" name="mail_subject">
                <p class="text-f">Прикрепить фотографии:</p>
                <div class="photo clearfix">
                    <div class="upload-file-container">
                        <img id="image">
                        <div class="upload-file-container-text">
                            <span></span>
                            <input type="file" name="mail_file" class="photo" id="imgInput1" />
                        </div>
                    </div>
                    <div class="upload-file-container">
                        <img id="image2">
                        <div class="upload-file-container-text">
                            <span></span>
                            <input type="file" name="mail_file" class="photo" id="imgInput2" />
                        </div>
                    </div>
                    <div class="upload-file-container">
                        <img id="image3">
                        <div class="upload-file-container-text">
                            <span></span>
                            <input type="file" name="mail_file" class="photo" id="imgInput3" />
                        </div>
                    </div>
                    <div class="upload-file-container">
                        <img id="image4">
                        <div class="upload-file-container-text">
                            <span></span>
                            <input type="file" name="mail_file" class="photo" id="imgInput4" />
                        </div>
                    </div>
                    <!--<ul>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/photo.png" alt=""></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/photo.png" alt=""></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/photo.png" alt=""></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/photo.png" alt=""></a></li>
                    </ul>-->
                </div>
                <div class="input">
                    <input type="text" placeholder="Размер" name="size">
                    <input type="text" placeholder="Вес" name="ves">
                </div>
                <input type="submit" value="Рассчитать" class="submit">
            </form>
        </div>
    </div>
</div>
<?php get_footer(); ?>
