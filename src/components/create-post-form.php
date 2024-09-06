<?php namespace App\components ?>

<form action="src/api/posts/create.php" method="POST">
	<div class="mb-3">
		<label for="title" class="form-label">Title</label>
		<input type="text" class="form-control" id="title" name="title" required>
	</div>

	<div class="mb-3">
		<label for="content" class="form-label">Content</label>
		<textarea class="form-control" id="content" name="content" rows="5" required></textarea>
	</div>

	<div class="mb-3">
		<label for="categories" class="form-label">Categories</label>
		<div id="categoriesContainer"></div>

		<div class="input-group mb-3">
			<input type="text" id="newCategory" class="form-control" placeholder="Category name">
			<button type="button" class="btn btn-light btn-outline-dark" onclick="addCategory()">Add category</button>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Create Post</button>
</form>

