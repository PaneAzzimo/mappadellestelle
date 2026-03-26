<?php
require 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    die("ID costellazione non valido.");
}

$stmt = $pdo->prepare("SELECT * FROM costellazioni WHERE id_costellazione = ?");
$stmt->execute([$id]);
$costellazione = $stmt->fetch();

if (!$costellazione) {
    die("Costellazione non trovata.");
}

$errore = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'update';

    if ($action === 'delete') {
        try {
            $stmt = $pdo->prepare("DELETE FROM costellazioni WHERE id_costellazione = ?");
            $stmt->execute([$id]);
            header("Location: catalogo.php");
            exit;
        } catch (PDOException $e) {
            $errore = "Errore durante l'eliminazione: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $nome = trim($_POST['nome'] ?? '');

        if (strlen($nome) < 2 || strlen($nome) > 100) {
            $errore = "Il nome deve essere tra 2 e 100 caratteri";
        } elseif ($nome === $costellazione['nome']) {
            header("Location: catalogo.php");
            exit;
        } else {
            try {
                $stmt = $pdo->prepare("
                    UPDATE costellazioni 
                    SET nome = ? 
                    WHERE id_costellazione = ?
                ");
                $stmt->execute([$nome, $id]);
                header("Location: catalogo.php");
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    $errore = "Esiste già un'altra costellazione con questo nome";
                } else {
                    $errore = "Errore durante l'aggiornamento: " . htmlspecialchars($e->getMessage());
                }
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
    <title>Modifica costellazione – <?= htmlspecialchars($costellazione['nome']) ?></title>
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
            <h2>Modifica costellazione</h2>

            <?php if ($errore): ?>
                <div class="error"><?= htmlspecialchars($errore) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-row">
                    <label for="nome">Nome costellazione</label>
                    <input id="nome" name="nome" value="<?= htmlspecialchars($costellazione['nome']) ?>" 
                           required maxlength="100">
                </div>

                <div class="form-actions">
                    <button type="submit" name="action" value="update">Salva modifiche</button>
                    <button type="submit" name="action" value="delete"
                            onclick="return confirm('Vuoi davvero eliminare questa costellazione?\nLe stelle associate perderanno il riferimento.');"
                            class="delete">
                        Elimina costellazione
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