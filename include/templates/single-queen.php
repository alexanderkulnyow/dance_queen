<?php
get_header();

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
                $q_strat =  strtotime(get_post_meta( $post->ID, 'q_start', true ));
                $q_start_string = date( "d.m.Y",  $q_strat );
                $q_end =  strtotime(get_post_meta( $post->ID, 'q_end', true ));
                $q_end_string = date( "d.m.Y",  $q_end );
                ?>
                <p>Дата начала: <?php echo $q_start_string; ?></p>
                <p>Дата окончания: <?php echo $q_end_string; ?></p>
				<?php

				if ( current_user_can( 'level_3' ) ) {
					?>
                    <p>Телефон: <a class="" href="tel:<?php echo get_post_meta( $post->ID, 'q_phone', true ) ?>">
							<?php echo get_post_meta( $post->ID, 'q_phone', true ) ?>
                        </a>
                    </p>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo the_permalink(); ?>"
                         alt="QR: <?php echo the_title(); ?>"/>
                    <div class="check__queen ">
                        <div class="mt-5">
                            <p>Последнее посещение: <?php echo get_post_meta( $post->ID, 'q_visit', true ); ?></p>

							<?php
							do_action( 'queen__date_init' );
							?>
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
