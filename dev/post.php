
<?php
    session_start(); // start the session

    if(isset($_SESSION['username'])) :?>
        <nav>
        <a href="./home.php">Home</a>
        <a href="./post.php">Create Post</a>
        <a href="./editProfile.php">Edit Profile</a>
        <a href="./logout.php">Logout</a>
        </nav>
    <link rel="stylesheet" href="../assets/css/postt.css">
    <h1>Create Post</h1>
    <form method="post" action="">
    <label for="post-name">Post Name:</label>
    <input type="text" name="post-name" id="post-name">

    <label for="post-data">Content:</label>
    <textarea name="post-data" id="post-data"></textarea>
    
    <div class="checkbox-container">
        <input type="checkbox" name="anonymous" id="anonymous">
    <span id="anonymous-label">Anonymous Post</span>
    
    </div>

    <br>
    <br>
    <label>Tags:</label>
    <div class="checkbox-container">
        <input type="checkbox" name="tags[]" value="programming" id="programming-tag">
        <label for="programming-tag">Programming</label>

        <input type="checkbox" name="tags[]" value="food" id="food-tag">
        <label for="food-tag">Food</label>

        <input type="checkbox" name="tags[]" value="art" id="art-tag">
        <label for="art-tag">Art</label>

        <input type="checkbox" name="tags[]" value="music" id="music-tag">
        <label for="music-tag">Music</label>

        <input type="checkbox" name="tags[]" value="other" id="other-tag">
        <label for="other-tag">Other</label>
    </div>

    

    <input type="submit" value="Submit">
    
    <?php echo "USER: " . $_SESSION['username']?>
    </form>
            <h1>My posts</h1>


<?php
    //Till att skriva ut "Mina" posts (inloggade användarens posts)
    if(isset($_SESSION['username'])) {
        
        $usr = $_SESSION['username'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "BelConnectDB";
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $sql = "SELECT * FROM posts WHERE username = '$usr' ORDER BY created_at DESC";
        $result = $conn->query($sql);
        //echo mysqli_num_fields($result);
        while ($row = $result->fetch_assoc()) {
            echo '<div class="post-container">';
            echo '<div class="post-header">' . $row['post_name'] . '</div>';
            echo '<div class="post-meta">By ' . $row['author'] . " (you)". ' on ' . $row['created_at'] . '</div>';
            echo '<div class="post-content">' . $row['post_data'] . '</div>';

            // Display the tags for the post
            $tags = explode(',', $row['tags']);
            echo '<div class="post-tags">';
            foreach($tags as $tag) {
                echo '<span class="tag ' . $tag . '">' . $tag . '</span>';
            }
            echo '</div>';

            echo '</div>';
        }
        

    }
?>

<?php else : ?>
    <h1>no access</h1>
    <a href="./logout.php">Back</a>
<?php endif; ?>


<?php
    //Till att lägga upp inlägg
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
       if(isset($_POST['post-name']) && isset($_POST['tags'])){
         if(!empty($_POST['post-data'] && !empty($_POST['post-name']))){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "BelConnectDB";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            
            $username = $_SESSION['username'];
            $postName = strip_tags($_POST['post-name']);
            $postData = strip_tags($_POST['post-data']);
            $author = isset($_POST['anonymous']) ? "Anonymous" : $_SESSION['username'];
            $tags = implode(',', $_POST['tags']);
            
            $sql = "INSERT INTO posts (author, username, post_name, post_data, tags) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $author ,$username, $postName, $postData, $tags);
            $stmt->execute();
            header("Location: post.php");
         }else{
            echo "<script>alert('Please fill out all fileds.')</script>";
         }
            
       }else{
        echo "<script>alert('Fill out all fileds and select a tag to create a post.')</script>";
       }
    
    }
    
?>

