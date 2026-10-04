<?php
require "config.php";
include "includes/auth.php";
$page_title = "Report";

$stmt = $conn->prepare(
    "SELECT case_code, score, conclusion, created_at
     FROM investigations WHERE user_id = ? ORDER BY id DESC LIMIT 1"
);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$report = $stmt->get_result()->fetch_assoc();

include "includes/header.php";
?>
<section class="report-page">
    <div class="report-actions">
        <div>
            <p class="eyebrow">INVESTIGATION REPORT</p>
            <h1>TraceX Findings</h1>
        </div>
        <button class="button secondary" onclick="window.print()">Print / Save PDF</button>
    </div>

    <?php if (!$report): ?>
        <div class="empty">Complete an investigation first to generate a report.</div>
    <?php else: ?>
        <article class="report-card">
            <div class="report-header">
                <div class="brand"><span>TR</span> TraceX</div>
                <div>CASE <?= clean($report["case_code"]) ?></div>
            </div>

            <div class="report-summary">
                <div><span>Investigator</span><strong><?= clean($_SESSION["user_name"]) ?></strong></div>
                <div><span>Evidence Match</span><strong><?= clean($report["score"]) ?>%</strong></div>
                <div><span>Date</span><strong><?= clean($report["created_at"]) ?></strong></div>
            </div>

            <h2>Incident Conclusion</h2>
            <p><?= clean($report["conclusion"]) ?></p>

            <h2>Key Evidence</h2>
            <ul class="report-list">
                <li>Repeated failed logins originated from 185.71.22.14.</li>
                <li>A successful login followed the failed attempts.</li>
                <li>DNS and HTTP records reference the same external source.</li>
                <li>The event sequence is consistent with the selected attack technique.</li>
            </ul>

            <div class="report-note">
                <strong>Academic simulation:</strong> The evidence used by TraceX is generated for
                learning and demonstration purposes and does not represent a real incident.
            </div>
        </article>
    <?php endif; ?>
</section>
<?php include "includes/footer.php"; ?>