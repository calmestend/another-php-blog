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
	$password = $_POST['password'] ?? '';

	$user = new Users($pdo);
	$user->setUsername($username);

	try 
	{
		$result = $user->selectByUsername();
		if ($result && $password === $result['password']) 
		{

			session_start();
			$_SESSION['user_id'] = $result['user_id'];
			$_SESSION['username'] = $result['username'];

			header("Location: /blog/");
			exit();
		} else 
		{
			header("Location: /blog/login.php");
			exit();
		}
	} catch (PDOException $error) 
	{
		die("Something went wrong: " . $error->getMessage());
	}
}
?>
