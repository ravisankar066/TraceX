<?php
require "config.php";
include "includes/auth.php";
$page_title = "Dashboard";

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM investigations WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_cases = $stmt->get_result()->fetch_assoc()["total"];

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM evidence WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_evidence = $stmt->get_result()->fetch_assoc()["total"];

$stmt = $conn->prepare("SELECT score, case_code, created_at FROM investigations WHERE user_id = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$latest = $stmt->get_result()->fetch_assoc();

include "includes/header.php";
?>
<section class="dashboard-head">
    <div>
        <p class="eyebrow">INVESTIGATOR DASHBOARD</p>
        <h1>Welcome, <?= clean($_SESSION["user_name"]) ?>.</h1>
        <p class="muted">Your investigation workspace is ready.</p>
    </div>
    <a href="investigate.php" class="button primary">Open Active Case</a>
</section>

<div class="stats">
    <div class="stat"><span>Investigations</span><strong><?= $total_cases ?></strong></div>
    <div class="stat"><span>Evidence Items</span><strong><?= $total_evidence ?></strong></div>
    <div class="stat"><span>Latest Score</span><strong><?= $latest ? $latest["score"] . "%" : "--" ?></strong></div>
</div>

<section class="workspace">
    <div class="workspace-main">
        <div class="panel-heading">
            <div><p class="eyebrow">ACTIVE CASE</p><h2>CASE-1042 — Account Compromise</h2></div>
            <span class="badge">SIMULATED</span>
        </div>
        <p class="muted">An employee account shows unusual login activity from an external IP address.
        Examine the evidence and determine the most likely attack technique.</p>
        <div class="case-meta">
            <span>Evidence: Login + DNS + HTTP</span>
            <span>Difficulty: Intermediate</span>
            <span>Status: Open</span>
        </div>
        <a href="investigate.php" class="button secondary">Begin Analysis →</a>
    </div>

    <div class="panel">
        <p class="eyebrow">QUICK GUIDE</p>
        <ol class="guide">
            <li>Read the evidence carefully.</li>
            <li>Build the incident timeline.</li>
            <li>Identify the attack technique.</li>
            <li>Submit your conclusion.</li>
            <li>Review the generated report.</li>
        </ol>
    </div>
</section>
<?php include "includes/footer.php"; ?>