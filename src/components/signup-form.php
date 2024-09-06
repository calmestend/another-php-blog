<?php namespace App\components; ?>

<form class="my-4" action="src/api/auth/signup.php" method="POST">
	<div class="row mb-3">
		<label for="username" class="col-sm-2 col-form-label">Username</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="username" name="username">
		</div>
	</div>
	<div class="row mb-3">
		<label for="email" class="col-sm-2 col-form-label">Email</label>
		<div class="col-sm-3">
			<input type="email" class="form-control" id="email" name="email">
		</div>
	</div>
	<div class="row mb-3">
		<label for="password" class="col-sm-2 col-form-label">Password</label>
		<div class="col-sm-3">
			<input type="password" class="form-control" id="password" name="password">
		</div>
	</div>
	<button type="submit" class="btn btn-light btn-outline-dark">Sign up</button>
</form>

