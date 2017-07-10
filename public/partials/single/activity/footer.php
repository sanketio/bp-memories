<?php

/**
 * Single Memory Footer on activity page.
 *
 * @since       1.1.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / public / partials / single / activity
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.
}
?>
		</div>
	</div>
	<?php
	$memory_page = bpm_get_memory_page_link();

	if ( ! empty( $memory_page ) ) {
		?>
		<a class="button bp-more-memories" href="<?php echo esc_url( $memory_page ); ?>"><?php esc_html_e( 'See More Memories', 'bp-memories' ); ?></a>
		<?php
	}
	?>
</div>
