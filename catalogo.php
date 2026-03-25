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

    <main class="hero" style="padding-top: 2rem; padding-bottom: 4rem;">
        <div class="content-card">
            <h2>Tutte le costellazioni</h2>

            <?php
            $gruppi = $pdo->query("
                SELECT c.id_costellazione, c.nome AS costellazione,
                       s.sao, s.nome, s.ascensione_retta, s.declinazione
                FROM costellazioni c
                LEFT JOIN stelle s ON c.id_costellazione = s.id_costellazione
                ORDER BY c.nome, s.nome
            ")->fetchAll(PDO::FETCH_GROUP);

            if (empty($gruppi)): ?>
                <div class="empty-state">
                    <p>Nessuna costellazione registrata nel momento.</p>
                    <a href="aggiungi_costellazione.php" class="btn-primary">Aggiungi costellazione</a>
                </div>
            <?php else: ?>

                <?php foreach ($gruppi as $id => $righe):
                    $nomeCost = $righe[0]['costellazione'] ?? '(senza nome)'; ?>

                    <div class="costellazione-block">
                        <h3><?= e($nomeCost) ?></h3>

                        <?php if (empty(array_filter($righe, fn($r) => !empty($r['sao'])))): ?>
                            <p class="no-data">Nessuna stella assegnata</p>
                        <?php else: ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>SAO</th>
                                        <th>Nome</th>
                                        <th>AR (h)</th>
                                        <th>Dec (°)</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($righe as $r):
                                    if (empty($r['sao'])) continue; ?>
                                    <tr>
                                        <td><?= e($r['sao']) ?></td>
                                        <td><?= e($r['nome']) ?></td>
                                        <td><?= number_format($r['ascensione_retta'], 6) ?></td>
                                        <td><?= number_format($r['declinazione'], 6) ?></td>
                                        <td>
                                            <a href="modifica_stella.php?sao=<?= urlencode($r['sao']) ?>" 
                                               class="action-link">modifica</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <p class="edit-costellazione">
                            <a href="modifica_costellazione.php?id=<?= $id ?>">Modifica nome costellazione</a>
                        </p>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </main>

</body>
</html>