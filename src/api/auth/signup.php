<?php 
namespace App\api\auth;

require_once "../../../vendor/autoload.php";

use App\core\Database;
use App\core\Users;
use PDOException;

$db = new Database();
$pdo = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
	$username = $_POST['username'] ?? '';
	$email = $_POST['email'] ?? '';
	$password = $_POST['password'] ?? '';

	$user = new Users($pdo);
	$user->setEmail($email);
	$user->setUsername($username);
	$user->setPassword($password);

	try 
	{
		$user->insert();

		$currentUser = $user->selectByUsername();

		session_start();
		$_SESSION['user_id'] = $currentUser['user_id'];
		$_SESSION['username'] = $currentUser['username'];

		header("Location: /blog/index.php");
		exit();
	} catch (PDOException $error) 
	{
		die("Something went wrong: " . $error->getMessage());
	}
}

?>

