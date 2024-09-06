<?php
namespace App\api\comments;
session_start();
require_once "../../../vendor/autoload.php";

use App\core\Comments;
use App\core\Database;
$db = new Database();
$pdo = $db->connect();

$comments = new Comments($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['comment'])) {
    $postId = $_POST['post_id'];
    $userId = $_SESSION['user_id']; 
    $comment = $_POST['comment'];

    if ($postId && $comment) {
        $comments->setPostId($postId);
        $comments->setUserId($userId);
        $comments->setComment($comment);
        $comments->insert();
    }
}

header('Location: /blog/');
exit();
?>
