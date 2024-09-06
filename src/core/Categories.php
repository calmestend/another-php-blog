<?php
namespace App\core;
use PDO, PDOStatement;

class Categories {
	private PDO $conn;

	private int $category_id;
	private string $name;

	public function __construct(PDO $db)
	{
		$this->conn = $db;
	}

	public function setName(string $name) : void
	{
		$this->name = htmlspecialchars(strip_tags($name));
	}


	public function select() : PDOStatement | bool
	{
		$query = "SELECT * FROM categories";

		$statement = $this->conn->prepare($query);
		$statement->execute();

		return $statement;
	}

	public function insert() : bool
	{
		$query = "INSERT INTO categories (name) VALUES (?)";

		$this->name = htmlspecialchars(strip_tags($this->name));

		$statement = $this->conn->prepare($query);
		$statement->bindParam(1, $this->name);

		return $statement->execute() ? true : false;
	}
}

?>

