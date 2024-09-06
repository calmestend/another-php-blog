<?php
namespace App\core;
use PDO, PDOStatement;

class Post_categories {
	private PDO $conn;

	private int $post_id;
	private string $category_id;

	public function __construct(PDO $db)
	{
		$this->conn = $db;
	}

	public function setPostId(int $post_id) : void
	{
		$this->post_id = htmlspecialchars(strip_tags($post_id));
	}

	public function setCategoryId(int $category_id) : void
	{
		$this->category_id = htmlspecialchars(strip_tags($category_id));
	}

	public function select() : PDOStatement | bool
	{
		$query = "SELECT * FROM post_categories";

		$statement = $this->conn->prepare($query);
		$statement->execute();
		return $statement;
	}


	public function selectWithCategories(string $category = '') : Array
	{

		$query = "SELECT 
		users.username, posts.title, posts.content,
		posts.user_id, posts.post_id, categories.name
		FROM posts 
		JOIN users ON posts.user_id = users.user_id 
		JOIN post_categories ON post_categories.post_id = posts.post_id 
		JOIN categories ON post_categories.category_id = categories.category_id
		";

		if (!empty($category)) 
		{
			$query .= " WHERE categories.name = :category";
		}

		$query .= " ORDER BY posts.post_id, categories.name";

		$statement = $this->conn->prepare($query);

		if (!empty($category)) 
		{
			$statement->bindParam(':category', $category, PDO::PARAM_STR);
		}

		$statement->execute();

		$posts = [];
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) 
		{
			$postId = $row['post_id'];
			if (!isset($posts[$postId])) {
				$posts[$postId] = [
					'username' => $row['username'],
					'title' => $row['title'],
					'content' => $row['content'],
					'user_id' => $row['user_id'],
					'post_id' => $row['post_id'],
					'categories' => []
				];
			}
			if (!empty($row['name'])) 
			{
				$posts[$postId]['categories'][] = $row['name'];
			}
		}

		return $posts;
	}

	public function selectById(int $postId) : Array
	{
		$query = "SELECT 
		users.username, posts.title, posts.content,
		posts.user_id, posts.post_id, categories.name
		FROM posts 
		JOIN users ON posts.user_id = users.user_id 
		LEFT JOIN post_categories ON post_categories.post_id = posts.post_id 
		LEFT JOIN categories ON post_categories.category_id = categories.category_id
		WHERE posts.post_id = :postId
		ORDER BY categories.name";

		$statement = $this->conn->prepare($query);
		$statement->bindParam(':postId', $postId, PDO::PARAM_INT);

		$statement->execute();

		$posts = [];

		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) 
		{
			if (!isset($posts[$row['post_id']])) 
			{
				$posts[$row['post_id']] = [
					'username' => $row['username'],
					'title' => $row['title'],
					'content' => $row['content'],
					'user_id' => $row['user_id'],
					'post_id' => $row['post_id'],
					'categories' => []
				];
			}
			if (!empty($row['name'])) 
			{
				$posts[$row['post_id']]['categories'][] = $row['name'];
			}
		}

		return $posts;
	}




	public function insert() : bool
	{
		$query = "INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)";

		$this->post_id = htmlspecialchars(strip_tags($this->post_id));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));

		$statement = $this->conn->prepare($query);
		$statement->bindParam(1, $this->post_id);
		$statement->bindParam(2, $this->category_id);

		return $statement->execute() ? true : false;
	}
}

?>

