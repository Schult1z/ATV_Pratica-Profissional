<?php
// quadras.php - Página de Quadras Disponíveis (PHP + MySQL)

// Configuração da conexão com o banco de dados
$host = 'localhost';
$dbname = 'quadrafacil';     // Nome do seu banco de dados
$username = 'root';          // Usuário do MySQL (altere se necessário)
$password = '';              // Senha do MySQL (deixe vazio se for root sem senha)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro de conexão com o banco: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quadras Disponíveis - QuadraFacil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo">Quadra<span>Facil</span></div>
            <nav>
                <ul>
                    <li><a href="index.html">Início</a></li>
                    <li><a href="quadras.php">Quadras Disponíveis</a></li>
                    <li><a href="#">Como funciona</a></li>
                    <li><a href="#">Para donos de quadra</a></li>
                    <li><a href="#" class="btn-login">Entrar / Cadastro</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container" style="margin-top: 40px;">
        <h2>Quadras Disponíveis</h2>
        <p style="text-align: center; margin-bottom: 40px; font-size: 18px;">
            Escolha a quadra e veja os horários livres
        </p>

        <?php
        // Busca as quadras cadastradas no banco
        $stmt = $pdo->query("SELECT * FROM quadras ORDER BY nome");
        $quadras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($quadras) > 0):
            echo '<div class="features">';  // reutilizando a classe de cards

            foreach ($quadras as $quadra):
        ?>
            <div class="card">
                <i class="fas fa-futbol"></i>
                <h3><?= htmlspecialchars($quadra['nome']) ?></h3>
                <p><strong>Local:</strong> <?= htmlspecialchars($quadra['endereco']) ?></p>
                <p><strong>Preço/hora:</strong> R$ <?= number_format($quadra['preco_hora'], 2, ',', '.') ?></p>
                <a href="reservar.php?quadra_id=<?= $quadra['id'] ?>" class="btn btn-primary" style="margin-top: 15px; padding: 10px 20px; font-size: 16px;">
                    Ver horários disponíveis
                </a>
            </div>
        <?php
            endforeach;
            echo '</div>';
        else:
        ?>
            <div style="text-align: center; padding: 80px; background: white; border-radius: 16px;">
                <p>Nenhuma quadra cadastrada ainda.</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2026 QuadraFacil - Reserve quadras de forma fácil e prática.</p>
        <p>Curitiba • Paraná • Brasil</p>
    </footer>

</body>
</html>