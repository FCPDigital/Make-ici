
<footer class="container-fluid" role="contentinfo">
	<a href="#" class="scroll-to-top display-scroll hide" data-scroll></a>
	<?php if(get_page_by_title("Prendre un atelier ICI")) { ?>
		<a href="<?php echo get_permalink(get_page_by_title("Prendre un atelier ICI")); ?>" class="resident_button display-scroll hide">Devenez résident !</a>
	<?php } ?>
	

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
				'menu_class' => 'nav	navbar-nav'
			));
			?>
		</div>
		
		<div class="flex-item">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div>
	</div>

	<div class="copyright">
		<p>

			<?php if (get_page_by_title("Mention Légales")) { ?>
				<a href="<?php echo get_permalink(get_page_by_title("Mention Légales")); ?>">Mentions légales</a> -
			<?php } 
			if(get_page_by_title("Conditions Générales de Vente")) { ?>
				<a href="<?php echo get_permalink(get_page_by_title("Conditions Générales de Vente")); ?>">CGV</a> -
			<?php } ?>

			Copyright © Make ICI - Tous droits réservés - Assemblés par <a href="http://www.fcp-digital.com/">FCP Digital</a>
		</p>
	</div>

</footer>
<?php wp_footer(); ?>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
 	ga('create', 'UA-98793252-1', 'auto');
 	ga('send', 'pageview');
 </script>

 
</body>
</html>
