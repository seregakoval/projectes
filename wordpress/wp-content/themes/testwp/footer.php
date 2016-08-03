<div class="top-f mobile">
    <h1>Остались вопросы?</h1>
    <p class="sub-text footer-modal">Задайте их нашему специалисту</p>
</div>
<div class="footer  mobile clearfix">
    <div class="bottom-block clearfix">
        <div class="nav">
            <?php wp_nav_menu(); ?>
        </div>
        <div class="tel">
            <p><a href="whatsapp://send?text=Hello%20World!"><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp-black.png" alt=""></span></a><a
                    href="viber://calls"><span><img src="<?php bloginfo("template_directory"); ?>/img/tel-black.png" alt=""></span></a>8 923 460 8362</p>
            <div style="clear: both;"></div>
            <p><a href="whatsapp://send?text=Hello%20World!"><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp-black.png" alt=""></span></a><a
                    href="viber://calls"><span><img src="<?php bloginfo("template_directory"); ?>/img/tel-black.png" alt=""></span></a>8 950 574 2861</p>
        </div>
        <a href="#" class="cell-btn">Заказать звонок</a>
    </div>
</div>
<div id="modal_form4">
    <div class="form" style="padding-top:20px;height: 438px;">
        <form action="javascript:void(null);" id="modal4">
            <h1 style="margin-top:5px;margin-bottom:7px;">Оставьте заявку</h1>
            <p class="sub-text">наш специалист свяжется с Вами в ближайшее время</p>
            <input type="text" placeholder="Имя" name="name" required>
            <input type="text" placeholder="Телефон" name="mail_subject" required>
            <textarea name="message" placeholder="Ваш вопрос" id="textarea-footer" cols="30" rows="10"></textarea>
            <input type="submit" class="form2-sub" value="Оставить заявку">
        </form>
    </div>
</div>
<div id="overlay"></div>
<?php wp_footer(); ?>
    </body>
    </html>