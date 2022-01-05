<?php include("include_php/nav_header.php"); ?>

<div class="wrapper">

    <div class="trending card">
        <!--for trending words-->
    </div>

    <div class="newsfeed card">
        <form action="index.php" class="post-form" method="POST">
            <textarea name="post-text-area" id="post-text-area" placeholder="Write a post..."></textarea>
            <input type="submit" name="post" id="post-submit-btn" value="Post">
        </form>
    </div>

    <div class="card">
        <!--additional card-->
    </div>
</div>

</body>

</html>