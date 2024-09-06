<?php
namespace App\components;
session_start();

use App\core\Post_categories;
use App\core\Categories;
use App\core\Database;
use PDO;

$db = new Database();
$pdo = $db->connect();

$postCategories = new Post_categories($pdo);
$categories = new Categories($pdo);

$allCategories = $categories->select();
$categoriesList = [];
while ($row = $allCategories->fetch(PDO::FETCH_ASSOC)) {
	$categoriesList[] = $row['name'];
}

$selectedCategory = $_GET['category'] ?? '';
$postsWithCategories = $postCategories->selectWithCategories($selectedCategory);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Blog</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</head>
	<body>

		<?php require 'bar.php' ?>

		<h1>Hi There</h1>	
		<h2>Want to create a post?</h2>	

		<form action="create-post.php">
			<button class="btn btn-light btn-outline-dark" type="submit">Create Post</button>
		</form>

		<div class="container mt-4">
			<form action="" method="GET">
				<div class="mb-3">
					<label for="category" class="form-label">Filter by Category</label>
					<select id="category" name="category" class="form-select">
						<option value="" selected>All Categories</option>
						<?php foreach ($categoriesList as $category): ?>
						<option value="<?= htmlspecialchars($category) ?>" <?= $selectedCategory === $category ? 'selected' : '' ?>>
							<?= htmlspecialchars($category) ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
				<button type="submit" class="btn btn-light btn-outline-dark">Filter</button>
			</form>
		</div>

		<div class="container mt-4">
			<div class="column">
				<?php foreach($postsWithCategories as $post): ?>
				<div class="row-md-4 mb-4">
					<div class="card">
						<div class="card-body">
							<h2 class="card-title"><?= htmlspecialchars($post['title']) ?></h2>
							<p class="card-subtitle mb-2 text-muted">Posted by <?= htmlspecialchars($post['username']) ?></p>
							<p class="card-text"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

							<div class="d-flex flex-wrap gap-2">
								<?php foreach($post['categories'] as $name): ?>
								<span class="badge bg-black">#<?= htmlspecialchars($name) ?></span>
								<?php endforeach; ?>
							</div>

						</div>

						<form class="m-3" action="post.php" method="GET">
                            <input type="hidden" name="post_id" value="<?= htmlspecialchars($post['post_id']) ?>">
							<button class="btn btn-light btn-outline-dark">View More...</button>
						</form>

					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

	</body>
</html>
