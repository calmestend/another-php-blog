<?php
namespace App\components;

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
	<div class="container-fluid">
		<a class="navbar-brand" href="index.php"><b>Blog</b></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			</ul>

			<?php if(isset($_SESSION['user_id'])) : ?>
			<form class="d-flex" action="src/api/auth/logout.php" method="POST">
				<button type="submit" class="btn btn-dark btn-outline-light mx-2">Log out</button>
			</form>
			<?php else : ?>

			<form class="d-flex" action="login.php" method="POST">
				<button class="btn btn-light btn-outline-dark mx-2">Log in</button>
			</form>

			<form class="d-flex" action="signup.php" method="POST">
				<button class="btn btn-dark btn-outline-light mx-2">Sign up</button>
			</form>

			<?php endif; ?>
		</div>
	</div>
</nav>
