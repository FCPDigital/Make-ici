
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
					'menu_class' => 'nav	navbar-nav'
				));
				?>
			</div>
			<div class="flex-item">
				<h3 class="widget-title">Newsletter</h3>
				<div id="mc_embed_signup">
					<form action="//icimontreuil.us15.list-manage.com/subscribe/post?u=9006206a7cd32cc26b7890fbc&amp;id=2f9a6f2af1" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate newsletter" target="_blank" novalidate>
						<div id="mc_embed_signup_scroll">
							<p class="marge-bottom-small">Restez informés :</p>
							<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_9006206a7cd32cc26b7890fbc_2f9a6f2af1" tabindex="-1" value=""></div>
							<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Adresse e-mail">
							<a type="submit" onclick="document.querySelector('#mc-embedded-subscribe-form').submit()" name="subscribe" id="mc-embedded-subscribe" class="btn btn-dark">OK</a>
							<div id="mce-responses" class="clear">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div>		<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						</div>
					</form>
				</div>
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
