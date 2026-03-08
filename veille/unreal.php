<?php
require_once 'veille.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Veille Unreal Engine</title>
<script src="https://kit.fontawesome.com/8419f108ca.js" crossorigin="anonymous"></script>

<style>
:root {
  --primary-color: #4CAF50;
  --secondary-color: #333;
  --light-color: #f9f9f9;
  --accent-color: #555;
  --text-dark: #2c3e50;
  --text-light: #7f8c8d;
  --shadow-1: 0 4px 6px rgba(0,0,0,0.1);
  --shadow-2: 0 6px 12px rgba(0,0,0,0.15);
}
body {
  font-family: 'Montserrat', sans-serif;
  background: var(--light-color);
  color: var(--secondary-color);
  margin: 0;
  padding: 0;
}
a { text-decoration: none; }
.back-button-contact {
  display: inline-block; margin: 1.5rem 2rem; padding: 0.5rem 1rem;
  background: var(--primary-color); color: #fff; border-radius: 8px;
  font-weight: 700; transition: all 0.3s ease;
}
.back-button-contact:hover {
  background: var(--accent-color); transform: translateY(-2px);
}
.veille-page { max-width: 1200px; margin: 0 auto; padding: 2rem; }
.veille-page h1 {
  font-size: 2rem; display: flex; align-items: center; gap: 0.5rem;
  margin-bottom: 1rem;
}
.veille-page p { line-height: 1.6; margin-bottom: 2rem; }
.veille-btn {
  background-color: var(--primary-color); color: #fff;
  padding: 0.8rem 1.5rem; border-radius: 12px;
  font-weight: 700; margin: 0.3rem; display: inline-block;
  transition: all 0.3s ease;
}
.veille-btn:hover {
  background-color: var(--accent-color); transform: translateY(-3px);
  box-shadow: var(--shadow-2);
}
.veille-source-links { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem; margin-bottom: 2rem; }
.veille-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px,1fr));
  gap: 1.5rem; margin-bottom: 3rem;
}
.veille-card {
  background: #fff; padding: 1.5rem; border-radius: 12px;
  box-shadow: var(--shadow-1); transition: all 0.3s ease;
}
.veille-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-2); }
.veille-card h3 { margin-top: 0; color: var(--text-dark); }
.veille-date { font-size: 0.85rem; color: var(--accent-color); margin-bottom: 1rem; }
</style>
</head>
<body>

<a href="../index.html#veille" class="back-button-contact">
← Retour au portfolio
</a>

<main class="veille-page">

<h1><i class="<?php echo $currentConfig['icon']; ?>"></i> <?php echo $currentConfig['titre']; ?></h1>
<p><?php echo $currentConfig['desc']; ?></p>

<div class="veille-source-links">
    <a href="unreal.php?sujet=unreal_enginenews" class="veille-btn">Actualités UnrealEngineNews</a>
    <a href="unreal.php?sujet=unreal_youtube" class="veille-btn">YouTube</a>
    <a href="unreal.php?sujet=unreal_reddit" class="veille-btn">Reddit</a>
</div>

<div class="veille-grid">
<?php if (!empty($articles)): ?>
    <?php foreach ($articles as $art): ?>
    <article class="veille-card">
        <h3><?php echo $art['title']; ?></h3>
        <p><?php echo $art['desc']; ?></p>
        <p class="veille-date"><?php echo $art['date']; ?></p>
        <a href="<?php echo $art['link']; ?>" target="_blank" class="veille-btn">
            Lire l'article complet
        </a>
    </article>
    <?php endforeach; ?>
<?php else: ?>
    <p style="color:red;">Impossible de charger les actualités pour le moment.</p>
<?php endif; ?>
</div>

<section class="veille-sources">
<h2>Sources d’actualité Unreal Engine</h2>
<a href="https://www.unrealengine.com/news" target="_blank" class="veille-btn">Unreal Engine News</a>
<a href="https://www.youtube.com/@UnrealEngine" target="_blank" class="veille-btn">YouTube Unreal</a>
<a href="https://www.reddit.com/r/unrealengine/" target="_blank" class="veille-btn">Reddit Unreal</a>
</section>

</main>
</body>
</html>