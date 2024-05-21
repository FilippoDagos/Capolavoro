<?php
session_start();
require_once('database.php');
$user_id = $_SESSION['user_id'];
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$query = "
    SELECT posts.*, users.username 
    FROM posts 
    JOIN users ON posts.user_id = users.id
    WHERE posts.user_id = :user_id 
    ORDER BY posts.created_at DESC
";$postsStmt = $pdo->prepare($query);
$postsStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$postsStmt->execute();
$posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);
$numPosts = count($posts);
if (isset($_POST['postbtn'])) {
    $postContent = $_POST['post-content'];
    if(isset($_SESSION['user_id'])) {
        $pquery = "INSERT INTO posts (user_id, content, created_at, like_count) VALUES (:user_id, :content, NOW(), 0)";
        $insertStmt = $pdo->prepare($pquery);
        $insertStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $insertStmt->bindParam(':content', $postContent, PDO::PARAM_STR);
        $insertStmt->execute();

        header('Location: home.php');
        exit();

    } else {
        echo "Errore: ID utente non valido.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mySocial - Responsive Social Media Website Using HTML, CSS, & JavaScript</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <div class="container">
            <h2 class="logo">
            <a href="home.php">SocialMedia</a>
            </h2>
            <div class="search-bar">
                <i class="uil uil-search"></i>
                <input type="search" placeholder="Search for creators, inspirations, and projects">
            </div>
            <div class="create">
<a class="btn btn-primary" href="logout.php" class="logout-button">Logout</a>
<div class="profile-photo">
                    <img src="./images/profile-1.jpg" alt="">
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container">
            <div class="left">
                <a class="profile">
                    <div class="profile-photo">
                        <img src="./images/profile-1.jpg">
                    </div>
                    <div class="handle">
                        <h4><?php
                echo $_SESSION['username'];
                ?></h4>
                        
                    </div>
                </a>

                <div class="sidebar">
                    <a class="menu-item active">
                        <span><i class="uil uil-home"></i></span>
                        <h3>Home</h3>   
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-compass"></i></span>
                        <h3>Explore</h3>
                    </a>
                    <a class="menu-item"  id="notifications">
                        <span><i class="uil uil-bell"><small class="notification-count">9+</small></i></span>
                        <h3>Notification</h3>
                        <div class="notifications-popup">
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-2.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-3.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>John Doe</b> commented on your post
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-4.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Marry Oppong</b> and <b>283 Others</b> liked your post
                                    <small class="text-muted">4 Minutes Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-5.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Doris Y. Lartey</b> commented on a post you are tagged in
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-6.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Keyley Jenner</b> commented on a post you are tagged in
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-7.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Jane Doe</b> commented on your post
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                        </div>
                        <!--------------- END NOTIFICATION POPUP --------------->
                    </a>
                    <a class="menu-item" id="messages-notifications">
                        <span><i class="uil uil-envelope-alt"><small class="notification-count">6</small></i></span>
                        <h3>Messages</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-bookmark"></i></span>
                        <h3>Bookmarks</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-chart-line"></i></span>
                        <h3>Analytics</h3>
                    </a>
                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span>
                        <h3>Theme</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-setting"></i></span>
                        <h3>Setting</h3>
                    </a>
                </div>
                <!----------------- END OF SIDEBAR -------------------->
                <label class="btn btn-primary" for="create-post">Create Post</label>
            </div>

            <!----------------- MIDDLE -------------------->
            <div class="middle">
                 <!----------------- STORIES -------------------->
                <div class="stories">
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-8.jpg">
                        </div>
                        <p class="name">Your Story</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-9.jpg">
                        </div>
                        <p class="name">Lila James</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-10.jpg">
                        </div>
                        <p class="name">Winnie Haley</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-11.jpg">
                        </div>
                        <p class="name">Daniel Bale</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-12.jpg">
                        </div>
                        <p class="name">Jane Doe</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-13.jpg">
                        </div>
                        <p class="name">Tina White</p>
                    </div>
                </div>
                <!----------------- END OF STORIES -------------------->
                <form method="post" action="" class="create-post">
                    <div class="profile-photo">
                        <img src="./images/profile-11.jpg">
                    </div>
                    <input required minlength="4" name="post-content" type="text" placeholder="What's on your mind, <?php
                echo $_SESSION['username'];
                ?> ?" id="create-post">
                <input name="postbtn" type="submit" value="Post" class="btn btn-primary">
                </form>
                <!----------------- FEEDS -------------------->
                <div class="feeds">
                    
                    <!----------------- FEED 1 -------------------->
                    <?php foreach ($posts as $post): ?>
                        <div class="feed">
    <div class="head">
        <div class="user">
            <div class="profile-photo">
                <img src="./images/profile-1.jpg">
            </div>
            <div class="info">
                <h3><?php echo $post['username']; ?></h3>
                <small>Dubai, 15 Minutes Ago</small>
            </div>
        </div>
        <span class="edit">
            <i class="uil uil-ellipsis-h"></i>
        </span>
    </div>
    <div class="post">
        <div class="caption">
            <p class="post-content"><?php echo $post['content']; ?></p>
        </div>
        <div class="interaction-buttons">
        <form class="like-form" method="post" action="like.php">
    <input type="hidden" name="postId" value="<?php echo $post['id']; ?>">
    <span name="like-button" class="like-count"><?php echo $post['like_count']; ?> Like</span>
    <br>
    <?php

    $query = "SELECT COUNT(*) FROM likes WHERE post_id = :postId AND user_id = :userId";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':postId', $post['id'], PDO::PARAM_INT);
$stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$likeCount = $stmt->fetchColumn();

if ($likeCount > 0) {
    echo '<button class="like-button">Unlike</button>';
} else {
    // Altrimenti, mostra il pulsante Like
    echo '<button class="like-button">Like</button>';
}
    ?>
    
</form>

        </div>
    </div>
</div>

<?php endforeach; ?>
<?php

?>
<style>

.interaction-buttons {
    margin-top: 20px;
}
.like-count{
margin-top:-64px;
}
.like-button,
.comment-button {
    background: var(--color-primary);
    padding: 8px 12px;
    border: none;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 16px;
    margin-top: 16px;
}


.like-button:focus,
.comment-button:focus {
    outline: none;
}


    .post-content {
    font-size: 1.2em;
    font-weight: bold; 
    color: #333; 
    line-height: 1.5; 
}

</style>
                    

                </div>
            </div>

            <div class="right">
                
<?php



$userId = $_SESSION['user_id'];
$sugQuery = "SELECT * FROM users where id != $userId";
$sugStmt = $pdo->prepare($sugQuery);
$sugStmt->execute();
$sug = $sugStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!------- FRIEND REQUEST ------->
<div class="friend-requests">
    <h4>Suggeriti</h4>
    <?php
    foreach ($sug as $suggest):
       
    ?>
                    <div class="request">
                        <div class="info">
                            <div class="profile-photo">
                                <img src="./images/profile-20.jpg">
                            </div>
                            <div>
                                <h5><a href="profile.php?id=<?php echo $suggest['id']; ?>"><?php echo $suggest['username'] ?></a></h5>
                            </div>
                        </div>
                        
                    </div>
                   
                       <?php endforeach; ?>
                </div>
            </div>

            <!----------------- END OF RIGHT -------------------->
        </div>
        
    </main>

    <!----------------- THEME CUSTOMIZATION -------------------->
    <div class="customize-theme">
        <div class="card">
            <h2>Customize your view</h2>
            <p class="text-muted">Manage your font size, color, and background</p>

            <!----------- FONT SIZE ----------->
            <div class="font-size">
                <h4>Font Size</h4>
                <div>
                    <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2 active"></span>
                        <span class="font-size-3"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                </div>
            </div>
        
            <!----------- PRIMARY COLORS ----------->
            <div class="color">
                <h4>Color</h4>
                <div class="choose-color">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                    <span class="color-5"></span>
                </div>
            </div>

            <!----------- BACKGROUND COLORS ----------->
            <div class="background">
                <h4>Background</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Light</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
   
                        <h5 for="bg-2">Dim</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Dark</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
    .post {
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 10px;
}

.post-header {
    display: flex;
    align-items: center;
}

.profile-photo img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.post-info h3 {
    margin: 0;
}

.post-content p {
    margin: 0;
}

.post-actions {
    margin-top: 10px;
}

.post-actions button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    margin-right: 10px;
    cursor: pointer;
}

.post-actions button:hover {
    background-color: #0056b3;
}
.middle .feeds .feed {
    background: var(--color-white);
    border-radius: var(--card-border-radius);
    padding: var(--card-padding);
    margin: 1rem 0;
    font-size: 0.85rem;
    line-height: 1.5;
}

.middle .feed .head {
    display: flex;
    justify-content: space-between;
}

.middle .feed .user {
    display: flex;
    gap: 1rem;
}

.middle .feed .photo {
    border-radius: var(--card-border-radius);
    overflow: hidden;
    margin: 0.7rem 0;
}

.middle .feed .action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.4rem;
    margin: 0.6rem 0;
}

.middle .liked-by {
    display: flex;
}

.middle .liked-by span {
    width: 1.4rem;
    height: 1.4rem;
    display: block;
    border-radius:50%;
    overflow: hidden;
    border: 2px solid var(--color-white);
    margin-left: -0.6rem;
}

.middle .liked-by span:first-child {
    margin: 0;
}

.middle .liked-by p {
    margin-left: 0.5rem;
}

/* =============== Right ============== */
main .container .right {
    height: max-content;
    position: sticky;
    top: var(--sticky-top-right);
    bottom: 0;
}

/* =============== Messages ============== */
.right .messages {
    background: var(--color-white);
    border-radius: var(--card-border-radius);
    padding: var(--card-padding);
}

.right .messages .heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.right .messages i {
    font-size: 1.4rem;
}

.right .messages .search-bar {
    display: flex;
    margin-bottom: 1rem;
}

.right .messages .category {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.right .messages .category h6 {
    width: 100%;
    text-align: center;
    border-bottom: 4px solid var(--color-light);
    padding-bottom: 0.5rem;
    font-size: 0.75rem;
}

.right .messages .category .active {
    border-color: var(--color-dark);
}

.right .messages .message-requests {
    color: var(--color-primary);
}

.right .messages .message {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    align-items: start;
}

.right .message .profile-photo {
    position: relative;
    overflow: visible;
}

.right .profile-photo img {
    border-radius: 50%;
}

.right .messages .message:last-child {
    margin: 0;
}

.right .messages .message p {
    font-size:0.8rem;
}

.right .messages .message .profile-photo .active {
    width: 0.8rem;
    height: 0.8rem;
    border-radius: 50%;
    border: 3px solid var(--color-white);
    background: var(--color-success);
    position: absolute;
    bottom: 0;
    right: 0;
}

/* =============== Friend Requests ============== */
.right .friend-requests {
    margin-top: 1rem;
}

.right .friend-requests h4 {
    color: var(--color-grey);
    margin: 1rem 0;
}

.right .request {
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    margin-bottom: 0.7rem;
}

.right .request .info {
    display: flex;
    gap: 1rem;
    font-size: 24px;
    margin-bottom: 1rem;
}

.right .request .action {
    display: flex;
    gap: 1rem;
}

/* =============== Theme Customization ============== */
.customize-theme {
    background: rgba(0, 0, 0, 0.5);
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100%;
    text-align: center;
    display: grid;
    place-items: center;
    display: none;
}

.customize-theme .card {
    background: var(--color-white);
    padding: 3rem;
    border-radius: var(--card-border-radius);
    width:50%;
    box-shadow: 0 0 1rem var(--color-primary);
}

/* =============== Font Size ============== */
.customize-theme .font-size {
    margin-top: 5rem;
}

.customize-theme .font-size > div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--color-light);
    padding: var(--search-padding);
    border-radius: var(--card-border-radius);
}

.customize-theme .choose-size {
    background: var(--color-secondary);
    height: 0.3rem;
    width: 100%;
    margin: 0 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.customize-theme .choose-size span {
    width: 1rem;
    height: 1rem;
    background: var(--color-secondary);
    border-radius: 50%;
    cursor: pointer;
}

.customize-theme .choose-size span.active {
    background: var(--color-primary);
}

/* =============== Color ============== */
.customize-theme .color {
    margin-top: 2rem;
}

.customize-theme .choose-color {
    background: var(--color-light);
    padding: var(--search-padding);
    border-radius: var(--card-border-radius);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.customize-theme .choose-color span {
    width: 2.2rem;
    height: 2.2rem;
    border-radius: 50%;
}

.customize-theme .choose-color span:nth-child(1) {
    background: hsl(233, 60%, 16%);
}

.customize-theme .choose-color span:nth-child(2) {
    background: hsl(52, 75%, 60%);
}

.customize-theme .choose-color span:nth-child(3) {
    background: hsl(352, 75%, 60%);
}

.customize-theme .choose-color span:nth-child(4) {
    background: hsl(152, 75%, 60%);
}

.customize-theme .choose-color span:nth-child(5) {
    background: hsl(202, 75%, 60%);
}

.customize-theme .choose-color span.active {
    border: 5px solid var(--color-secondary);
}

/* =============== Background ============== */
.customize-theme .background {
    margin-top: 2rem;
}

.customize-theme .choose-bg {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}

.customize-theme .choose-bg > div {
    padding: var(--card-padding);
    width: 100%;
    display: flex;
    align-items: center;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 0.4rem;
    cursor: pointer;
}

.customize-theme .choose-bg > div.active {
    border: 2px solid var(--color-primary);
}

.customize-theme .choose-bg .bg-1 {
    background: white;
    color: black;
}

.customize-theme .choose-bg .bg-2 {
    background: hsl(252, 30%, 17%);
    color: white;
}

.customize-theme .choose-bg .bg-3 {
    background: hsl(252, 30%, 10%);
    color: white;
}

.customize-theme .choose-bg > div span {
    width: 2rem;
    height: 2rem;
    border: 2px solid var(--color-grey);
    border-radius: 50%;
    margin-right: 1rem;
}

/* ================= 
MEDIA QUERIES FOR SMALL LAPTOP AND BIG TABLETS 
==================== */

@media screen and (max-width: 1200px) {
    .container {
        width: 96%;
    }

    main .container {
        grid-template-columns: 5rem auto 30vw;
        gap: 1rem;
    }

    .left {
        width: 5rem;
        z-index: 5;
    }

    main .container .left .profile {
        display: none;
    }

    .sidebar h3 {
        display: none;
    }

    .left .btn {
        display: none;
    }

    .customize-theme .card {
        width: 80vw;
    }
}
.post {
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 10px;
}

.post-header {
    display: flex;
    align-items: center;
}

.profile-photo img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.post-info h3 {
    margin: 0;
}

.post-content p {
    margin: 0;
}

.post-actions {
    margin-top: 10px;
}

.post-actions button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    margin-right: 10px;
    cursor: pointer;
}

.post-actions button:hover {
    background-color: #0056b3;
}


.interaction-buttons {
    margin-top: 20px;
}
.like-count{
margin-top:-64px;
}
.like-button,
.comment-button {
    background: var(--color-primary);
    padding: 8px 12px;
    border: none;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 16px;
    margin-top: 16px;
}


.like-button:focus,
.comment-button:focus {
    outline: none;
}


    .post-content {
    font-size: 1.2em; /* Imposta la dimensione del carattere */
    font-weight: bold; /* Rendi il testo in grassetto */
    color: #333; /* Cambia il colore del testo */
    line-height: 1.5; /* Imposta l'altezza della riga per una migliore leggibilità */
    /* Aggiungi altri stili CSS desiderati */
}

/* ================= 
MEDIA QUERIES FOR SMALL TABLETS AND MOBILE PHONES
==================== */

@media screen and (max-width: 992px) {
    nav .search-bar {
        display: none;
    }

    main .container {
        grid-template-columns: 0 auto 5rem;
        gap: 0;
    }

    main .container .left {
        grid-column: 3/4;
        position: fixed;
        bottom: 0;
        right: 0;
    }

    /* Notification Popup */
    .left .notifications-popup { 
        position: absolute;
        left: -20rem;
        width: 20rem;
    }

    .left .notifications-popup::before {
        display: absolute;
        top: 1.3rem;
        left: calc(20rem - 0.6rem);
        display: block;
    }

    main .container .middle {
        grid-column: 1/3;
    }

    main .container .right {
        display: none;
    }

    .customize-theme .card {
        width: 80vw; 
    }
}
</style>
    <script src="./index.js"></script>
</body>
</html>
