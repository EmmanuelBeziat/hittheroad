<?php
/**
* Template Name: Charte
*
* @package WordPress
* @subpackage HitTheRoad
*/

?>

<?php get_header(); ?>

<section class="section" id="typography">
	<div class="container">
		<h1>Titres</h1>

		<h1 class="h1">H1 title</h1>
		<h2 class="h2">H2 title</h1>
		<h3 class="h3">H3 title</h1>
		<h4 class="h4">H4 title</h1>
		<h5 class="h5">H5 title</h1>

		<h1>Paragraphes</h1>
		<p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem eum sequi inventore perferendis autem fugit ullam omnis veniam exercitationem totam enim assumenda atque aliquid laudantium placeat facere, eaque quasi blanditiis?</p>

		<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Atque porro facilis quis laborum suscipit commodi eum debitis id repellendus assumenda ratione, vero et adipisci iure modi tempora magnam dolorem. At.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores illo quam, quia est reprehenderit maxime voluptatum similique repellat a unde rerum sit vero incidunt molestias temporibus, optio voluptates soluta cupiditate. Quisquam, quis.</p>

		<h1>Listes</h1>
		<ul>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
		</ul>

		<ol>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
			<li>Lorem ipsum dolor sit amet.</li>
		</ol>
	</div>
</section>

<section class="section" id="buttons">
	<div class="container">
		<h1>Boutons</h1>

		<p>
			<button class="btn btn-primary">Bouton primaire</button>
			<button class="btn btn-secondary">Bouton secondaire</button>
			<button class="btn btn-primary btn-rounded">Bouton primaire</button>
			<button class="btn btn-secondary btn-rounded">Bouton secondaire</button>
		</p>

		<p>
			<button class="btn btn-primary btn-outline">Bouton primaire alternatif</button>
			<button class="btn btn-secondary btn-outline">Bouton secondaire alternatif</button>
			<button class="btn btn-primary btn-outline btn-rounded">Bouton primaire alternatif</button>
			<button class="btn btn-secondary btn-outline btn-rounded">Bouton secondaire alternatif</button>
		</p>
	</div>
</section>

<section class="section" id="forms">
	<div class="container">
		<h1>Formulaires</h1>

		<div class="form-floating mb-3">
			<input type="text" class="form-control" name="field-example-1" id="field-example-1" autocomplete="field-example-1" placeholder="Contenu">
			<label for="field-example-1" class="form-label">Remplir le champ… <span class="required">*</span></label>
		</div>

		<div class="form-floating mb-3">
			<input type="text" class="form-control" name="field-example-2" id="field-example-2" autocomplete="field-example-2" placeholder="Contenu" disabled>
			<label for="field-example-2" class="form-label">Champ désactivé <span class="required">*</span></label>
		</div>

		<div class="mb-3">
			<select class="form-select form-select-lg mb-3" aria-label="form-select">
				<option selected>Sélection</option>
				<option value="1">Item</option>
				<option value="2">Item</option>
				<option value="3">Item</option>
			</select>
		</div>

		<div class="mb-3">
			<input class="form-check-input" name="checkbox-example" type="checkbox" id="checkbox-example" value="forever">
			<label class="form-check-label" for="checkbox-example">Case à cocher</label>
		</div>
		<div class="mb-3">
			<input class="form-check-input" type="radio" name="radio-example-1" id="radio-example-1">
			<label class="form-check-label" for="radio-example-1">
				Case radio
			</label>
		</div>
	</div>
</section>

<?php get_footer(); ?>
