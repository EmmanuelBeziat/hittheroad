<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" type="image/png" href="<?= get_template_directory_uri() ?>/assets/images/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/svg+xml" href="<?= get_template_directory_uri() ?>/assets/images/favicons/favicon.svg">
	<link rel="shortcut icon" href="<?= get_template_directory_uri() ?>/assets/images/favicons/favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= get_template_directory_uri() ?>/assets/images/favicons/apple-touch-icon.png">
	<meta name="apple-mobile-web-app-title" content="Hit the Road">
	<link rel="manifest" href="<?= get_template_directory_uri() ?>/assets/images/favicons/site.webmanifest">

	<?= noIndexPage(get_queried_object_id()) ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<a class="skip-link visually-hidden-focusable" href="#content">Aller au contenu</a>

	<div class="site" id="top">
		<?php get_template_part('template-parts/header/site-header'); ?>

		<main class="site-main" id="content">
