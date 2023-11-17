<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    if (empty($action)) {
        header("Location:" . URL . "municipio.php");
    }

    switch ($action) {
        case "create":
            $name = strtoupper(htmlspecialchars(trim($_POST["name"])));

            if (empty($name)) {
                $error = "No se ha ingresado el nombre del nuevo municipio.";
            } else {
                $stateExits = $conn->query("SELECT ID FROM MUNICIPIO WHERE NOMBRE = '$name'");

                if ($stateExits->num_rows > 0) {
                    $error = "El municipio ya existe en la base de datos.";
                } else {
                    $conn->query("INSERT INTO MUNICIPIO (NOMBRE) VALUES ('$name')");
                }
            }

            break;

        case "update":
            echo "actualizar";

            $id = htmlspecialchars(trim($_POST["id"]));
            $name = strtoupper(htmlspecialchars(trim($_POST["name"])));

            $stateExits = $conn->query("SELECT ID FROM MUNICIPIO WHERE ID = $id");

            if ($stateExits->num_rows == 0) {
                $error = "No existe el municipio que se desea actualizar";
            } else {
                $conn->query("UPDATE MUNICIPIO SET NOMBRE = '$name' WHERE ID = $id");
                header("Location:" . URL . "municipio.php");
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
            $stateExits = $conn->query("SELECT ID FROM MUNICIPIO WHERE ID = '$id'");

            if ($stateExits->num_rows === 0) {
                $error = "El municipio no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM MUNICIPIO WHERE ID = $id");
                header("Location:" . URL . "municipio.php");
            }
        }
    }
}

$result = $conn->query("SELECT ID, NOMBRE FROM MUNICIPIO");

$conn->close();

require "./views/municipio.view.php";