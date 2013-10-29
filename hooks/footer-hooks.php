<?php
/**
 * Title: Footer Hooks
 *
 * Description: Defines actions/hooks for footer content.
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

/**
 * Adds the CyberChimps credit.
 *
 * @since 1.0
 */
function cyberchimps_footer_credit() {
	?>
	<div class="container-full-width" id="after_footer">
		<div class="container">
			<div class="container-fluid">
				<footer class="site-footer row-fluid">
					<div class="span6">
						<div id="credit">
							<?php if( cyberchimps_get_option( 'footer_cyberchimps_link', 1 ) == '1' ): ?>
								<a href="http://cyberchimps.com/" target="_blank" title="CyberChimps Themes">
									<img class="cc-credit-logo" src="<?php echo get_template_directory_uri(); ?>/cyberchimps/lib/images/achimps.png" alt="CyberChimps"/>
									<h4 class="cc-credit-text"><span>Cyber</span>Chimps</h4>
								</a>
							<?php endif; ?>
						</div>
					</div>

					<!-- Adds the afterfooter copyright area -->
					<div class="span6">
						<?php $copyright = ( cyberchimps_get_option( 'footer_copyright_text' ) ) ? cyberchimps_get_option( 'footer_copyright_text' ) : 'CyberChimps &#169;' . date( 'Y' ); ?>
						<div id="copyright">
							<?php echo wp_kses_post( $copyright ); ?>
						</div>
					</div>
				</footer>
				<!-- row-fluid -->
			</div>
			<!-- .container-fluid-->
		</div>
		<!-- .container -->
	</div>    <!-- #after_footer -->
<?php
}

add_action( 'cyberchimps_footer', 'cyberchimps_footer_credit' );