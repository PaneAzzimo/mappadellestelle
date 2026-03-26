<?php
require 'db.php';

$sao = trim($_GET['sao'] ?? '');
if (empty($sao)) {
    die("Parametro SAO mancante.");
}

$stmt = $pdo->prepare("SELECT * FROM stelle WHERE sao = ?");
$stmt->execute([$sao]);
$row = $stmt->fetch();

if (!$row) {
    die("Stella non trovata.");
}

$costellazioni = $pdo->query("SELECT * FROM costellazioni ORDER BY nome")->fetchAll();

$errore = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'update';

    if ($action === 'delete') {
        try {
            $stmt = $pdo->prepare("DELETE FROM stelle WHERE sao = ?");
            $stmt->execute([$sao]);
            header("Location: catalogo.php");
            exit;
        } catch (PDOException $e) {
            $errore = "Errore durante l'eliminazione: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $nome = trim($_POST['nome'] ?? '');
        $ar   = (float)($_POST['ar']   ?? 0);
        $dec  = (float)($_POST['dec']  ?? 0);
        $cid  = !empty($_POST['cid']) ? (int)$_POST['cid'] : null;

        if (empty($nome) || strlen($nome) > 100) {
            $errore = "Nome obbligatorio (max 100 caratteri)";
        } elseif ($ar < 0 || $ar >= 24) {
            $errore = "Ascensione retta deve essere 0–24";
        } elseif ($dec < -90 || $dec > 90) {
            $errore = "Declinazione deve essere -90/+90";
        } else {
            try {
                $stmt = $pdo->prepare("
                    UPDATE stelle 
                    SET nome = ?, ascensione_retta = ?, declinazione = ?, id_costellazione = ?
                    WHERE sao = ?
                ");
                $stmt->execute([$nome, $ar, $dec, $cid, $sao]);
                header("Location: catalogo.php");
                exit;
            } catch (PDOException $e) {
                $errore = "Errore durante l'aggiornamento: " . htmlspecialchars($e->getMessage());
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
    <title>Modifica stella – <?= htmlspecialchars($row['nome'] ?? 'Stella') ?></title>
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
            <h2>Modifica stella – <?= htmlspecialchars($row['sao']) ?></h2>

            <?php if ($errore): ?>
                <div class="error"><?= htmlspecialchars($errore) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-row readonly">
                    <label for="sao">SAO (non modificabile)</label>
                    <input id="sao" value="<?= htmlspecialchars($row['sao']) ?>" disabled>
                </div>

                <div class="form-row">
                    <label for="nome">Nome</label>
                    <input id="nome" name="nome" value="<?= htmlspecialchars($row['nome']) ?>" required maxlength="100">
                </div>

                <div class="form-row">
                    <label for="ar">Ascensione retta (ore)</label>
                    <input id="ar" name="ar" type="number" step="any" min="0" max="23.99999999"
                           value="<?= htmlspecialchars($row['ascensione_retta']) ?>" required>
                </div>

                <div class="form-row">
                    <label for="dec">Declinazione (gradi)</label>
                    <input id="dec" name="dec" type="number" step="any" min="-90" max="90"
                           value="<?= htmlspecialchars($row['declinazione']) ?>" required>
                </div>

                <div class="form-row">
                    <label for="cid">Costellazione</label>
                    <select id="cid" name="cid">
                        <option value="">— nessuna —</option>
                        <?php foreach ($costellazioni as $c): ?>
                            <option value="<?= $c['id_costellazione'] ?>"
                                <?= $c['id_costellazione'] == $row['id_costellazione'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" name="action" value="update">Salva modifiche</button>
                    <button type="submit" name="action" value="delete"
                            onclick="return confirm('Confermi l\'eliminazione di questa stella?');"
                            class="delete">
                        Elimina stella
                    </button>
                </div>
            </form>

            <p class="back-link">
                <a href="catalogo.php">← Torna al catalogo</a>
            </p>
        </div>
    </main>

</body>
</html>