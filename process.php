<?php
session_start();
include 'db.php';

// Operações CRUD para Empréstimos
if (isset($_POST['add_emprestimo'])) {
    $chave_id = $_POST['chave_id'];
    $aluno_cpf = $_POST['aluno_cpf'];
    $senha = $_POST['senha'];

    // Verificar a senha do aluno
    $sql = "SELECT senha FROM alunos WHERE cpf = '$aluno_cpf'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $aluno = $result->fetch_assoc();
        if ($senha == $aluno['senha']) {
            // Senha correta, registrar o empréstimo
            $sql = "INSERT INTO emprestimos (chave_id, aluno_cpf) VALUES ('$chave_id', '$aluno_cpf')";
            if ($conn->query($sql) === TRUE) {
                header('Location: emprestimo-de-chave.php?msg=success_emprestimo');
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Senha incorreta
            header('Location: emprestimo-de-chave.php?msg=wrong_password');
        }
    } else {
        // Aluno não encontrado
        header('Location: emprestimo-de-chave.php?msg=student_not_found');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_emprestimo'])) {
    $chave_id = $_POST['chave_id'];
    $aluno_cpf = $_POST['aluno_cpf'];
    $senha = $_POST['senha'];

    // Verificar se o aluno já possui uma chave emprestada
    $sql = "SELECT chave_id FROM emprestimos WHERE aluno_cpf = '$aluno_cpf' AND data_devolucao IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Aluno já possui uma chave emprestada
        header("Location: emprestimo-de-chave.php?msg=unavailable_aluno");
        exit();
    }

    // Insira aqui o código para registrar o empréstimo...
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_emprestimo'])) {
    $chave_id = $_POST['chave_id'];
    $aluno_cpf = $_POST['aluno_cpf'];
    $senha = $_POST['senha'];

    // Verificar o status da chave
    $sql = "SELECT id FROM emprestimos WHERE chave_id = '$chave_id' AND data_devolucao IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Chave está indisponível
        header("Location: emprestimo-de-chave.php?msg=unavailable_key");
        exit();
    }

    // Insira aqui o código para registrar o empréstimo...
}

// Verifica se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar as credenciais do usuário
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login bem-sucedido
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        // Login falhou
        http_response_code(401); // Define o código de resposta HTTP para indicar falha de autenticação
        exit("Login or password is incorrect.");
    }
}

// Operações CRUD para Alunos
if (isset($_POST['add'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $matricula = $_POST['matricula'];
    $turma = $_POST['turma'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Sem criptografia

    $sql = "INSERT INTO alunos (nome, cpf, matricula, turma, telefone, email, senha) VALUES ('$nome', '$cpf', '$matricula', '$turma', '$telefone', '$email', '$senha')";
    if ($conn->query($sql) === TRUE) {
        header('Location: alunos.php?msg=success');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $matricula = $_POST['matricula'];
    $turma = $_POST['turma'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Sem criptografia

    $sql = "UPDATE alunos SET nome='$nome', cpf='$cpf', matricula='$matricula', turma='$turma', telefone='$telefone', email='$email', senha='$senha' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: alunos.php?msg=updated');
    } else {
        echo "Erro: " . $sql  . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM alunos WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: alunos.php?msg=deleted');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Operações CRUD para Chaves
if (isset($_POST['add_chave'])) {
    $prateleira = $_POST['prateleira'];

    $sql = "INSERT INTO chaves (prateleira) VALUES ('$prateleira')";
    if ($conn->query($sql) === TRUE) {
        header('Location: chaves.php?msg=success_chave');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['update_chave'])) {
    $id = $_POST['id'];
    $prateleira = $_POST['prateleira'];

    $sql = "UPDATE chaves SET prateleira='$prateleira' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: chaves.php?msg=updated_chave');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete_chave'])) {
    $id = $_GET['delete_chave'];
    $sql = "DELETE FROM chaves WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: chaves.php?msg=deleted_chave');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

?>
