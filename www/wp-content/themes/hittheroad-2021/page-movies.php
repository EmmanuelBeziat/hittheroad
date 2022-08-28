<?php
/**
* Template Name: Nos Films
*
* @package WordPress
* @subpackage HitTheRoad
*/

$films = (object) [
	'title' => get_the_title(),
	'movies' => get_field('movies'),
];
?>

<?php get_header(); ?>

<section class="section presentation" id="presentation">
	<div class="container">
		<h1 class="h1"><?= $films->title ?></h1>

		<div class="movies-grid">
		<?php if (!empty($films->movies)) :
				foreach ($films->movies as $key => $movie) :
					echo $key === 0 ? '' : '<hr class="my-5">';
					get_template_part('template-parts/content/movies/movie', '', ['movie' => $movie]);
				endforeach;
			endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
