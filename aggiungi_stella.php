<?php
require 'db.php';

$costellazioni = $pdo->query("SELECT * FROM costellazioni ORDER BY nome")->fetchAll();

$errore = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sao = trim($_POST['sao'] ?? '');
    $nome = trim($_POST['nome'] ?? '');
    $ar   = (float)($_POST['ar']   ?? 0);
    $dec  = (float)($_POST['dec']  ?? 0);
    $cid  = !empty($_POST['cid']) ? (int)$_POST['cid'] : null;

    if (!preg_match('/^[A-Za-z0-9]{3,6}$/', $sao)) {
        $errore = "SAO non valido (3-6 caratteri alfanumerici)";
    } elseif (empty($nome) || strlen($nome) > 100) {
        $errore = "Nome obbligatorio (max 100 caratteri)";
    } elseif ($ar < 0 || $ar >= 24) {
        $errore = "Ascensione retta deve essere tra 0 e 24 ore";
    } elseif ($dec < -90 || $dec > 90) {
        $errore = "Declinazione deve essere tra -90 e +90 gradi";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT 1 FROM stelle WHERE sao = ?");
            $stmt->execute([$sao]);
            if ($stmt->fetch()) {
                $errore = "Esiste già una stella con questo SAO";
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO stelle 
                    (sao, nome, ascensione_retta, declinazione, id_costellazione) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([$sao, $nome, $ar, $dec, $cid]);
                header("Location: catalogo.php");
                exit;
            }
        } catch (PDOException $e) {
            $errore = "Errore database: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi stella</title>
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
            <h2>Aggiungi nuova stella</h2>

            <?php if ($errore): ?>
                <div class="error"><?= htmlspecialchars($errore) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-row">
                    <label for="sao">SAO</label>
                    <input id="sao" name="sao" required maxlength="6" pattern="[A-Za-z0-9]{3,6}">
                </div>

                <div class="form-row">
                    <label for="nome">Nome</label>
                    <input id="nome" name="nome" required maxlength="100">
                </div>

                <div class="form-row">
                    <label for="ar">Ascensione retta (ore)</label>
                    <input id="ar" name="ar" type="number" step="any" min="0" max="23.99999999" required>
                </div>

                <div class="form-row">
                    <label for="dec">Declinazione (gradi)</label>
                    <input id="dec" name="dec" type="number" step="any" min="-90" max="90" required>
                </div>

                <div class="form-row">
                    <label for="cid">Costellazione</label>
                    <select id="cid" name="cid">
                        <option value="">— nessuna —</option>
                        <?php foreach ($costellazioni as $c): ?>
                            <option value="<?= $c['id_costellazione'] ?>">
                                <?= htmlspecialchars($c['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit">Aggiungi stella</button>
                </div>
            </form>

            <p class="back-link">
                <a href="catalogo.php">← Torna al catalogo</a>
            </p>
        </div>
    </main>

</body>
</html>