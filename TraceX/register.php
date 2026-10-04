<?php
require "config.php";
$page_title = "Register";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = "Enter valid details. Password must contain at least 6 characters.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "An account with this email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hash);
            $stmt->execute();

            session_start();
            $_SESSION["user_id"] = $stmt->insert_id;
            $_SESSION["user_name"] = $name;
            header("Location: dashboard.php");
            exit;
        }
    }
}
include "includes/header.php";
?>
<section class="form-page">
    <div class="form-card">
        <p class="eyebrow">CREATE ACCOUNT</p>
        <h1>Enter the investigation room.</h1>
        <p class="muted">Create a free TraceX investigator account.</p>

        <?php if ($error): ?><div class="message error"><?= clean($error) ?></div><?php endif; ?>

        <form method="POST" id="registerForm">
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" id="password" required>
            <div id="passwordHint" class="hint"></div>

            <button class="button primary full" type="submit">Create Account</button>
        </form>
        <p class="form-bottom">Already registered? <a href="login.php">Login</a></p>
    </div>
</section>
<?php include "includes/footer.php"; ?>