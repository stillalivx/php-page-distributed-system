<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    if (empty($action)) {
        header("Location:" . URL . "cargo.php");
    }

    $name = strtoupper(htmlspecialchars(trim($_POST["name"])));
    $expLevel = strtoupper(htmlspecialchars(trim($_POST["expLevel"])));
    $salary = strtoupper(htmlspecialchars(trim($_POST["salary"])));

    switch ($action) {
        case "create":
            if (empty($name) || empty($expLevel) || empty($salary)) {
                $error = "Los datos del nuevo cargo están incompletos";
            } else {
                $positionExists = $conn->query("SELECT COUNT(*) AS COUNT FROM CARGO WHERE NOMBRE = '$name'");
                $positionExists = mysqli_fetch_array($positionExists);

                if ($positionExists["COUNT"] > 0) {
                    $error = "El cargo ya se ha registrado";
                } else {
                    $conn->query("INSERT INTO CARGO (NOMBRE, NIVEL_EXP, SALARIO) VALUES ('$name', '$expLevel', '$salary')");
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));

            $conn->query("UPDATE CARGO SET NOMBRE = '$name', NIVEL_EXP = '$expLevel', SALARIO = '$salary' WHERE ID = $id");
            header("Location:" . URL . "cargo.php");

            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["action"])) {
    $action = strtolower(htmlspecialchars(trim($_GET["action"])));

    if ($action === "delete") {
        $id = htmlspecialchars(trim($_GET["id"]));

        if (empty($id)) {
            $error = "Es necesario incluir el id del registro que se desea eliminar";
        } else {
            $positionExists = $conn->query("SELECT COUNT(*) AS COUNT FROM CARGO WHERE ID = '$id'");
            $positionExists = mysqli_fetch_array($positionExists);

            if ($positionExists["COUNT"] === 0) {
                $error = "El cargo no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM CARGO WHERE ID = $id");
                header("Location:" . URL . "cargo.php");
            }
        }
    }
}

$result = $conn->query("SELECT ID, NOMBRE, NIVEL_EXP, SALARIO FROM CARGO");

$conn->close();

require "./views/cargo.view.php";