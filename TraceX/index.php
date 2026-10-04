<?php
$page_title = "Home";
include "includes/header.php";
?>
<section class="hero">
    <div class="hero-text">
        <p class="eyebrow">CYBER INCIDENT INVESTIGATION</p>
        <h1>Follow the evidence.<br><span>Find the attack.</span></h1>
        <p class="hero-copy">
            TraceX is a simulated investigation platform where you examine digital evidence,
            connect events and determine how a cyber incident happened.
        </p>
        <div class="hero-actions">
            <a href="register.php" class="button primary">Start Investigation</a>
            <a href="#how" class="button secondary">How it works</a>
        </div>
    </div>

    <div class="incident-preview">
        <div class="window-bar"><span></span><span></span><span></span></div>
        <div class="terminal-line">TRACEX / INCIDENT CONSOLE</div>
        <div class="status-line"><b>CASE-1042</b><em>ACTIVE</em></div>
        <div class="log"><small>22:31:04</small> LOGIN_SUCCESS <i>192.168.1.20</i></div>
        <div class="log alert"><small>22:33:17</small> LOGIN_FAILED <i>185.71.22.14</i></div>
        <div class="log alert"><small>22:34:02</small> LOGIN_SUCCESS <i>185.71.22.14</i></div>
        <div class="log"><small>22:35:11</small> SESSION_CREATED <i>185.71.22.14</i></div>
        <div class="mini-status"><span></span> Evidence collection in progress</div>
    </div>
</section>

<section id="how" class="section">
    <div class="section-title">
        <p class="eyebrow">THE WORKFLOW</p>
        <h2>From raw evidence to a clear conclusion.</h2>
    </div>
    <div class="feature-grid">
        <article class="feature-card">
            <div class="number">01</div>
            <h3>Collect</h3>
            <p>Review simulated login, DNS and HTTP evidence connected to the incident.</p>
        </article>
        <article class="feature-card">
            <div class="number">02</div>
            <h3>Analyze</h3>
            <p>Compare timestamps, source addresses and attack indicators to build a timeline.</p>
        </article>
        <article class="feature-card">
            <div class="number">03</div>
            <h3>Conclude</h3>
            <p>Submit your findings and generate a structured investigation report.</p>
        </article>
    </div>
</section>

<section class="project-strip">
    <div>
        <p class="eyebrow">WHY TRACEX?</p>
        <h2>Learn cybersecurity by investigating it.</h2>
    </div>
    <p>Designed as an academic project to demonstrate incident analysis, web development,
       database handling and basic security practices in one platform.</p>
</section>
<?php include "includes/footer.php"; ?>