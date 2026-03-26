<?php
require 'db.php';

$errore = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');

    if (strlen($nome) < 2 || strlen($nome) > 100) {
        $errore = "Il nome deve essere tra 2 e 100 caratteri";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO costellazioni (nome) VALUES (?)");
            $stmt->execute([$nome]);
            header("Location: catalogo.php");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                $errore = "Esiste già una costellazione con questo nome";
            } else {
                $errore = "Errore durante il salvataggio: " . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi costellazione</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="home-body">

    <header class="site-header">
        <h1>Catalogo Stelle</h1>
        <nav>
            <a href="index.php">Home</a> |
            <a href="catalogo.php">Catalogo</a> |
            <a href="aggiungi_stella.php">Aggiungi stella</a> |
            <a href="aggiungi_costellazione.php">Aggiungi costellazione</a>
        </nav>
    </header>

    <main class="hero">
        <div class="form-card content-card">
            <h2>Aggiungi nuova costellazione</h2>

            <?php if ($errore): ?>
                <div class="error"><?= htmlspecialchars($errore) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-row">
                    <label for="nome">Nome costellazione</label>
                    <input id="nome" name="nome" required maxlength="100"
                           placeholder="es. Orsa Maggiore, Scorpione, Centauro">
                </div>

                <div class="form-actions">
                    <button type="submit">Aggiungi costellazione</button>
                </div>
            </form>

            <p class="back-link">
                <a href="catalogo.php">← Torna al catalogo</a>
            </p>
        </div>
    </main>

</body>
</html>