<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article>
			<div class="container">
				<header class="article-header">
					<h1><?php the_title(); ?></h1>
				</header>
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>
