<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="author" content="quenti77">
  <title>MVC PHP</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
</head>
<body>
  <section class="section">
    <div class="container">
      <h1 class="title">Blog en MVC et PHP</h1>
      <p class="subtitle">Exemple d'un blog sans lib externe en MVC nouvelle génération</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?= $content ?? '' ?>
    </div>
  </section>
</body>
</html>
