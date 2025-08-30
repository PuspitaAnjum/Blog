<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['post'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO blogs (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Write a Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <span class="logo">My Blog</span>
    <div>
        <a href="blog.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <h2>Write Your Blog</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Blog Title" required>
        <textarea name="content" rows="6" placeholder="Write your blog here..." required></textarea>
        <button type="submit" name="post">Publish</button>
    </form>

    <h2>Recent Blogs</h2>
    <?php
    $result = $conn->query("SELECT blogs.*, users.username FROM blogs JOIN users ON blogs.user_id=users.id ORDER BY blogs.created_at DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small>By " . htmlspecialchars($row['username']) . " on " . $row['created_at'] . "</small>";
        echo "</div>";
    }
    ?>
</div>
</body>
</html>