<nav class=navbar>
    <a <?php if ($currentPage == 'home') echo 'class="active"'; ?> href=home.php>Home</a>
    <a <?php if ($currentPage == 'browse') echo 'class="active"'; ?> href=images.php>Browse</a>
    <a <?php if ($currentPage == 'insert') echo 'class="active"'; ?> href=insert.php>Add</a>
</nav>
<nav class=navbar2>
    <?php if (isset($_SESSION['username'])) : ?>
        <nav><a href='userhandling.php'>Log out</a>
            <p>Welcome, <?= $_SESSION['username']; ?>. </p>
        </nav>
    <?php else : ?>
        <nav <?php if ($currentPage == 'login') echo 'class="active"'; ?>><a href='../database/userhandling.php'>Login</a><a href='../database/register.php'>Register</a></nav>
    <?php endif; ?>
</nav>