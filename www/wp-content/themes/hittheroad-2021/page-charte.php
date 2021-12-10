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
		<h1>Typographie</h1>

		<h2>Titres</h2>

		<h1 class="h1">H1 title</h1>
		<h2 class="h2">H2 title</h1>
		<h3 class="h3">H3 title</h1>
		<h4 class="h4">H4 title</h1>
		<h5 class="h5">H5 title</h1>

		<hr>

		<h2>Contenu</h2>

		<p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem eum sequi inventore perferendis autem fugit ullam omnis veniam exercitationem totam enim assumenda atque aliquid laudantium placeat facere, eaque quasi blanditiis?</p>

		<p>Lorem ipsum dolor, <a href="#">sit amet consectetur adipisicing</a> elit. Atque porro facilis quis laborum suscipit commodi eum debitis id repellendus assumenda ratione, vero et adipisci iure modi tempora magnam dolorem. At.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores illo quam, quia est <strong>reprehenderit maxime</strong> voluptatum similique repellat a unde rerum sit <em>vero incidunt</em> molestias temporibus, optio voluptates soluta cupiditate. Quisquam, quis.</p>

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

<section class="section mt-5" id="buttons">
	<div class="container">
		<h1>Boutons</h1>

		<p>
			<button class="btn btn-primary">Bouton primaire</button>
			<button class="btn btn-secondary">Bouton secondaire</button>
			<button class="btn btn-primary btn-rounded">Bouton primaire</button>
			<button class="btn btn-secondary btn-rounded">Bouton secondaire</button>
			<button class="btn btn-primary btn-rounded" disabled>Bouton primaire</button>
			<button class="btn btn-secondary btn-rounded" disabled>Bouton secondaire</button>
		</p>

		<p>
			<button class="btn btn-primary btn-outline">Bouton primaire alternatif</button>
			<button class="btn btn-secondary btn-outline">Bouton secondaire alternatif</button>
			<button class="btn btn-primary btn-outline btn-rounded">Bouton primaire alternatif</button>
			<button class="btn btn-secondary btn-outline btn-rounded">Bouton secondaire alternatif</button>
		</p>
	</div>
</section>

<section class="section mt-5" id="forms">
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

<section class="section mt-5" id="notify">
	<div class="container">
		<h1>Notifications</h1>

		<div class="alert alert-primary" role="alert">
			<strong>Attention!</strong> Ce message est important.
		</div>

		<div class="alert alert-secondary" role="alert">
			<strong>Attention!</strong> Ce message est important.
		</div>

		<div class="alert alert-success" role="alert">
			<strong>Attention!</strong> Ce message est important.
		</div>

		<div class="alert alert-danger" role="alert">
			<strong>Attention!</strong> Ce message est important.
		</div>

		<div class="alert alert-warning" role="alert">
			<strong>Attention!</strong> Ce message est important.
		</div>

		<div class="alert alert-info" role="alert">
			<strong>Attention!</strong> Ce message est important.
		</div>
	</div>
</section>

<section class="section mt-5" id="pagination">
	<div class="container">
		<h1>Pagination</h1>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item page-item-prev"><a class="page-link" href="#" aria-label="Page précédente"><i class="fas fa-chevron-left"></i></a></li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item active"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item"><a class="page-link" href="#">4</a></li>
				<li class="page-item page-item-next"><a class="page-link" href="#" aria-label="Page suivante"><i class="fas fa-chevron-right"></i></a></li>
			</ul>
		</nav>

		<nav class="nav-dots mt-5">
			<a href="#" class="nav-dots-item" aria-label="Premier item"></a>
			<a href="#" class="nav-dots-item active" aria-label="Deuxième item"></a>
			<a href="#" class="nav-dots-item" aria-label="Troisième item"></a>
		</nav>
	</div>
</section>

<section class="section mt-5" id="tabs">
	<div class="container">
		<h1>Tabs</h1>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" aria-current="page" href="#">Active</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Lien</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Lien</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#" disabled tabindex="-1" aria-disabled="true">Désactivée</a>
			</li>
		</ul>
	</div>
</section>

<?php get_footer(); ?>
