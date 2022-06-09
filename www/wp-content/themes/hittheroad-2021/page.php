<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<section class="page-text">
			<div class="container">
				<header class="section-header">
					<h1><?php the_title(); ?></h1>
				</header>
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile;
	else : ?>
		<section class="page-text">
			<div class="container">
				<p>Nothing to see.</p>
			</div>
		</section>
	<?php endif; ?>

<?php get_footer(); ?>
