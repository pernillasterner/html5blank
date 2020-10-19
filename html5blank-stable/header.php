<?php error_reporting(0); ?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<title><?php wp_title(''); ?></title>

		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link href="//www.google-analytics.com" rel="dns-prefetch">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">

		<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P2JTTQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P2JTTQ');</script>
<!-- End Google Tag Manager -->
		<div class="mm-page">

			<header class="container subheader clear" role="banner">
				<div class="container">
					<div class="row">
						<div id="logo-container" class="col-xs-6 col-md-3">
							<a href="<?php echo home_url(); ?>">
								<img src="<?php echo get_template_directory_uri(); ?>/img/logo-black.png" class="logo-img">
							</a>
						</div>
						<div id="header-right" class="col-xs-6 col-md-9">
							<div id="top-right">
								<a href="#" id="search-button">
									<span class="glyphicon glyphicon-search"></span>
								</a>
								<a href="#my-menu" id="open-my-menu">
									<span class="glyphicon glyphicon-menu-hamburger"></span>
								</a>
							</div>
							<div id="bottom-right" class="hidden-xs hidden-sm">
								<nav class="main-nav" role="navigation">
									<?php echo do_shortcode('[cmwizard menu=Base/]'); ?>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</header>
			<main role="main">
