<?php

require_once(__DIR__ . '/../config.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>À propos — Campus Bien-être</title>
    <link rel="stylesheet" href="../ressources/css/apropos.css">
</head>
<body>
<?php include '../source/inclue/header.php'?>

<header class="hero">
    <div class="hero-text">
        <p class="hero-eyebrow">✦ Notre histoire</p>
        <h1 class="hero-title">Un espace pour <em>prendre soin</em> de soi et <em>s'informer</em></h1>
        <p class="hero-desc">Campus Bien-être est né d'une conviction simple : la santé mentale et émotionnelle des étudiants mérite une vraie place dans la vie universitaire.</p>
    </div>
    <div class="hero-visual">
        <div class="hero-circle">
            <div class="hero-circle-inner">✿</div>
        </div>
    </div>
</header>

<!-- Mission -->
<section class="section">
    <h2 class="section-title">Notre mission</h2>
    <p class="section-subtitle">Ce qui nous anime chaque jour</p>
    <div class="mission-card">
        <p class="mission-quote">Créer un campus où chaque étudiant se sent entendu, soutenu et épanoui.</p>
        <p class="mission-text">Nous proposons un forum d'échange bienveillant, des ressources adaptées aux défis du quotidien étudiant, et une communauté soudée autour du bien-être. Notre plateforme est un lieu de partage sans jugement, où chacun peut exprimer ses émotions, chercher du soutien ou simplement se sentir moins seul.</p>
    </div>
</section>

<div class="divider">✦</div>

<!-- Valeurs -->
<section class="section">
    <h2 class="section-title">Nos valeurs</h2>
    <p class="section-subtitle">Les piliers qui guident chacune de nos actions</p>
    <div class="values-grid">
        <div class="value-card">
            <div class="value-icon">🌿</div>
            <h3 class="value-name">Bienveillance</h3>
            <p class="value-desc">Un espace sans jugement où chaque voix est accueillie avec douceur et respect.</p>
        </div>
        <div class="value-card">
            <div class="value-icon">🔒</div>
            <h3 class="value-name">Confiance</h3>
            <p class="value-desc">La confidentialité et la sécurité de nos membres sont notre priorité absolue.</p>
        </div>
        <div class="value-card">
            <div class="value-icon">🌱</div>
            <h3 class="value-name">Croissance</h3>
            <p class="value-desc">Nous croyons en la capacité de chacun à évoluer et à trouver son équilibre.</p>
        </div>
    </div>
</section>

<div class="divider">✦</div>

<!-- Chiffres -->
<section class="section">
    <h2 class="section-title">En quelques chiffres</h2>
    <p class="section-subtitle">Une communauté qui grandit chaque jour</p>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number">2<span>K</span><span style="font-size:1.4rem">+</span></div>
            <div class="stat-label">Étudiants membres</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">8<span>K</span><span style="font-size:1.4rem">+</span></div>
            <div class="stat-label">Messages échangés</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">4<span>.</span>9</div>
            <div class="stat-label">Note de satisfaction</div>
        </div>
    </div>
</section>

<div class="divider">✦</div>

<!-- Équipe -->
<section class="section">
    <h2 class="section-title">Notre équipe</h2>
    <p class="section-subtitle">Des personnes passionnées à votre écoute</p>
    <div class="team-grid">
        <div class="team-card">
            <div class="team-avatar sage">AKG</div>
            <h3 class="team-name">Anaïs Kriegel--Grapain</h3>
            <p class="team-role">Co-fondatrice</p>
            <p class="team-bio">Étudiante en informatique.</p>
        </div>
        <div class="team-card">
            <div class="team-avatar accent">RD</div>
            <h3 class="team-name">Rosie Djamga</h3>
            <p class="team-role">Co-fondatrice</p>
            <p class="team-bio">Etudiante en informatique.</p>
        </div>
        <div class="team-card">
            <div class="team-avatar linen">ON</div>
            <h3 class="team-name">Onesime Ngakosso-Ibara</h3>
            <p class="team-role">Co-fondateur</p>
            <p class="team-bio">Etudiant en informatique.</p>
        </div>
        <div class="team-card">
            <div class="team-avatar accent">JH</div>
            <h3 class="team-name">Jordan Homere</h3>
            <p class="team-role">Co-fondateur</p>
            <p class="team-bio">Etudiant en informatique.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section">
    <div class="cta-block">
        <h2 class="cta-title">Rejoignez la communauté</h2>
        <p class="cta-desc">Prenez part à un espace d'échange sincère et bienveillant.<br>Parce que prendre soin de soi, ça s'apprend ensemble.</p>
        <a href="#" class="cta-btn"> Rejoindre le forum</a>
    </div>
</section>

<?php include '../source/inclue/footer.php'?>


</body>
</html>

