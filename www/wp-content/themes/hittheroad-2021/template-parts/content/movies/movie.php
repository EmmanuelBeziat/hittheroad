<?php
$id = $args['movie']->ID;
$movie = (object) [
	'title' => get_post($id)->post_title,
	'pictures' => (object) [
		'mobile' => get_field('picture-mobile', $id),
		'desktop' => get_field('picture-desktop', $id),
	],
	'description' => get_field('description', $id),
	'link' => get_field('link', $id)
];
?>

<figure class="movie" data-aos="fade-in" data-aos-delay="<?= $args['delay'] ?>">
	<a href="<?= $movie->link ?>">
		<picture class="movie-picture">
			<source srcset="<?= $movie->pictures->mobile['sizes']['author-picture'] ?>" media="(max-width: 980px)" type="image/<?= $movie->pictures->mobile['subtype'] ?>">
			<img src="<?= $movie->pictures->desktop['sizes']['author-picture'] ?>" alt="<?= $movie->title ?>">
		</picture>
	</a>

	<figcaption class="movie-caption">
		<h2 class="h2 mb-3"><?= $movie->title ?></h2>
		<?= $movie->description ?>
		<div class="d-grid d-lg-block movie-link">
			<a href="<?= $movie->link ?>" class="btn btn-primary"><i class="fab fa-vimeo-v me-2"></i> Voir le film</a>
		</div>
	</figcaption>
</figure>
