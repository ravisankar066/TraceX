<?php
require "config.php";
include "includes/auth.php";
$page_title = "Evidence";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = trim($_POST["type"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($type === "" || $description === "") {
        $message = "Evidence type and description are required.";
    } else {
        $file_name = "";

        if (!empty($_FILES["evidence_file"]["name"])) {
            $allowed = ["jpg", "jpeg", "png", "pdf", "txt"];
            $extension = strtolower(pathinfo($_FILES["evidence_file"]["name"], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowed) || $_FILES["evidence_file"]["size"] > 2 * 1024 * 1024) {
                $message = "Allowed files: JPG, PNG, PDF, TXT. Maximum size: 2 MB.";
            } else {
                $file_name = uniqid("evidence_") . "." . $extension;
                move_uploaded_file($_FILES["evidence_file"]["tmp_name"], "uploads/" . $file_name);
            }
        }

        if ($message === "") {
            $stmt = $conn->prepare(
                "INSERT INTO evidence (user_id, evidence_type, description, file_name)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("isss", $_SESSION["user_id"], $type, $description, $file_name);
            $stmt->execute();
            $message = "Evidence added successfully.";
        }
    }
}

$stmt = $conn->prepare("SELECT evidence_type, description, file_name, created_at FROM evidence WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$items = $stmt->get_result();

include "includes/header.php";
?>
<section class="page-head">
    <p class="eyebrow">EVIDENCE VAULT</p>
    <h1>Collect supporting evidence.</h1>
    <p class="muted">Add notes or small evidence files to your investigation.</p>
</section>

<?php if ($message): ?><div class="message success"><?= clean($message) ?></div><?php endif; ?>

<div class="two-column">
    <div class="panel">
        <h2>Add Evidence</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Evidence Type</label>
            <select name="type" required>
                <option value="">Choose type</option>
                <option>Login Log</option>
                <option>Network Log</option>
                <option>DNS Record</option>
                <option>Screenshot</option>
                <option>Investigator Note</option>
            </select>

            <label>Description</label>
            <textarea name="description" rows="6" required placeholder="Explain what this evidence shows..."></textarea>

            <label>Optional File</label>
            <input type="file" name="evidence_file" accept=".jpg,.jpeg,.png,.pdf,.txt">

            <button class="button primary full" type="submit">Store Evidence</button>
        </form>
    </div>

    <div>
        <div class="panel-heading"><h2>Your Evidence</h2><span class="badge">DATABASE</span></div>
        <?php if ($items->num_rows === 0): ?>
            <div class="empty">No evidence added yet.</div>
        <?php endif; ?>

        <?php while ($item = $items->fetch_assoc()): ?>
            <article class="saved-evidence">
                <div><span class="tag"><?= clean($item["evidence_type"]) ?></span><small><?= clean($item["created_at"]) ?></small></div>
                <p><?= clean($item["description"]) ?></p>
                <?php if ($item["file_name"]): ?><small>File attached: <?= clean($item["file_name"]) ?></small><?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</div>
<?php include "includes/footer.php"; ?>