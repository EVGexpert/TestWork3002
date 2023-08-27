<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'yousite_wp11' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'yousite_wp11' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '&8q1*5hJI' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'rDwxJnAQ6J{q{DH<dX[EJGmeF;8e2qMkKX-A&/%D4Ym?]pjML&0EB~W-q/i22rc!' );
define( 'SECURE_AUTH_KEY',  'oZ%aN&9z#||>;rMoWD(v4DwvBxQg|tqsclJ&m,C&w1l34gC1RT:=Z1Bm)Qtci`pl' );
define( 'LOGGED_IN_KEY',    '}Oy8b){.1N4a5r!_rgY]SNBXbqB+]w~!DJ P;&HHji1FSe71d,l/EuESE0Q&YJI%' );
define( 'NONCE_KEY',        'C-^8n}{!W) ~1~P*p5koYVEk@;eMllpNizO4S>t_T$#;DE(c f0!3CE&8w--?p,k' );
define( 'AUTH_SALT',        'NphlggWPq/|}nKC|tn`yC2}LHjRI !#&cJ9|oVdE.T7X0gBx7*mApk1`!-U&CI3R' );
define( 'SECURE_AUTH_SALT', 'fkm4:I%D$uWtpJUV08<r=ncT1yikI.;86B*I/qlqU28WU)m0.9/$j`$EQ4ZiTJxx' );
define( 'LOGGED_IN_SALT',   'tf$Fc{oS[wq5A&D2l0B:X]qQ#46Sww~c~*(o.lCRE&0$oz}m|r&G-EzZ>o-o$GWo' );
define( 'NONCE_SALT',       ';~%4IZgG&*Y_P(T4Uq9$_Az8b7Bkyce+9_o{(9gavO`@b=zd*cg+#D2M@>(wPHs2' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true);

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
