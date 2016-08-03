<?php get_header(); ?>
<div class="header mobile">
    <div class="wrapper">
        <div class="top clearfix">
            <div class="nav">
                <?php wp_nav_menu(); ?>
            </div>
            <div class="tel">
                <p class="but-left"><a href="whatsapp://send?text=Hello%20World!"><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp.png" alt=""></span></a><a
                        href="viber://calls"><span><img src="<?php echo get_template_directory_uri(); ?>/img/tel.png" alt=""></span></a>8 923 460 8362</p>
                <div style="clear: both;"></div>
                <p><a href="whatsapp://send?text=Hello%20World!"><span><img src="<?php bloginfo("template_directory"); ?>/img/whatsapp.png" alt=""></span></a><a
                        href="viber://calls"><span><img src="<?php echo get_template_directory_uri(); ?>/img/tel.png" alt=""></span></a>8 950 574 2861</p>
            </div>
        </div>
        <div class="text-header">
            <h1>Покупаем бивни мамонта, <br>
                рога и клыки древних животных</h1>
            <p class="sub-text">Скупка бивней мамонта, рогов шерстистого носорога, клыков моржа, рогов лося и оленя <br class="br">
                и их фрагментов с самовывозом и предварительной оценкой <br class="br">
                по фото в течение 15 минут </p>
        </div>
        <div class="buttons clearfix">
            <a href="#" class="but-left btn">Оценить по фото</a>
            <a href="#" class="but-right btn2">Получить консультацию</a>
        </div>

    </div>
</div>

<div class="header_content">
</div>
<div class="sell  mobile clearfix">
    <h1>Мы продаем</h1>
    <p class="sub-text">Коллекционные бивни, клыки, рога, их фрагменты и бой</p>
    <div class="boxes clearfix">
        <div class="box">
            <img src="<?php echo get_template_directory_uri(); ?>/img/img1.jpg" alt="">
            <p>Бивни мамонта</p>
        </div>
        <div class="box">
            <img src="<?php echo get_template_directory_uri(); ?>/img/img2.jpg" alt="">
            <p>Клыки моржа</p>
        </div>
        <div class="box">
            <img src="<?php echo get_template_directory_uri(); ?>/img/img3.jpg" alt="">
            <p>Рога шерстистого носорога</p>
        </div>
        <div class="box">
            <img src="<?php echo get_template_directory_uri(); ?>/img/img4.jpg" alt="">
            <p>Рога лосей и Оленей</p>
        </div>
    </div>
</div>
    <div class="wrap-block">
        <div class="block-work">
            <div class="work clearfix">
                <h1>Как мы работаем?</h1>
                <p class="sub-text">Мы занимаемся скупкой не для последующей перепродажи, а для изготовления красивых <br>
                    и качественных изделий</p>
                <div class="content clearfix">
                    <div class="left-content">
                        <h2>01. Свяжитесь с нами</h2>
                        <p class="text">Вам необходимо оставить заявку по телефону 8 923 460 8362 <br> или на нашем сайте, специалист свяжется с Вами в ближайшее время.</p>
                        <a href="#" class="btn">оставить заявку</a>
                        <h2>02. Отправьте фото или договоритесь о встрече</h2>
                        <p class="text">Отправьте фотографии для расчета любым удобным способом, либо договоритесь о встрече с нашим специалистом и договоритесь о цене</p>
                        <h2>03. Получите оплату</h2>
                        <p class="text">Мы производим оплату наличными при встрече или перечисляем на банковскую карту или указанный Вами счет</p>
                        <h2>04. Отправьте или передайте материал</h2>
                        <p class="text">Передайте материал нашим специалистам (при самовывозе) или отправьте любой удобной транспортной компанией</p>
                    </div>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/img5.png" class="img" alt="">
                </div>
            </div>
        </div>
    </div>
<div class="form-block mobile clearfix">
    <div class="wrapper">
        <div class="left-content">
            <h1>Отправьте Фотографии</h1>
            <p class="sub-text">Наш специалист свяжется с Вами и оценит дистанционно
                стоимость и качество материала в течение 15 минут</p>
            <div class="button clearfix">
                <a href="viber://calls" class="button1" >Написать в Viber</a>
                <a href="whatsapp://send?text=Hello%20World!" class="button1">Написать в Whats App</a>
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
<div class="info mobile clearfix">
    <h1>Итак, у вас есть материал</h1>
    <p class="sub-text">Почему его нужно продать именно нам?</p>
    <div class="boxes clearfix">
        <div class="box">
            <div class="img">
                <img src="<?php echo get_template_directory_uri(); ?>/img/img6.png" alt="" class="top-img">
            </div>
            <p>Мы гарантируем реальную цену <br> за материал, порядочность и <br> оплату в срок</p>
        </div>
        <div class="box">
            <div class="img">
                <img src="<?php echo get_template_directory_uri(); ?>/img/img7.png" alt="" class="top-img">
            </div>
            <p>Мы называем точную цену и не <br> пытаемся ее сбить в 2-3 раза, <br> ссылаясь на недостатки материала</p>
        </div>
        <div class="box">
            <div class="img" >
                <img src="<?php echo get_template_directory_uri(); ?>/img/img8.png" alt="">
            </div>
            <p>Мы ориентированы на <br> постоянное сотрудничество и <br> предложим спецусловия на <br> повторные продажи</p>
        </div>
    </div>
    <a href="#" class="btn-v">Начать сотрудничество</a>
</div>
<div id="modal_form2">
    <div class="form" style="padding-top:20px;height: 290px;">
        <form action="javascript:void(null);" id="modal3">
            <h1 style="margin-top:5px;margin-bottom:7px;">Оставьте заявку</h1>
            <p class="sub-text">Специалист свяжется с вами в ближайшее время</p>
            <input type="text" placeholder="Ваше Имя" name="name" required>
            <input type="text" placeholder="Ваш Телефон" name="mail_subject" required>
            <input type="submit" class="form2-sub" value="Получить консультацию">
        </form>
    </div>
</div>
<div id="modal_form4-v">
    <div class="form" style="padding-top:20px;height: 420px;">
        <form action="javascript:void(null);" id="modal4">
            <h1 style="margin-top:5px;margin-bottom:7px;">Оставьте заявку</h1>
            <p class="sub-text">Специалист свяжется с вами в ближайшее время</p>
            <input type="text" placeholder="Ваше Имя" name="name" required>
            <input type="text" placeholder="Ваш Телефон" name="mail_subject" required>
            <textarea name="message" placeholder="Введите сообщение" id="textarea-footer" cols="30" rows="10"></textarea>
            <input type="submit" class="form2-sub" value="Начать сотрудничество">
        </form>
    </div>
</div>
<div id="modal_form">
    <span id="modal_close"></span>
    <div class="form">
        <h1>Заявка на расчет</h1>
        <form action="javascript:void(null);"id="ajaxform-modal">
            <input type="text" placeholder="Ваше Имя" name="name" required>
            <input type="text" placeholder="Ваш Телефон" name="mail_subject" required>
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
<div id="overlay"></div>
<?php get_footer(); ?>
