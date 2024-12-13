<header>
    <nav>
        <div class="logo_wrapper">
            <a href="index.php"><img src="assets/img/logo.png" alt="Logo de The Academy"></a>
        </div>
        <ul>
            <?php
                if (isset($_SESSION['id'])) {
                    echo "<li><a href='bestiary.php'>Bestiary</a></li>";
                    echo "<li><a href='codex.php'>Codex</a></li>";
                    echo "<li><a href='profile.php'>My profile</a></li>";
                    echo "<li><a href='logout.php'>Log out</a></li>";
                } else {
                    echo "<li><a href='bestiary.php'>Bestiary</a></li>";
                    echo "<li><a href='codex.php'>Codex</a></li>";
                    echo "<li><a href='login.php'>Log in</a></li>";
                    echo "<li><a href='sign_in.php'>Sign in</a></li>";
                }
            ?>
        </ul>
    </nav>
</header>
