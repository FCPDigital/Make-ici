
<footer class="container-fluid" role="contentinfo">
	<!-- <a href="#" class="scroll-manage" data-scroll data-id=".item-scroll"></a> -->
	<a href="#" class="scroll-to-top" data-scroll></a>

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
	<div class="copyright">
		<p>
			<?php if (get_page_by_title("Mention Légales")): ?>
				<a href="<?php get_permalink(get_page_by_title("Mention Légales")); ?>">Mentions légales</a> -
			<?php endif;?>
			Copyright © Make ICI - Tous droits réservés - Assemblés par FCP
		</p>
	</div>
</footer>
<?php wp_footer(); ?>

</body>
</html>
