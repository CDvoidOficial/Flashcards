<?php
// db.php
$pdo = new PDO('mysql:host=localhost;dbname=flashcards', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
