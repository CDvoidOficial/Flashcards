<?php
// index.php
include 'layout.php';
include 'db.php';
$decks = $pdo->query("SELECT * FROM decks")->fetchAll();
?>
<h2>Meus Baralhos</h2>
<ul>
  <?php foreach ($decks as $deck): ?>
    <li>
      <strong><?= htmlspecialchars($deck['nome']) ?></strong><br>
      <?= nl2br(htmlspecialchars($deck['descricao'])) ?><br>
      <a href="revisar.php?deck=<?= $deck['id'] ?>">Revisar</a> |
      <a href="adicionar_flashcard.php?deck_id=<?= $deck['id'] ?>">Adicionar Flashcard</a>
    </li>
  <?php endforeach; ?>
</ul>
<?php include 'rodape.php'; ?>
