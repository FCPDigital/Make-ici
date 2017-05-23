
<footer class="container-fluid" role="contentinfo">
	<a href="#" class="scroll-manage" data-id=".item-scroll"></a>
	<div class="row">
		<?php get_template_part( 'template-parts/footer/footer', 'widgets' );

		if ( has_nav_menu( 'social' ) ) : ?>
			<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
				<?php wp_nav_menu( array(
					'theme_location' => 'social',
					'menu_class'     => 'social-links-menu',
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
				) ); ?>

			</nav><!-- .social-navigation -->
		<?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>

</body>
</html>
