<?php $author = $args['author']; ?>

<figure class="author">
	<picture class="author-picture">
		<source media="(max-width: 480px)" srcset="<?= esc_url($author['picture']['sizes']['author-picture-medium']) ?>">
		<source media="(max-width: 991px)" srcset="<?= esc_url($author['picture']['sizes']['author-picture-medium']) ?>">
		<source media="(min-width: 992px)" srcset="<?= esc_url($author['picture']['sizes']['author-picture']) ?>">
		<img src="<?= esc_url($author['picture']['sizes']['author-picture-medium']) ?>" loading="lazy" alt="<?= esc_attr($author['picture']['alt']) ?>">
	</picture>

	<figcaption class="author-caption">
		<h3 class="h3 author-name"><?= esc_html($author['name']) ?></h3>
		<div class="author-description"><?= HTR_Tools::kses_content($author['description']) ?></div>
	</figcaption>
</figure>
