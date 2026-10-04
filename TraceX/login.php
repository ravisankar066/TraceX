<?php
require "config.php";
$page_title = "Login";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
include "includes/header.php";
?>
<section class="form-page">
    <div class="form-card">
        <p class="eyebrow">INVESTIGATOR LOGIN</p>
        <h1>Welcome back.</h1>
        <p class="muted">Continue your incident investigation.</p>

        <?php if ($error): ?><div class="message error"><?= clean($error) ?></div><?php endif; ?>

        <form method="POST">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="button primary full" type="submit">Login</button>
        </form>
        <p class="form-bottom">New investigator? <a href="register.php">Create an account</a></p>
    </div>
</section>
<?php include "includes/footer.php"; ?>