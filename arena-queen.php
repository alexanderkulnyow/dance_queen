<?php
/**
 * Plugin Name: Dance Queen
 * Description: Добавление типа записи "Королева танцпола", генерация qr-кода для проверки перехода на страницу. Запись удаляется автоматически по указанной дате. Кнопка проверить срабаытвает раз в 8 часов.
 * Plugin URI:  https://github.com/alexanderkulnyow/dance_queen
 * Author URI:  https://dds.by/
 * Author:      alexander kulnyow
 *
 * Text Domain: arena-queen
 * Domain Path: Путь до MO файла (относительно папки плагина)
 *
 * Requires PHP: 5.4
 * Requires at least: 2.5
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Version:     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}// Exit if accessed directly



/*
|--------------------------------------------------------------------------
| Define plugin constants
|--------------------------------------------------------------------------
*/
defined( 'ARENA_QUEEN_FILE' ) || define( 'ARENA_QUEEN_FILE', __FILE__ );
defined( 'ARENA_QUEEN_DIR' ) || define( 'ARENA_QUEEN_DIR', plugin_dir_path( ARENA_QUEEN_FILE ) );

require_once ARENA_QUEEN_DIR . 'functions.php';

/*
|--------------------------------------------------------------------------
| Define plugin templates
|--------------------------------------------------------------------------
*/
add_filter( 'template_include', 'filter_function_name_11' );
function filter_function_name_11( $template ) {
	if( is_singular('queen')  ){
		if ( $new_template = ARENA_QUEEN_DIR . 'templartes/single-queen.php' )
			$template = $new_template ;
	}
	return $template;
}
