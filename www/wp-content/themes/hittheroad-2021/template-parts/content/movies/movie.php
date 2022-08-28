<?php

$movie = (object) [
	'title' => $args['movie']['title'],
	'pictures' => (object) [
		'mobile' => $args['movie']['picture-mobile'],
		'desktop' => $args['movie']['picture-desktop'],
	],
	'description' => $args['movie']['description'],
	'link' => $args['movie']['link']
];
?>

<figure class="movie" data-aos="fade-in" data-aos-delay="<?= $args['delay'] ?>">
	<picture class="movie-picture">
		<source srcset="<?= $movie->pictures->mobile['sizes']['author-picture'] ?>" media="(max-width: 980px)" type="image/<?= $movie->pictures->mobile['subtype'] ?>">
		<img src="<?= $movie->pictures->desktop['sizes']['author-picture'] ?>" alt="<?= $movie->title ?>">
	</picture>

	<figcaption class="movie-caption">
		<h2 class="h2 mb-3"><?= $movie->title ?></h2>
		<?= $movie->description ?>
		<div class="d-grid d-lg-block movie-link">
			<a href="<?= $movie->link ?>" class="btn btn-primary"><i class="fab fa-vimeo-v me-2"></i> Voir le film</a>
		</div>
	</figcaption>
</figure>
