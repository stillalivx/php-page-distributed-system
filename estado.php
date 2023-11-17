<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    if (empty($action)) {
        header("Location:" . URL . "estado.php");
    }

    switch ($action) {
        case "create":
            $name = strtoupper(htmlspecialchars(trim($_POST["name"])));

            if (empty($name)) {
                $error = "No se ha ingresado el nombre del nuevo estado.";
            } else {
                $stateExits = $conn->query("SELECT ID FROM ESTADO WHERE NOMBRE = '$name'");

                if ($stateExits->num_rows > 0) {
                    $error = "El estado ya existe en la base de datos.";
                } else {
                    $conn->query("INSERT INTO ESTADO (NOMBRE) VALUES ('$name')");
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));
            $name = strtoupper(htmlspecialchars(trim($_POST["name"])));

            $stateExits = $conn->query("SELECT ID FROM ESTADO WHERE ID = $id");

            if ($stateExits->num_rows == 0) {
                $error = "No existe el estado que se desea actualizar";
            } else {
                $conn->query("UPDATE ESTADO SET NOMBRE = '$name' WHERE ID = $id");
                header("Location:" . URL . "estado.php");
            }

            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["action"])) {
    $action = strtolower(htmlspecialchars(trim($_GET["action"])));

    if ($action === "delete") {
        $id = htmlspecialchars(trim($_GET["id"]));

        if (empty($id)) {
            $error = "Es necesario incluir el id del registro que se desea eliminar";
        } else {
            $stateExits = $conn->query("SELECT ID FROM ESTADO WHERE ID = '$id'");

            if ($stateExits->num_rows === 0) {
                $error = "El estado no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM ESTADO WHERE ID = $id");
                header("Location:" . URL . "estado.php");
            }
        }
    }
}

$result = $conn->query("SELECT ID, NOMBRE FROM ESTADO");

$conn->close();

require "./views/estado.view.php";