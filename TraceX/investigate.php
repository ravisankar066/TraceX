<?php
require "config.php";
include "includes/auth.php";
$page_title = "Investigate";

$result = null;
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $source_ip = $_POST["source_ip"] ?? "";
    $attack = $_POST["attack"] ?? "";
    $time = $_POST["time"] ?? "";

    $score = 0;
    if ($source_ip === "185.71.22.14") $score++;
    if ($attack === "brute_force") $score++;
    if ($time === "22:34") $score++;

    $percentage = round(($score / 3) * 100);
    $conclusion = $percentage >= 67
        ? "The evidence supports a brute-force account compromise from the external source."
        : "The submitted findings do not fully match the strongest evidence pattern.";

    $stmt = $conn->prepare(
        "INSERT INTO investigations (user_id, case_code, score, conclusion)
         VALUES (?, 'CASE-1042', ?, ?)"
    );
    $stmt->bind_param("iis", $_SESSION["user_id"], $percentage, $conclusion);
    $stmt->execute();

    $result = ["score" => $percentage, "conclusion" => $conclusion];
    $submitted = true;
}
include "includes/header.php";
?>
<section class="investigation">
    <div class="investigation-top">
        <div>
            <p class="eyebrow">CASE-1042 / ANALYSIS</p>
            <h1>Compromised Employee Account</h1>
            <p class="muted">Study the evidence before making your conclusion.</p>
        </div>
        <span class="badge">CASE OPEN</span>
    </div>

    <?php if ($submitted): ?>
        <div class="result-box">
            <p class="eyebrow">INVESTIGATION RESULT</p>
            <h2><?= $result["score"] ?>% Evidence Match</h2>
            <p><?= clean($result["conclusion"]) ?></p>
            <a href="report.php" class="button primary">View Investigation Report</a>
        </div>
    <?php endif; ?>

    <div class="evidence-layout">
        <div>
            <article class="evidence-card">
                <div class="card-title"><h3>01 / Login Logs</h3><span>AUTH</span></div>
                <table class="log-table">
                    <tr><th>Time</th><th>User</th><th>Source IP</th><th>Result</th></tr>
                    <tr><td>22:31:04</td><td>admin</td><td>192.168.1.20</td><td>SUCCESS</td></tr>
                    <tr><td>22:33:17</td><td>admin</td><td>185.71.22.14</td><td class="bad">FAILED</td></tr>
                    <tr><td>22:33:25</td><td>admin</td><td>185.71.22.14</td><td class="bad">FAILED</td></tr>
                    <tr><td>22:34:02</td><td>admin</td><td>185.71.22.14</td><td>SUCCESS</td></tr>
                    <tr><td>22:35:11</td><td>admin</td><td>185.71.22.14</td><td>SUCCESS</td></tr>
                </table>
            </article>

            <article class="evidence-card">
                <div class="card-title"><h3>02 / DNS Record</h3><span>DNS</span></div>
                <div class="code-box">Query: login-check.example
Type: A
Answer: 185.71.22.14
TTL: 300</div>
            </article>

            <article class="evidence-card">
                <div class="card-title"><h3>03 / HTTP Request</h3><span>HTTP</span></div>
                <div class="code-box">POST /login
Host: portal.example
User-Agent: Browser/1.0
Status: 200 OK
Source: 185.71.22.14</div>
            </article>
        </div>

        <aside class="analysis-panel">
            <p class="eyebrow">YOUR FINDINGS</p>
            <h2>Connect the evidence</h2>
            <p class="muted">Select the values supported by the case data.</p>

            <form method="POST" id="investigationForm">
                <label>External source IP</label>
                <select name="source_ip" required>
                    <option value="">Choose IP</option>
                    <option>192.168.1.20</option>
                    <option>185.71.22.14</option>
                    <option>10.0.0.8</option>
                </select>

                <label>Most likely attack</label>
                <select name="attack" required>
                    <option value="">Choose attack</option>
                    <option value="phishing">Phishing</option>
                    <option value="brute_force">Brute Force</option>
                    <option value="sql_injection">SQL Injection</option>
                    <option value="dns_attack">DNS Attack</option>
                </select>

                <label>Approximate successful compromise time</label>
                <select name="time" required>
                    <option value="">Choose time</option>
                    <option>22:31</option>
                    <option>22:34</option>
                    <option>22:35</option>
                </select>

                <button class="button primary full" type="submit">Submit Findings</button>
            </form>
        </aside>
    </div>
</section>
<?php include "includes/footer.php"; ?>