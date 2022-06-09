<?php $author = $args['author']; ?>

<figure class="author">
	<picture class="author-picture">
		<source media="(max-width: 480px)" srcset="<?= $author['picture']['sizes']['author-picture-medium'] ?>">
		<source media="(max-width: 991px)" srcset="<?= $author['picture']['sizes']['author-picture-medium'] ?>">
		<source media="(min-width: 992px)" srcset="<?= $author['picture']['sizes']['author-picture'] ?>">
		<img src="<?= $author['picture']['sizes']['author-picture-medium'] ?>" loading="lazy" alt="<?= $author['picture']['alt'] ?>">
	</picture>

	<figcaption class="author-caption">
		<h3 class="h3 author-name"><?= $author['name'] ?></h3>
		<div class="author-description"><?= $author['description'] ?></div>
	</figcaption>
</figure>
