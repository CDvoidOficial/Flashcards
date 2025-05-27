<?php // layout.php ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashcards</title>
  <link rel="stylesheet" href="style.css">

  <!-- Estilo adicional para barra de progresso e responsividade -->
  <style>
    body {
      background-color: #f8f9fa;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    header {
      background-color: #007bff;
      color: white;
      padding: 15px;
      text-align: center;
    }

    nav {
      margin-top: 10px;
    }

    nav a {
      margin: 0 10px;
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    main {
      max-width: 800px;
      margin: 20px auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .progress-container {
      margin-bottom: 20px;
    }

    .progress-bar {
      width: 100%;
      background-color: #e9ecef;
      border-radius: 10px;
      overflow: hidden;
      height: 20px;
    }

    .progress-bar-fill {
      height: 100%;
      background-color: #28a745;
      text-align: center;
      color: white;
      line-height: 20px;
      font-size: 0.9em;
      width: 0%;
      transition: width 0.3s ease-in-out;
    }

    img {
      max-width: 100%;
      height: auto;
      margin-bottom: 15px;
    }

    .btn-group {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .btn-group button {
      flex: 1;
      margin: 5px;
      padding: 10px;
      font-size: 16px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: white;
    }

    .btn-group button:hover {
      background-color: #0056b3;
    }

    button#mostrarRespostaBtn {
      background-color: #ffc107;
      color: black;
    }

    button#mostrarRespostaBtn:hover {
      background-color: #e0a800;
    }
  </style>
</head>
<body>
  <header>
    <h1>Flashcards</h1>
    <nav>
      <a href="index.php">Início</a>
      <a href="novo_deck.php">Novo Deck</a>
      <a href="estatisticas.php">Estatísticas</a>
    </nav>
  </header>
  <main>
