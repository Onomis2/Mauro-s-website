<link rel="stylesheet" href="../styles/navbar.css">
<nav class=navbar>
    <a <?php if ($currentPage == 'home') echo 'class="active"'; ?> href=home.php>Home</a>
    <a <?php if ($currentPage == 'browse') echo 'class="active"'; ?> href=images.php>Browse</a>
    <a <?php if ($currentPage == 'insert') echo 'class="active"'; ?> href=insert.php>Add</a>
    <div class=navbar2>
        <?php if (isset($_SESSION['username'])) : ?> <a href='../database/userhandling.php'>Log out</a>
            <span>Welcome, <?= $_SESSION['username']; ?>.</span>
        <?php else : ?>
            <?php if ($currentPage == 'login') echo 'class="active"'; ?>><a href='../database/userhandling.php'>Login</a><a href='../database/register.php'>Register</a>
        <?php endif; ?>
    </div>
</nav>