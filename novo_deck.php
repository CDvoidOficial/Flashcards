<?php
// novo_deck.php
include 'layout.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $stmt = $pdo->prepare("INSERT INTO decks (nome, descricao) VALUES (?, ?)");
  $stmt->execute([$nome, $descricao]);
  echo "<p>Deck criado com sucesso!</p>";
}
?>
<h2>Novo Deck</h2>
<form method="post">
  <label>Nome: <input type="text" name="nome" required></label>
  <label>Descrição: <textarea name="descricao"></textarea></label>
  <button type="submit">Criar</button>
</form>
<?php include 'rodape.php'; ?>
