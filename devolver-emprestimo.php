<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emprestimo_id'])) {
    $emprestimo_id = $_POST['emprestimo_id'];

    // Remover o empréstimo do banco de dados
    $sql = "DELETE FROM emprestimos WHERE id='$emprestimo_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Empréstimo devolvido com sucesso!";
    } else {
        echo "Erro ao devolver empréstimo: " . $conn->error;
    }
}
?>

