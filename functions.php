<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/
add_action( 'init', 'register_queen_post_type' );
add_action( 'add_meta_boxes', 'queen_add_custom_box' );
add_action( 'save_post', 'queen_save_postdata' );
add_filter( 'manage_users_columns', 'modify_user_table' );
add_filter( 'manage_users_custom_column', 'modify_user_table_row', 10, 3 );

/*
|--------------------------------------------------------------------------
| FUNCTIONS
|--------------------------------------------------------------------------
*/
function register_queen_post_type() {
	register_post_type( 'queen', array(
		'label'              => null,
		'labels'             => array(
			'name'               => 'Королева', // основное название для типа записи
			'singular_name'      => 'Королева', // название для одной записи этого типа
			'add_new'            => 'Добавить королеву', // для добавления новой записи
			'add_new_item'       => 'Добавление королевы', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование королевы', // для редактирования типа записи
			'new_item'           => 'Новое королева', // текст новой записи
			'view_item'          => 'Смотреть королеву', // для просмотра записи этого типа.
			'search_items'       => 'Искать ____', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'menu_name'          => 'Королева', // название меню
		),
		'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		// зависит от public
		// 'exclude_from_search' => null, // зависит от public
		'show_ui'            => true,
		// зависит от public
		// 'show_in_nav_menus'   => null, // зависит от public
		'show_in_menu'       => true,
		// показывать ли в меню адмнки
		// 'show_in_admin_bar'   => null, // зависит от show_in_menu
		'show_in_rest'       => null,
		// добавить в REST API. C WP 4.7
		'rest_base'          => null,
		// $post_type. C WP 4.7
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-businesswoman',
		'capability_type'    => 'post',
//		'capabilities'      => 'menus', // массив дополнительных прав для этого типа записи
		'map_meta_cap'       => true,
		// Ставим true чтобы включить дефолтный обработчик специальных прав
		'hierarchical'       => false,
		'supports'           => [ 'title', 'thumbnail' ],
		// 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'         => array(),
		'has_archive'        => false,
		'rewrite'            => true,
		'query_var'          => true,
	) );
}


function queen_add_custom_box() {
	$screens = array( 'queen' );
	add_meta_box( 'queen_sectionid', 'Информация', 'queen_meta_box_callback', $screens );
}

function queen_meta_box_callback( $post ) {
	wp_nonce_field( 'queen_save_postdata', 'queen_noncename' );

	$key_queen_start = get_post_meta( $post->ID, 'q_start', 1 );
	$key_queen_end   = get_post_meta( $post->ID, 'q_end', 1 );
	$key_queen_phone = get_post_meta( $post->ID, 'q_phone', 1 );
	$key_queen_visit = get_post_meta( $post->ID, 'q_visit', 1 );
	?>
	<style>

	</style>
	<div class="queen__meta options_group">
		<p class="queen__meta-item">
			<label for="name_date__start">Дата начала:</label>
			<input id="name_date__start" type="date" name="name_date__start"
			       value="<?php echo $key_queen_start; ?>"/>
		</p>
		<p class="queen__meta-item">
			<label for="name_date__end">Дата окончания:</label>
			<input id="name_date__end" type="date" name="name_date__end"
			       value="<?php echo $key_queen_end; ?>"/>
		</p>
		<p class="queen__meta-item">
			<label for="name_queen__phone">Номер телефона:</label>
			<input id="name_queen__phone" type="text" name="name_queen__phone"
			       value="<?php echo $key_queen_phone; ?>"/>
		</p>
		<p class="queen__meta-item">
			<label for="name_queen__visit">Последнее посещение:</label>
			<input id="name_queen__visit" type="text" name="name_queen__visit"
			       value="<?php echo $key_queen_visit; ?>"/>
		</p>

	</div>
	<?php
}

## Сохраняем данные, когда пост сохраняется

function queen_save_postdata( $post_id ) {
	// Убедимся что поле установлено.

	if ( ! isset( $_POST['queen_noncename'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['queen_noncename'], 'queen_save_postdata' ) ) {
		return;
	}
	// если это автосохранение ничего не делаем
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// проверяем права юзера
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['name_date__start'] ) ) {
		return;
	}
	if ( ! isset( $_POST['name_date__end'] ) ) {
		return;
	}
	if ( ! isset( $_POST['name_queen__phone'] ) ) {
		return;
	}
	if ( ! isset( $_POST['name_queen__visit'] ) ) {
		return;
	}

	$data_q_start = sanitize_text_field( $_POST['name_date__start'] );
	$data_q_end   = sanitize_text_field( $_POST['name_date__end'] );
	$data_q_phone = sanitize_text_field( $_POST['name_queen__phone'] );
	$data_q_visit = sanitize_text_field( $_POST['name_queen__visit'] );

	update_post_meta( $post_id, 'q_start', $data_q_start );
	update_post_meta( $post_id, 'q_end', $data_q_end );
	update_post_meta( $post_id, 'q_phone', $data_q_phone );
	update_post_meta( $post_id, 'q_visit', $data_q_visit );
}

//add_action( 'queen__date_init', 'queen__date' );
function queen__date() {
	date_default_timezone_set( 'Europe/Minsk' );
	$last_visit_str    = get_post_meta( get_the_ID(), 'q_visit', true );
	$last_visit_date   = strtotime( $last_visit_str );
	$current_time_str  = date( "d.m.Y H:i" );
	$current_time_date = strtotime( $current_time_str );
	$next_visit_date   = $last_visit_date + ( 1 * 60 );
	$next_visit_str    = date( "d.m.Y H:i", $next_visit_date );

	if ( $current_time_date > $next_visit_date ) {

		?>
		<script>

		</script>
		<form name="form_name" method="POST" action="">
			<div class="d-flex align-items-center">
				<label style="color: white; padding-right: 5px; margin-bottom: 0;" for="checkbox_queen">Отметить
					посещение: </label>
				<input id="checkbox_queen" type="checkbox" name="f" required/>
			</div>

			<br>
			<input type="submit" class="arena__button" name="f1" value="Отправить"/>
		</form>
		<?php

		if ( isset( $_POST['f'] ) ) {
			$current_time_str = date( "d.m.Y H:i" );
			update_post_meta( get_the_ID(), 'q_visit', $current_time_str );
		}


	} else {
		echo "<p>Следующее посещение возможно: $next_visit_str  </p> ";
	}
}


/*
 * admin panel additional rows
 */


add_filter( 'manage_queen_posts_columns', function ( $columns ) {
	unset( $columns['date'] );

	$my_columns = [
		'start_date'   => 'Дата начала',
		'end_date'     => 'Дата окончания',
		'queen_Status' => 'Статус королевы',
	];

	return array_slice( $columns, 0, 1 ) + $columns + $my_columns;
} );

add_action( 'manage_queen_posts_custom_column', function ( $column_name ) {

	global $post;

	$start_date  = get_post_meta( $post->ID, 'q_start', true );
	$start_date1 = date( 'd.m.Y', strtotime( $start_date ) );
	$end_date    = get_post_meta( $post->ID, 'q_end', true );
	$end_date1   = date( 'd.m.Y', strtotime( $end_date ) );

	if ( $column_name === 'queen_Status' ) {
		if ( get_post_status() == 'publish' ) {
			echo 'Активна';
		} else {
			echo 'Деактивирована';
		}
	}

	if ( $column_name === 'start_date' ) {

		echo $start_date1;

	}
	if ( $column_name === 'end_date' ) {
		echo $end_date1;
	}
} );

add_action( 'init', function ( $post_id ) {
	$today = date( "Y-m-d" );

	$queens = get_posts( array(
			'post_type'   => 'queen',
			'post_status' => 'publish',
		)
	);

	foreach ( $queens as $queen ) {

		$end_date  = get_post_meta( $post_id, 'q_end', true );
		$end_date1 = date( "Y-m-d", strtotime( $end_date ) );

		if ( $end_date1 > $today ) {
			$post_id['post_status'] = 'draft';
			wp_update_post( $post_id );
		} else {

		}
	}
} );




function modify_user_table( $columns ) {
	$my_columns = [
		'Phone' => 'Телефон',
	];

	return array_slice( $columns, 0, 1 ) + $columns + $my_columns;
}

function modify_user_table_row( $column_name, $user_id ) {
	if ( $column_name === 'Phone' ) {
		echo get_user_meta( $user_id, 'nickname', true );
	}
}


//add_action( 'wp_ajax_queen', 'function_echo' );
//add_action( 'wp_ajax_nopriv_queen', 'function_echo' );
//function function_echo($post) {
//	date_default_timezone_set( 'Europe/Minsk' );
//	$current_time_str = date( "d.m.Y H:i" );
//
//	update_post_meta( $post->ID, 'q_visit', $current_time_str );
//	wp_die();
//}
