<?php
require_once 'config.php';

$message = '';

// Gérer la soumission des deux formulaires
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ajouter un département
    if (isset($_POST['action']) && $_POST['action'] == 'add_department') {
        $dep_name = trim($_POST['dep_name'] ?? '');
        if (!empty($dep_name)) {
            $stmt = $pdo->prepare("INSERT INTO departments (name) VALUES (:name)");
            try {
                $stmt->execute([':name' => $dep_name]);
                $message = "✔️ Département '$dep_name' ajouté avec succès !";
            } catch (PDOException $e) {
                $message = "❌ Erreur : " . $e->getMessage();
            }
        }
    }

    // 2. Ajouter un employé
    if (isset($_POST['action']) && $_POST['action'] == 'add_employee') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $department_id = $_POST['department_id'] ?? '';

        if (!empty($name) && !empty($email) && !empty($department_id)) {
            $stmt = $pdo->prepare("INSERT INTO employees (name, email, department_id) VALUES (:name, :email, :department_id)");
            try {
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':department_id' => $department_id
                ]);
                $message = "✔️ Employé '$name' ajouté avec succès !";
            } catch (PDOException $e) {
                $message = "❌ Erreur : " . $e->getMessage();
            }
        }
    }
}

// Récupérer les données brutes pour affichage basique (sans jointure, vous ferez vos tests SQL plus tard)
$stmtDeps = $pdo->query("SELECT * FROM departments");
$departments = $stmtDeps->fetchAll(PDO::FETCH_ASSOC);

$stmtEmp = $pdo->query("SELECT * FROM employees ORDER BY id DESC");
$employees = $stmtEmp->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie de données - Pour tests SQL</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 40px 20px; color: #333; }
        .container { max-width: 900px; margin: auto; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h1 { color: #2c3e50; text-align: center; margin-bottom: 40px; }
        h2 { color: #34495e; font-size: 1.2rem; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.9rem; color: #555; }
        input[type="text"], input[type="email"], select { width: 100%; padding: 10px; border: 1px solid #ccd0d5; border-radius: 5px; box-sizing: border-box; font-size: 14px; }
        button { background-color: #3498db; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; font-weight: bold; width: 100%; transition: 0.2s; }
        button:hover { background-color: #2980b9; }
        .btn-green { background-color: #2ecc71; }
        .btn-green:hover { background-color: #27ae60; }
        .message { padding: 15px; background-color: #e8f8f5; color: #117a8b; border-radius: 6px; margin-bottom: 20px; text-align: center; font-weight: bold; border: 1px solid #d1ecf1; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 0.9rem; }
        th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        th { background-color: #f8f9fa; color: #555; }
        .id-badge { background: #eee; padding: 3px 6px; border-radius: 4px; font-size: 0.8rem; font-family: monospace; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestion des ressources humaines</h1>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="grid">
        <!-- Formulaire Département -->
        <div class="card">
            <h2>1. Créer un Département</h2>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="add_department">
                <div class="form-group">
                    <label>Nom du département :</label>
                    <input type="text" name="dep_name" placeholder="Ex: Comptabilité, Logistique..." required>
                </div>
                <button type="submit" class="btn-green">+ Ajouter ce département</button>
            </form>

            <table style="margin-top: 25px;">
                <tr><th>ID</th><th>Département (Table: departments)</th></tr>
                <?php foreach ($departments as $d): ?>
                    <tr>
                        <td><span class="id-badge"><?php echo $d['id']; ?></span></td>
                        <td><?php echo htmlspecialchars($d['name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Formulaire Employé -->
        <div class="card">
            <h2>2. Ajouter un Employé</h2>
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="add_employee">
                <div class="form-group">
                    <label>Nom de l'employé :</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email :</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Associer à un département (ID) :</label>
                    <select name="department_id" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($departments as $dep): ?>
                            <option value="<?php echo $dep['id']; ?>"><?php echo htmlspecialchars($dep['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">+ Enregistrer l'employé</button>
            </form>

            <table style="margin-top: 25px;">
                <tr><th>ID</th><th>Nom</th><th>ID Dép. (Foreign Key)</th></tr>
                <?php foreach (array_slice($employees, 0, 5) as $e): ?> <!-- Affiche les 5 derniers -->
                    <tr>
                        <td><span class="id-badge"><?php echo $e['id']; ?></span></td>
                        <td><?php echo htmlspecialchars($e['name']); ?></td>
                        <td><span class="id-badge"><?php echo $e['department_id']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

</body>
</html>
