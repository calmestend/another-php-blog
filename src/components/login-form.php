<?php namespace App\components; ?>

<form class="my-4" action="src/api/auth/login.php" method="POST">
	<div class="row mb-3">
		<label for="username" class="col-sm-2 col-form-label">Username</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="username" name="username">
		</div>
	</div>
	<div class="row mb-3">
		<label for="password" class="col-sm-2 col-form-label">Password</label>
		<div class="col-sm-3">
			<input type="password" class="form-control" id="password" name="password">
		</div>
	</div>
	<button type="submit" class="btn btn-light btn-outline-dark">Log in</button>
</form>

