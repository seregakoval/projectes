<?php
/**
 * $Id: english.php 41 2009-07-23 20:50:14Z guilleva $
 * $LastChangedDate: 2009-07-23 14:50:14 -0600 (Thu, 23 Jul 2009) $
 * $LastChangedBy: guilleva $
 * Xmap by Guillermo Vargas
 * A sitemap component for Joomla! CMS (http://www.joomla.org)
 * Author Website: http://joomla.vargas.co.cr
 * Project License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Translated by www.Joom15.ru. Нашли ошибку в перевод? Пишите сюда joom15@yandex.ru. Спасибо.
*/
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if( !defined( 'JOOMAP_LANG' )) {
	define('JOOMAP_LANG', 1 );
	// -- General ------------------------------------------------------------------
	define('_XMAP_CFG_OPTIONS',			'Показать опции');
	define('_XMAP_CFG_CSS_CLASSNAME',		'Имя класса CSS');
	define('_XMAP_CFG_EXPAND_CATEGORIES',	'Раскрывать Категории');
	define('_XMAP_CFG_EXPAND_SECTIONS',	'Раскрывать Секции');
	define('_XMAP_CFG_SHOW_MENU_TITLES',	'Показать названия Меню');
	define('_XMAP_CFG_NUMBER_COLUMNS',	'Количество столбцов');
	define('_XMAP_EX_LINK',				'Помечать внешние ссылки');
	define('_XMAP_CFG_CLICK_HERE', 		'Нажмите здесь');
	define('_XMAP_CFG_GOOGLE_MAP',		'Карта сайта для Google');
	define('_XMAP_EXCLUDE_MENU',			'Исключить ID-номера Меню');
	define('_XMAP_TAB_DISPLAY',			'Показать');
	define('_XMAP_TAB_MENUS',				'Меню');
	define('_XMAP_CFG_WRITEABLE',			'Доступен для записи');
	define('_XMAP_CFG_UNWRITEABLE',		'Недоступен для записи');
	define('_XMAP_MSG_MAKE_UNWRITEABLE',	'Сделать недоступным для записи после сохранения');
	define('_XMAP_MSG_OVERRIDE_WRITE_PROTECTION', 'Игнорировать защиту от записи при сохранении');
	define('_XMAP_GOOGLE_LINK',			'Ссылка на Google');
	define('_XMAP_CFG_INCLUDE_LINK',		'Показать ссылку на автора');

	// -- Tips ---------------------------------------------------------------------
	define('_XMAP_EXCLUDE_MENU_TIP',		'Укажите ID-номера меню которые вы не хотите включать в карту сайта.<br /><strong>НЕ</strong><br />Разделяйте ID-номера запятой!');

	// -- Menus --------------------------------------------------------------------
    define('_XMAP_CFG_SET_ORDER',			'Указать порядок отображения меню)');
    define('_XMAP_CFG_MENU_SHOW',			'Показать');
    define('_XMAP_CFG_MENU_REORDER',		'Перегруппировать');
    define('_XMAP_CFG_MENU_ORDER',		'Группировать');
    define('_XMAP_CFG_MENU_NAME',			'Название Меню');
    define('_XMAP_CFG_DISABLE',			'Нажмите что бы выключить');
    define('_XMAP_CFG_ENABLE',			'Нажмите что бы включить');
    define('_XMAP_SHOW',					'Показать');
    define('_XMAP_NO_SHOW',				'Скрыть');

	// -- Toolbar ------------------------------------------------------------------
	define('_XMAP_TOOLBAR_SAVE', 			'Сохранить');
    define('_XMAP_TOOLBAR_CANCEL', 		'Отменить');

	// -- Errors -------------------------------------------------------------------
	define('_XMAP_ERR_NO_LANG',			'Языковой файл [ %s ] не найден, загружен стандартный язык: english<br />');
    define('_XMAP_ERR_CONF_SAVE',         'ERROR: Ошибка при сохранении конфигурации.');
    define('_XMAP_ERR_NO_CREATE',         'ERROR: Не возможно создать таблицу настроек');
    define('_XMAP_ERR_NO_DEFAULT_SET',    'ERROR: Не возможно применить стандартные настройки');
    define('_XMAP_ERR_NO_PREV_BU',        'WARNING: Не возможно удалить старый backup');
    define('_XMAP_ERR_NO_BACKUP',         'ERROR: Не возможно создать backup');
    define('_XMAP_ERR_NO_DROP_DB',        'ERROR: Не возможно удалить таблицу настроек');
    define('_XMAP_ERR_NO_Settings',		'ERROR: Не возможно загрузить настройки из базы данных: <a href="%s">Создать таблицу настроек</a>');

	// -- Config -------------------------------------------------------------------
	define('_XMAP_MSG_SET_RESTORED',      'Настройки восстановлены');
    define('_XMAP_MSG_SET_BACKEDUP',      'Настройки сохранены');
    define('_XMAP_MSG_SET_DB_CREATED',    'Таблица настроек создана');
    define('_XMAP_MSG_SET_DEF_INSERT',    'Применены стандартные настройки');
    define('_XMAP_MSG_SET_DB_DROPPED','Таблицы Xmapа были сохранены!');

	// -- CSS ----------------------------------------------------------------------
	define('_XMAP_CSS',					'Xmap CSS');
    define('_XMAP_CSS_EDIT',				'Редактировать шаблон'); // Edit template
	
	// -- Sitemap (Frontend) -------------------------------------------------------
	define('_XMAP_SHOW_AS_EXTERN_ALT',	'Открывать ссылки в новом окне');
	
	// -- Added for Xmap 
	define('_XMAP_CFG_MENU_SHOW_HTML',		'Показывать на сайте');
    define('_XMAP_CFG_MENU_SHOW_XML',		'Показывать на XML карте сайта');
    define('_XMAP_CFG_MENU_PRIORITY',		'Приоритет');
    define('_XMAP_CFG_MENU_CHANGEFREQ',		'Изменить частоту обновления');
    define('_XMAP_CFG_CHANGEFREQ_ALWAYS',		'Всегда');
    define('_XMAP_CFG_CHANGEFREQ_HOURLY',		'Каждый час');
    define('_XMAP_CFG_CHANGEFREQ_DAILY',		'Каждый день');
    define('_XMAP_CFG_CHANGEFREQ_WEEKLY',		'Каждую неделю');
    define('_XMAP_CFG_CHANGEFREQ_MONTHLY',		'Каждый месяц');
    define('_XMAP_CFG_CHANGEFREQ_YEARLY',		'Каждый Год');
    define('_XMAP_CFG_CHANGEFREQ_NEVER',		'Никогда');

    define('_XMAP_TIT_SETTINGS_OF',			'Настройки для %s');
    define('_XMAP_TAB_SITEMAPS',			'Карты сайта');
    define('_XMAP_MSG_NO_SITEMAPS',			'Ещё не создано ни одной карты сайта');
    define('_XMAP_MSG_NO_SITEMAP',			'Эта карта сайта недоступна');
    define('_XMAP_MSG_LOADING_SETTINGS',		'Загрузка настроек...');
    define('_XMAP_MSG_ERROR_LOADING_SITEMAP',		'Ошибка. Не могу загрузить карту сайта.');
    define('_XMAP_MSG_ERROR_SAVE_PROPERTY',		'Ошибка. Не могу сохранить настройки карты сайта.');
    define('_XMAP_MSG_ERROR_CLEAN_CACHE',		'Ошибка. Не могу очистить кэш карты сайта.');
    define('_XMAP_ERROR_DELETE_DEFAULT',		'Нельзя удалять стандартную карту сайта!');
    define('_XMAP_MSG_CACHE_CLEANED',			'Кэш был очищен!');
    define('_XMAP_CHARSET',				'UTF-8');
    define('_XMAP_SITEMAP_ID',				'ID карты сайта');
    define('_XMAP_ADD_SITEMAP',				'Добавить карту сайта');
    define('_XMAP_NAME_NEW_SITEMAP',			'Новая карта сайта');
    define('_XMAP_DELETE_SITEMAP',			'Удалить');
    define('_XMAP_SETTINGS_SITEMAP',			'Настройки');
    define('_XMAP_COPY_SITEMAP',			'Копировать');
    define('_XMAP_SITEMAP_SET_DEFAULT',			'Установить значение по умолчанию');
    define('_XMAP_EDIT_MENU',				'Опции');
    define('_XMAP_DELETE_MENU',				'Удалить');
    define('_XMAP_CLEAR_CACHE',				'Очистить кэш');
    define('_XMAP_MOVEUP_MENU',		'Вверх');
    define('_XMAP_MOVEDOWN_MENU',	'Вниз');
    define('_XMAP_ADD_MENU',		'Добавить меню');
    define('_XMAP_COPY_OF',		'Копия %s');
    define('_XMAP_INFO_LAST_VISIT',	'Последний визит');
    define('_XMAP_INFO_COUNT_VIEWS',	'Кол-во визитов');
    define('_XMAP_INFO_TOTAL_LINKS',	'Кол-во ссылок');
    define('_XMAP_CFG_URLS',		'Ссылки карты сайта');
    define('_XMAP_XML_LINK_TIP',	'Скопируйте эту ссылку и отправьте её в Google и Yandex');
    define('_XMAP_HTML_LINK_TIP',	'Это ссылка карты сайта. Вы можете её использовать для создания пунктов в меню.');
    define('_XMAP_CFG_XML_MAP',		'XML карта сайта');
    define('_XMAP_CFG_HTML_MAP',	'HTML карта сайта');
    define('_XMAP_XML_LINK',		'Ссылка Google');
    define('_XMAP_CFG_XML_MAP_TIP',	'Этот XML файл создан для поисковых машин');
    define('_XMAP_ADD', 'Сохранить');
    define('_XMAP_CANCEL', 'Отменить');
    define('_XMAP_LOADING', 'Загрузка...');
    define('_XMAP_CACHE', 'Кэш');
    define('_XMAP_USE_CACHE', 'Использовать Кэш');
    define('_XMAP_CACHE_LIFE_TIME', 'Время жизни Кэша');
    define('_XMAP_NEVER_VISITED', 'Никогда');

	// New on Xmap 1.1 beta 1
	define('_XMAP_PLUGINS','Плагины');
	define( '_XMAP_INSTALL_3PD_WARN', 'Warning: Установка сторонних дополнений может подвергнуть риску безопасность вашего сервера.' );
	define('_XMAP_INSTALL_NEW_PLUGIN', 'Установить новые Плагины');
	define('_XMAP_UNKNOWN_AUTHOR','Неизвестный автор');
	define('_XMAP_PLUGIN_VERSION','Версия %s');
	define('_XMAP_TAB_INSTALL_PLUGIN','Установить');
	define('_XMAP_TAB_EXTENSIONS','Расширения');
	define('_XMAP_TAB_INSTALLED_EXTENSIONS','Установленные Расширения');
	define('_XMAP_NO_PLUGINS_INSTALLED','Плагины не установлены');
	define('_XMAP_AUTHOR','Автор');
	define('_XMAP_CONFIRM_DELETE_SITEMAP','Вы уверены, что хотите удалить эту карту сайта?');
	define('_XMAP_CONFIRM_UNINSTALL_PLUGIN','Вы уверены, что хотите удалить этот плагин?');
	define('_XMAP_UNINSTALL','Удалить');
	define('_XMAP_EXT_PUBLISHED','Опубликован');
	define('_XMAP_EXT_UNPUBLISHED','Не опубликован');
	define('_XMAP_PLUGIN_OPTIONS','Настройки');
	define('_XMAP_EXT_INSTALLED_MSG','Расширение было успешно установлено, пожалуйста просмотрите его настройки и потом опубликуйте его.');
	define('_XMAP_CONTINUE','Продолжить');
	define('_XMAP_MSG_EXCLUDE_CSS_SITEMAP','Не использовать CSS внутри карты сайта');
	define('_XMAP_MSG_EXCLUDE_XSL_SITEMAP','Использовать классическое отображение XML карты сайта');

	// New on Xmap 1.1
	define('_XMAP_MSG_SELECT_FOLDER','Пожалуйста выберите категорию');
	define('_XMAP_UPLOAD_PKG_FILE','Загрузить Файл');
	define('_XMAP_UPLOAD_AND_INSTALL','Загрузить Файл и Установить');
	define('_XMAP_INSTALL_F_DIRECTORY','Установить из папки');
	define('_XMAP_INSTALL_DIRECTORY','Выберите папку');
	define('_XMAP_INSTALL','Установить');
	define('_XMAP_WRITEABLE','Доступен для записи');
	define('_XMAP_UNWRITEABLE','Недоступен для записи');

	// New on Xmap 1.2
	define('_XMAP_COMPRESSION','Сжатие');
	define('_XMAP_USE_COMPRESSION','Сжать XML карту сайта для экономии места');

	// New on Xmap 1.2.1
	define('_XMAP_CFG_NEWS_MAP',		'Новостная карта сайта');
	define('_XMAP_NEWS_LINK_TIP',   'Это ссылки новостной карты сайта. Вы можете использовать их для создания пунктов Вашего меню.');

    // New on Xmap 1.2.2
    define('_XMAP_CFG_MENU_MODULE',            'Модуль');
    define('_XMAP_CFG_MENU_MODULE_TIP',            'Выберите модуль, который будете использовать для показа этого меню на вашем сайте (По умолчанию: mod_mainmenu).');

	// New on Xmap 1.2.3
    define('_XMAP_TEXT',            'Текстовая ссылка');
	define('_XMAP_TITLE',            'Ссылка Тайтла');
	define('_XMAP_LINK',            'Ссылка URL');
	define('_XMAP_CSS_STYLE',            'Стиль CSS');
	define('_XMAP_CSS_CLASS',            'Класс CSS');
	define('_XMAP_INVALID_SITEMAP',            'Недействительная Карта сайта');
	define('_XMAP_OK', 'Принять');

}