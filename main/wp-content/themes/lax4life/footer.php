<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
		</div><!-- #main .wrapper -->
	</div><!-- #page -->
	<div class="push"></div>
</div><!-- #wrapper --> 

	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<div class="footer-links">
				<div class="clublogo">&nbsp;</div>
				<ul class="link-list">
					<li><a href="../main/home-wts/">Home</a></li>
					<li class="bar"><span>|</span></li>
					<li><a href="../main/about/">About Us</a></li>
					<li class="bar"><span>|</span></li>
					<li><a href="../main/upcoming-events/">Upcoming Events</a></li>
					<li class="bar"><span>|</span></li>
					<li><a href="../main/news/">News</a></li>
					<li><span>|</span></li>
					<li><a href="../main/contact-us/">Contact Us</a></li>
				</ul>
				<div class="copyright">
				<?php do_action( 'twentytwelve_credits' ); ?>
				<?php printf( __( 'Copyright &copy; %s', 'twentytwelve' ), 'FL LAX 4 Life, All Rights Reserved.' ); ?>
				</div><!-- copyright -->
				
			</div><!-- .footer-links -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</body>
</html>