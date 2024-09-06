<?php 
namespace App\api\posts;
require_once "../../../vendor/autoload.php";

use App\core\Database;
use App\core\Posts;
use App\core\Categories;
use App\core\Post_categories;
use PDOException;

session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: /blog/login.php");
	exit();
}

$db = new Database();
$pdo = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST['title'] ?? '';
	$content = $_POST['content'] ?? '';
	$categories = $_POST['categories'] ?? [];

	$post = new Posts($pdo);
	$categoriesModel = new Categories($pdo);
	$postCategories = new Post_categories($pdo);

	try {
		$post->setTitle($title);
		$post->setContent($content);
		$post->setUserId($_SESSION['user_id']); 

		if ($post->insert()) {
			$postId = $pdo->lastInsertId();

			foreach ($categories as $categoryName) {
				$categoriesModel->setName($categoryName);

				$query = "SELECT * FROM categories WHERE name = ?";
				$stmt = $pdo->prepare($query);
				$stmt->bindParam(1, $categoryName);
				$stmt->execute();

				$category = $stmt->fetch();

				if (!$category) {
					$categoriesModel->insert();
					$categoryId = $pdo->lastInsertId();
				} else {
					$categoryId = $category['category_id'];
				}

				$postCategories->setPostId($postId);
				$postCategories->setCategoryId($categoryId);
				$postCategories->insert();
			}

			header("Location: /blog/");
			exit();
		} else {
			throw new PDOException("Something went wrong");
		}
	} catch (PDOException $error) {
		die("Something went wrong: " . $error->getMessage());
	}
}
