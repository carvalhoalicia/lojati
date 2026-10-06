<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "loja" : "teste");

function teste() {
    echo "API respondendo com sucesso!";
}

function readClientes($con){
    header("Content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function createCliente($con){
    $nome = $_POST["Nome"] ?? "";
    $email = $_POST["Email"] ?? "";
    $telefone = $_POST["Telefone"] ?? "";
    $endereco = $_POST["Endereco"] ?? "";

    try {
        $stmt = $con->prepare("INSERT INTO clientes (Nome, Email, Telefone, Endereco) VALUES (?,?,?,?)");
        $stmt -> execute([$nome, $email, $telefone, $endereco]);
        header("Location: ../front/index.html");
    }catch(PDOException $e) {
        header("Location: ../front/erro.html");
    }
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    createCliente($con);
}else if ($rota === "clientes"){
    readClientes($con);
}else {
    teste();
}

?>