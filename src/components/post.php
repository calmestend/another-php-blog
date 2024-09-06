<?php
namespace App\components;
session_start();

use App\core\Post_categories;
use App\core\Database;
use App\core\Comments;

$db = new Database();
$pdo = $db->connect();

$postId = $_GET['post_id'] ?? '';

$post = new Post_categories($pdo);
$postDetails = $post->selectById($postId);

$comments = new Comments($pdo);
$commentsList = $comments->getCommentsByPostId((int)$postId);
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
		<div class="card m-4">
			<div class="card-body">
				<h1 class="card-title"><?= htmlspecialchars($postDetails[$postId]['title']) ?></h1>
				<p class="card-subtitle mb-2 text-muted">Posted by <?= htmlspecialchars($postDetails[$postId]['username']) ?></p>
				<p class="card-text"><?= nl2br(htmlspecialchars($postDetails[$postId]['content'])) ?></p>

				<div class="d-flex flex-wrap gap-2">
					<?php foreach($postDetails[$postId]['categories'] as $name): ?>
					<span class="badge bg-black">#<?= htmlspecialchars($name) ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>


		<div class="m-4">
			<form action="src/api/comments/create.php" method="POST">
				<h2>Add Comment</h2>
				<input type="hidden" name="post_id" value="<?= htmlspecialchars($postId) ?>">
				<div class="mb-3">
					<textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
				</div>
				<button type="submit" class="btn btn-light btn-outline-dark">Submit Comment</button>
			</form>
		</div>

		<div class="m-4">
			<h3 class="mt-4">Comments</h3>
			<?php if (!empty($commentsList)): ?>
			<ul class="list-group ">
				<?php foreach($commentsList as $comments): ?>
				<li class="list-group-item">
					<small class="text-muted">Commented at <?= htmlspecialchars($comments['created_at']) ?></small>
					<br>
					<?= nl2br(htmlspecialchars($comments['comment'])) ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
			<p>No comments yet.</p>
			<?php endif; ?>
		</div>

	</body>
</html>

