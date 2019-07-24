<h2 class="subtitle">Liste des articles</h2>

<ul>
  <?php foreach ($posts ?? [] as $post): ?>
    <li>
      <a href="/blog/<?= $post->getId() ?>-<?= $post->getSlug() ?>" class="is-link">
         <?= htmlspecialchars($post->getName()) ?> (créé le <?= $post->getCreatedAt()->format('d/m/Y \à H:i:s') ?>)
      </a>
    </li>
  <?php endforeach; ?>
</ul>
