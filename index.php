<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h1>Selamat Datang, <?php echo $_SESSION['name']; ?>!</h1>
</div>

<?php include 'includes/footer.php'; ?>
