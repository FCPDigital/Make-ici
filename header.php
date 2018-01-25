<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Muli:700" rel="stylesheet">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '338770209922464');
  fbq('track', 'PageView');
  fbq('track', 'CompleteRegistration');
  fbq('track', 'Lead');
  fbq('track', 'Purchase', {value: '0.00', currency: 'USD'});
  fbq('track', 'AddPaymentInfo');
  fbq('track', 'InitiateCheckout');
  fbq('track', 'AddToCart');
  fbq('track', 'ViewContent');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=338770209922464&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
	</head>

	<body <?php body_class(); ?>>
		<header id="main-header" class="transparent">
			<nav id="navbar" class="navbar navbar-default navbar-fixed-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<i class="fa fa-bars" aria-hidden="true"></i>
						</button>
						<a class="navbar-brand" href="<?php bloginfo('url')?>"><?php display_website_logo(); ?></a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<?php /* Primary navigation */
						wp_nav_menu( array(
							'menu' => 'Header',
							'depth' => 2,
							'container' => false,
							'menu_class' => 'nav	navbar-nav',
							'walker' => new wp_bootstrap_navwalker())
						);
						?>
					</div>
				</div>
			</nav>
	</header>
	<div id="popin" class="hide">
		<span class="close-popin">X</span>
		<div class="content-popin"></div>
	</div>


	<?php
	//Bouton du panier
	global $woocommerce; ?>
	<?php if($woocommerce && $woocommerce->cart->cart_contents_count>0){
		$dataCount='data-count="'.$woocommerce->cart->cart_contents_count.'"';
	} else {
		$dataCount="";
	}?>
	<?php if($woocommerce) { ?>
	<a id="cart-btn" <?php echo $dataCount ?> href="<?php echo $woocommerce->cart->get_cart_url(); ?>">Panier</a>
	<?php } ?>
