<?php
session_start();
require_once('database.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['postId'])) {
    $postId = $_POST['postId'];
    $userId = $_SESSION['user_id'];
    echo $_POST['postId'];

    $query = "SELECT COUNT(*) FROM likes WHERE post_id = :postId AND user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $likeCount = $stmt->fetchColumn();
echo $userId, $postId;
    echo "Like count: " . $likeCount . "<br>";

    if ($likeCount > 0) {
        $query = "DELETE FROM likes WHERE post_id = $postId AND user_id = $userId";
        echo "Removing like...<br>";
    } else {
        $query = "INSERT INTO likes (post_id, user_id) VALUES ($postId, $userId)";
        echo "Adding like...<br>";
    }

    $stmt = $pdo->prepare($query);
    echo $query;
    $stmt->execute();

    $updateQuery = "UPDATE posts SET like_count = (SELECT COUNT(*) FROM likes WHERE post_id = $postId) WHERE id = $postId";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute();

    header('Location: '.$_SERVER['HTTP_REFERER']); exit;
} else {
    echo "Error: Post ID is missing.";
}

?>
