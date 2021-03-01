<?php
get_header();
//vars
$q_start_time = strtotime( get_post_meta( $post->ID, 'q_start', true ) );
$q_end_time   = strtotime( get_post_meta( $post->ID, 'q_end', true ) );
$q_phone      = get_post_meta( $post->ID, 'q_phone', true );
$q_last_visit = get_post_meta( $post->ID, 'q_visit', true );
$q_new_visit  = current_time( 'j.m.Y', 0 );
?>
    <div id="primary" class="content-area container">
		<?php
		/**
		 * Hook: woocommerce_before_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		//		do_action( 'woocommerce_before_main_content' );
		woocommerce_breadcrumb();
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>

        <div class="row">
            <div class="col-12 col-md-6 mb-5">
				<?php
				echo get_the_post_thumbnail( $id, 'shop_catalog', array( 'class' => 'img-fluid' ) );
				?>
            </div>
            <div class="col-12 col-md-6 mb-5">
                <h2>Королева танцпола</h2>
                <div class="">
					<?php
					echo '<p>Дата начала: ' . date_i18n( 'j.m.Y', $q_start_time ) . '</p>';
					echo '<p>Дата окончания: ' . date_i18n( 'j.m.Y', $q_end_time ) . '</p>';

					if ( current_user_can( 'level_3' ) ) {
						?>
                        <p>Телефон: <a href="tel:<?php echo $q_phone; ?>">
								<?php echo $q_phone; ?>
                            </a>
                        </p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo the_permalink(); ?>"
                             alt="QR: <?php echo the_title(); ?>"/>
                        <div class="check__queen ">
                            <div class="mt-5">
                                <p>Последнее посещение: <?php echo $q_last_visit; ?></p>


                                    <button id="queen_update_date_button" class="arena__button" name="queen_update_date_button" value="1">Отметить посещени</button>


                            </div>
                        </div>
						<?php
					}
					?>
                </div>
            </div>
        </div>
    </div><!-- #primary -->

<?php
get_footer();
