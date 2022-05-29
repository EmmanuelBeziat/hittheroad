<?php $author = $args['author']; ?>

<figure class="author">
	<picture class="author-picture">
		<source media="(max-width: 767px)" srcset="<?= $author['picture']['sizes']['product-thumbnail'] ?>">
		<source media="(min-width: 768px)" srcset="<?= $author['picture']['sizes']['product-preview'] ?>">
		<img src="<?= $author['picture']['sizes']['product-preview'] ?>" width="<?= $author['picture']['sizes']['product-preview-width'] ?>" height="<?= $author['picture']['sizes']['product-preview-height'] ?>" loading="lazy" alt="<?= $author['picture']['title'] ?>">
	</picture>

	<figcaption class="author-caption">
		<h3 class="h3 author-name"><?= $author['name'] ?></h3>
		<div class="author-description"><?= $author['description'] ?></div>
	</figcaption>
</figure>
