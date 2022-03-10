<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="apple-touch-icon" sizes="180x180" href="<?= get_template_directory_uri() ?>/assets/images/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= get_template_directory_uri() ?>/assets/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= get_template_directory_uri() ?>/assets/images/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?= get_template_directory_uri() ?>/assets/images/favicons/site.webmanifest" crossorigin="use-credentials">
	<link rel="mask-icon" href="<?= get_template_directory_uri() ?>/assets/images/favicons/safari-pinned-tab.svg" color="#222222">
	<link rel="shortcut icon" href="<?= get_template_directory_uri() ?>/assets/images/favicons/favicon.ico">
	<meta name="msapplication-TileColor" content="#222222">
	<meta name="msapplication-config" content="<?= get_template_directory_uri() ?>/assets/images/favicons/browserconfig.xml">
	<meta name="theme-color" content="#222222">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<a class="skip-link visually-hidden-focusable" href="#content">Aller au contenu</a>

	<div class="site" id="top">
		<?php get_template_part('template-parts/header/site-header'); ?>

		<main class="site-main" id="content">
