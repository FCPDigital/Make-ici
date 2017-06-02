
<footer class="container-fluid" role="contentinfo">
	<!-- <a href="#" class="scroll-manage" data-scroll data-id=".item-scroll"></a> -->
	<a href="#" class="scroll-to-top" data-scroll></a>

	<div class="row">
			<div class="flex-item">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div>
			<div class="flex-item">
				<?php dynamic_sidebar( 'sidebar-2' );
				wp_nav_menu( array(
					'menu' => 'social',
					'depth' => 2,
					'container' => false,
					'menu_class' => 'nav  navbar-nav'
				));
				?>
			</div>
			<div class="flex-item">
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</div>
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
