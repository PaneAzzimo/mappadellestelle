<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo Stelle</title>
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
        <?php
        $row = $pdo->query("
            SELECT s.*, c.nome AS costellazione 
            FROM stelle s 
            LEFT JOIN costellazioni c ON s.id_costellazione = c.id_costellazione 
            ORDER BY RAND() LIMIT 1
        ")->fetch();

        if ($row): ?>
            <div class="star-card">
                <h1 class="star-name"><?= e($row['nome']) ?></h1>
                <div class="star-sao">SAO <?= e($row['sao']) ?></div>

                <div class="star-specs">
                    <div class="spec-row">
                        <div class="spec-label">Costellazione</div>
                        <div class="spec-value"><?= e($row['costellazione'] ?: 'Non assegnata') ?></div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-label">Ascensione retta</div>
                        <div class="spec-value"><?= number_format($row['ascensione_retta'], 6) ?> h</div>
                    </div>

                    <div class="spec-row">
                        <div class="spec-label">Declinazione</div>
                        <div class="spec-value"><?= number_format($row['declinazione'], 6) ?>°</div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>Nessuna stella nel catalogo</h2>
                <p>Inizia aggiungendo la tua prima stella!</p>
                <a href="aggiungi_stella.php" class="btn-primary">Aggiungi stella</a>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>