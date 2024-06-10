<?php
// Session dimulai
session_start();

// Koneksi ke database
include 'config/db.php';

// Variabel kosong agar tidak error, diperlukan untuk message login validation
$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") { // Kondisi ketika form login disubmit
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header("Location:index.php");
        } else {
            $message = "Password salah";
        }
    } else {
        $message = "Username tidak ditemukan";
    }
    $stmt->close();
}
$conn->close();
?>
<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Login</h3>
                </div>
                <div class="card-body">

                    <!-- Flash Message Validation -->
                    <?php if($message){ ?>
                    <div class="alert alert-warning">
                        <?php echo $message; ?>
                    </div>
                    <?php } ?>

                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                        <div class="form-group mt-3 text-center">
                            <a href="register.php">Belum punya akun? Daftar di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
