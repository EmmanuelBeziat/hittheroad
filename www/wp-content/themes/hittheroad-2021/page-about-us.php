<?php
/**
* Template Name: Présentation
*
* @package WordPress
* @subpackage HitTheRoad
*/

$aboutUs = (object) [
	'title' => get_the_title(),
	'content' => get_the_content(),
	'contentNext' => get_field('content'),
	'authors' => get_field('author'),
	'video' => get_field('video'),
];
?>

<?php get_header(); ?>

<section class="section presentation" id="presentation">
	<div class="container">
		<h1 class="h1"><?= $aboutUs->title ?></h1>

		<?= $aboutUs->content ?>

		<div class="presentation-grid my-5">
			<?php foreach ($aboutUs->authors as $author):
				get_template_part('template-parts/content/about-us/author', '', ['author' => $author]);
			endforeach; ?>
		</div>

		<?= $aboutUs->contentNext ?>

		<?php if ($aboutUs->video !== '') : ?>
		<h2 class="h2 mt-5">Notre dernier film</h2>
		<?= HTR_Tools::blockVideo($aboutUs->video) ?>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
