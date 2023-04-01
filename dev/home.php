<!DOCTYPE html>
<html>
<head>
    <title>BelConnect - Home</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>
        <?php 
        session_start();
        if(isset($_SESSION['username'])) :?>
            <nav>
                <a href="./home.php">Home</a>
                <a href="./post.php">Create Post</a>
                <a href="./editProfile.php">Edit Profile</a>
                <a href="./logout.php">Logout</a>
            </nav>

            <?php
                $tags = array("other", "food", "art", "programming", "music");
                // Check if the form was submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $selected_tags = isset($_POST['tags']) ? $_POST['tags'] : array();
                } else {
                    // By default, all tags are selected
                    $selected_tags = $tags;
                };

               
                $usr = $_SESSION['username'];
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "BelConnectDB";
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Build the WHERE clause for the tags
                $where_clause = "";
                foreach ($selected_tags as $tag) {
                    if ($where_clause == "") {
                        $where_clause = "WHERE tags LIKE '%$tag%'";
                    } else {
                        $where_clause .= " OR tags LIKE '%$tag%'";
                    }
                }

                $sql = "SELECT * FROM posts $where_clause ORDER BY created_at DESC";
                $result = $conn->query($sql);
                
                echo '
                    <h1 style="text-align:center; margin-top:50px;">Welcome, ' . $usr . "!" .'</h1>
                    <form method="POST" id="filter-form" style="text-align:center">
                        <h3>Filter posts by tag:</h3>
                        <div id="tags-container">';
                foreach ($tags as $tag) {
                    $checked = in_array($tag, $selected_tags) ? "checked" : "";
                    echo '<label><input type="checkbox" name="tags[]" value="' . $tag . '" ' . $checked . '> ' . ucfirst($tag) . '</label><br>';
                }
                echo '
                        </div>
                        <button type="submit">Filter</button>
                    </form>
                    <div id="feed">';
                    echo '<h2>All posts</h2>';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="post-container">';
                    echo '<div class="post-header">' . $row['post_name'] . '</div>';
                    echo '<div class="post-meta">By ' . $row['username'] . ' on ' . $row['created_at'] . '</div>';
                    echo '<div class="post-content">' . $row['post_data'] . '</div>';

                    // Display the tags for the post
                    $post_tags = explode(',', $row['tags']);
                    $post_tags_filtered = array_intersect($tags, $post_tags);
                    if (!empty($post_tags_filtered)) {
                        echo '<div class="post-tags">';
                        foreach($post_tags_filtered as $tag) {
                            echo '<span class="tag ' . $tag . '">' . ucfirst($tag) . '</span>';
                        }
                        echo '</div>';
                    }

                    echo '</div>';
                }
                echo '</div>';
            ?>
    <?php else:?>
        <h1>no access</h1>
        <a href="./logout.php">Back</a>
    <?php endif; ?>
</body>
</html>