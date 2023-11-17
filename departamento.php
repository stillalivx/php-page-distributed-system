<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    if (empty($action)) {
        header("Location:" . URL . "departamento.php");
    }

    $name = strtoupper(htmlspecialchars(trim($_POST["name"])));
    $description = strtoupper(htmlspecialchars(trim($_POST["description"])));

    switch ($action) {
        case "create":
            if (empty($name) || empty($description)) {
                $error = "Los datos del nuevo departamento están incompletos";
            } else {
                $departmentExists = $conn->query("SELECT COUNT(*) AS COUNT FROM DEPARTAMENTO WHERE NOMBRE = '$name'");
                $departmentExists = mysqli_fetch_array($departmentExists);

                if ($departmentExists["COUNT"] > 0) {
                    $error = "El departamento ya se ha registrado";
                } else {
                    $conn->query("INSERT INTO DEPARTAMENTO (NOMBRE, DESCRIPCION) VALUES ('$name', '$description')");
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));

            $conn->query("UPDATE DEPARTAMENTO SET NOMBRE = '$name', DESCRIPCION = '$description' WHERE ID = $id");
            header("Location:" . URL . "departamento.php");

            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["action"])) {
    $action = strtolower(htmlspecialchars(trim($_GET["action"])));

    if ($action === "delete") {
        $id = htmlspecialchars(trim($_GET["id"]));

        if (empty($id)) {
            $error = "Es necesario incluir el id del registro que se desea eliminar";
        } else {
            $departmentExists = $conn->query("SELECT ID FROM DEPARTAMENTO WHERE ID = '$id'");

            if ($departmentExists->num_rows === 0) {
                $error = "El departamento no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM DEPARTAMENTO WHERE ID = $id");
                header("Location:" . URL . "departamento.php");
            }
        }
    }
}

$result = $conn->query("SELECT ID, NOMBRE, DESCRIPCION FROM DEPARTAMENTO");

$conn->close();

require "./views/departamento.view.php";