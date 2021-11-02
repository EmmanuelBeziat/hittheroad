<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= get_theme_file_uri('assets/app.css') ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<a class="skip-link visually-hidden-focusable" href="#content">Aller au contenu</a>

	<div class="site">
		<?php get_template_part('template-parts/header/site-header'); ?>

		<main class="site-main" id="content">
