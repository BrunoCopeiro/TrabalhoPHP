<?php
include('DefineCredenciais.php');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$nome = isset($_GET['nome']) ? $_GET['nome'] : '';
$cpf = isset($_GET['cpf']) ? $_GET['cpf'] : '';

$sql = "SELECT * FROM usuarios WHERE nome LIKE '%$nome%' AND cpf LIKE '%$cpf%'";
$result = $conn->query($sql);

function formatarCpf($cpf) {
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuário</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 30px;
        }
        label {
            font-size: 16px;
            color: #333;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
        }
        .links a {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Buscar Usuário</h1>
        <form method="get" action="">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" placeholder="Digite o nome do usuário">
            
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" value="<?= htmlspecialchars($cpf) ?>" placeholder="Digite o CPF">

            <button type="submit">Buscar</button>
        </form>

        <h2>Resultados da Busca</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de Cadastro</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['nome'] ?></td>
                            <td><?= formatarCpf($row['cpf']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['data_cadastro'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Nenhum registro encontrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="links">
            <a href="index.php">Ir para a Home</a>
            <a href="novo_usuario.php">Ir para a Opções de Usuario</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
