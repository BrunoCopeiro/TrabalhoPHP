<?php
include('DefineCredenciais.php');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$message = ''; // Variável para mensagens de sucesso ou erro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['excluir'])) {
        $nomeExcluir = $_POST['nomeExcluir'];
        $sqlVerifica = "SELECT * FROM usuarios WHERE nome = '$nomeExcluir'";
        $resultado = $conn->query($sqlVerifica);

        if ($resultado->num_rows > 0) {
            $sqlExcluir = "DELETE FROM usuarios WHERE nome = '$nomeExcluir'";

            if ($conn->query($sqlExcluir) === TRUE) {
                $message = "<div class='message success'>Usuário excluído com sucesso!</div>";
            } else {
                $message = "<div class='message error'>Erro ao excluir usuário: " . $conn->error . "</div>";
            }
        } else {
            $message = "<div class='message error'>Usuário não encontrado!</div>";
        }
    } elseif (isset($_POST['cadastrar'])) {
        $nome = $_POST['nome'];
        $cpf = str_replace(['.', '-'], '', $_POST['cpf']);

        if (preg_match("/^\d{11}$/", $cpf)) {
            $sql = "INSERT INTO usuarios (nome, cpf) VALUES ('$nome', '$cpf')";

            if ($conn->query($sql) === TRUE) {
                $message = "<div class='message success'>Novo usuário cadastrado com sucesso!</div>";
            } else {
                $message = "<div class='message error'>Erro: " . $conn->error . "</div>";
            }
        } else {
            $message = "<div class='message error'>Formato de CPF inválido! Certifique-se de que o CPF tenha 11 dígitos.</div>";
        }
    } elseif (isset($_POST['editar'])) {
        $nomeEditar = $_POST['nomeEditar'];
        $novoNome = $_POST['novoNome'];
        $novoCpf = str_replace(['.', '-'], '', $_POST['novoCpf']);

        if (preg_match("/^\d{11}$/", $novoCpf)) {
            $sqlVerifica = "SELECT * FROM usuarios WHERE nome = '$nomeEditar'";
            $resultado = $conn->query($sqlVerifica);

            if ($resultado->num_rows > 0) {
                $sqlEditar = "UPDATE usuarios SET nome = '$novoNome', cpf = '$novoCpf' WHERE nome = '$nomeEditar'";

                if ($conn->query($sqlEditar) === TRUE) {
                    $message = "<div class='message success'>Usuário editado com sucesso!</div>";
                } else {
                    $message = "<div class='message error'>Erro ao editar usuário: " . $conn->error . "</div>";
                }
            } else {
                $message = "<div class='message error'>Usuário não encontrado!</div>";
            }
        } else {
            $message = "<div class='message error'>Formato de CPF inválido! Certifique-se de que o CPF tenha 11 dígitos.</div>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar/Excluir/Editar Usuário</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 16px;
            color: #333;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
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
        a {
            display: block;
            text-align: center;
            color: #007BFF;
            text-decoration: none;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .message {
            text-align: center;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .message.success {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #388E3C;
        }
        .message.error {
            background-color: #F44336;
            color: white;
            border: 1px solid #D32F2F;
        }
        .options {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .options a {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .options a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Novo Usuário</h1>
        <form method="post" action="">
            <div class="form-section">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" required>
            </div>
            <div class="form-section">
                <label for="cpf">CPF (formato ###.###.###-##):</label>
                <input type="text" name="cpf" required>
            </div>
            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>

        <hr>

        <h1>Excluir Usuário</h1>
        <form method="post" action="">
            <div class="form-section">
                <label for="nomeExcluir">Nome do Usuário a Excluir:</label>
                <input type="text" name="nomeExcluir" required>
            </div>
            <button type="submit" name="excluir">Excluir</button>
        </form>

        <hr>

        <h1>Editar Usuário</h1>
        <form method="post" action="">
            <div class="form-section">
                <label for="nomeEditar">Nome do Usuário a Editar:</label>
                <input type="text" name="nomeEditar" required>
            </div>
            <div class="form-section">
                <label for="novoNome">Novo Nome:</label>
                <input type="text" name="novoNome" required>
            </div>
            <div class="form-section">
                <label for="novoCpf">Novo CPF (formato ###.###.###-##):</label>
                <input type="text" name="novoCpf" required>
            </div>
            <button type="submit" name="editar">Editar</button>
        </form>

        <?php echo $message; ?>

        <div class="options">
            <a href="index.php">Ir para a Home</a>
            <a href="buscar_usuario.php">Ir para a Busca</a>
        </div>
    </div>
</body>
</html>

