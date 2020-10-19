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
		<?php get_template_part('template-parts/header/header', 'full'); ?>


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P2JTTQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P2JTTQ');</script>
<!-- End Google Tag Manager -->
		<div id="search-container">
		<div id="search-box">
		<a id="search-close"></a>
		<?php get_search_form(); ?>
		</div>
		</div>

        <div id="login-container">
            <div id="login-box">
                <a id="login-close"></a>
                <div id="login-form" class="login-modal-part">
                <?php wp_login_form(); ?>
                </div>
                <div id="lostpassword-form" class="login-modal-part hidden">
                <?php get_template_part('template-parts/lost-password/form'); ?>
                </div>
                <div id="lostpassword-success" class="login-modal-part hidden">
                <?php get_template_part('template-parts/lost-password/success'); ?>
                </div>
                <div id="lostpassword-error" class="login-modal-part hidden">
                <?php get_template_part('template-parts/lost-password/error'); ?>
                </div>
                <div id="lostpassword-reset-form" class="login-modal-part hidden">
                <?php get_template_part('template-parts/lost-password/reset-form'); ?>
                </div>
                <div id="lostpassword-reset-success" class="login-modal-part hidden">
                <?php get_template_part('template-parts/lost-password/reset-success'); ?>
                </div>
            </div>
        </div>

		<nav id="my-menu">
			<?php html5blank_nav(); ?>
		</nav>

		<?php get_template_part( 'toolbox' ); ?>

		<div>
			<main class="base-sida" role="main">
