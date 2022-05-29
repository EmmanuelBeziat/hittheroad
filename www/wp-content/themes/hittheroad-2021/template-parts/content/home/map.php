<?php if ($args['map']->isActive) : ?>
<section class="map" id="home-map">
	<?php if ($args['map']->borders) : ?>
	<div class="map-divider-top">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 0L0 0 892.25 114.72 1200 0z" class="shape-fill"></path>
    </svg>
	</div>
	<?php endif; ?>

	<div id="htr-destinations" data-aos="fade-in" data-aos-duration="500" data-aos-delay="200"></div>

	<?php if ($args['map']->borders) : ?>
	<div class="map-divider-bottom">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 0L0 0 598.97 114.72 1200 0z" class="shape-fill"></path>
    </svg>
	</div>
	<?php endif; ?>

	<?php $places = [];
	$query = new WP_Query([
		'post_type' => 'location'
	]);
	if ($query->have_posts()) :
		while ($query->have_posts()) :
			$query->the_post();
			array_push($places, (object) [
				'id' => get_the_ID(),
				'name' => get_the_title(),
				'slug' => get_post(get_the_ID())->post_name,
				'lat' => get_field('coordinates', get_the_ID())['lat'],
				'lng' => get_field('coordinates', get_the_ID())['lng'],
			]);
		endwhile;
		wp_reset_postdata();
	endif; ?>
	<script>
		const places = <?= json_encode($places) ?>;
		const htrMapToken = '<?= $args['map']->token ?>'
		const htrMapStyle = '<?= $args['map']->style ?>'
		const htrMapDestinations = []
		places.forEach(place => {
			htrMapDestinations.push({
				id: parseFloat(place.id),
				name: place.name,
				slug: place.slug,
				lat: parseFloat(place.lat),
				lng: parseFloat(place.lng),
			})
		})
	</script>
</section>
<?php endif; ?>
