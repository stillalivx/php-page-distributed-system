<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    if (empty($action)) {
        header("Location:" . URL . "direccion.php");
    }

    $street = strtoupper(htmlspecialchars(trim($_POST["street"])));
    $nExt = strtoupper(htmlspecialchars(trim($_POST["nExt"])));
    $nInt = strtoupper(htmlspecialchars(trim($_POST["nInt"])));
    $colony = strtoupper(htmlspecialchars(trim($_POST["colony"])));
    $postalCode = strtoupper(htmlspecialchars(trim($_POST["postalCode"])));
    $municipioId = (int)htmlspecialchars(trim($_POST["municipioId"]));
    $stateId = (int)htmlspecialchars(trim($_POST["stateId"]));

    switch ($action) {
        case "create":
            if (
                empty($street) || empty($nExt) || empty($nInt) || empty($colony) ||
                empty($postalCode) || empty($municipioId) || empty($stateId)
            ) {
                $error = "La información de la nueva dirección se encuentra incompleta.";
            } else {
                $municipioExists = $conn->query("SELECT COUNT(*) AS COUNT FROM MUNICIPIO WHERE ID = '$municipioId'");
                $municipioExists = mysqli_fetch_array($municipioExists);

                $stateExits = $conn->query("SELECT COUNT(*) AS COUNT FROM ESTADO WHERE ID = '$stateId'");
                $stateExits = mysqli_fetch_array($stateExits);

                if ($municipioExists["COUNT"] == 0 || $stateExits["COUNT"] == 0) {
                    $error = "El municipio o estado no existe dentro de la base de datos";
                } else {
                    $conn->query("INSERT INTO DIRECCION (
                       CALLE, EXT, `INT`, COLONIA, COD_POSTAL, MUNICIPIO_ID, ESTADO_ID
                    ) VALUES (
                        '$street', '$nExt', '$nInt', '$colony', '$postalCode', $municipioId, $stateId        
                    )");
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));

            print_r($id);

            $addressExists = $conn->query("SELECT COUNT(*) AS COUNT FROM DIRECCION WHERE ID = '$id'");
            $addressExists = mysqli_fetch_array($addressExists);

            if ($addressExists["COUNT"] == 0) {
                $error = "No existe la dirección que se desea actualizar";
            } else {
                $municipioExists = $conn->query("SELECT COUNT(*) AS COUNT FROM ESTADO WHERE ID = '$municipioId'");
                $municipioExists = mysqli_fetch_array($municipioExists);

                $stateExits = $conn->query("SELECT COUNT(*) AS COUNT FROM MUNICIPIO WHERE ID = '$stateId'");
                $stateExits = mysqli_fetch_array($stateExits);

                if ($municipioExists["COUNT"] == 0 || $stateExits["COUNT"] == 0) {
                    $error = "El municipio o estado no existe dentro de la base de datos";
                } else {
                    $conn->query("
                        UPDATE DIRECCION 
                        SET
                            CALLE = '$street',
                            EXT = '$nExt',
                            `INT` = '$nInt',
                            COLONIA = '$colony',
                            COD_POSTAL = '$postalCode',
                            MUNICIPIO_ID = '$municipioId',
                            ESTADO_ID = '$stateId'
                        WHERE ID = '$id'
                    ");

                    header("Location:" . URL . "direccion.php");
                }
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
            $stateExits = $conn->query("SELECT COUNT(*) AS COUNT FROM DIRECCION WHERE ID = '$id'");
            $stateExits = mysqli_fetch_array($stateExits);

            if ($stateExits["COUNT"] == 0) {
                $error = "El municipio no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM DIRECCION WHERE ID = $id");
                header("Location:" . URL . "direccion.php");
            }
        }
    }
}

$result = $conn->query("SELECT
        DIRECCION.ID, CALLE, EXT, `INT`, COLONIA, COD_POSTAL, 
        MUNICIPIO.NOMBRE AS MUNICIPIO, ESTADO.NOMBRE AS ESTADO,
        MUNICIPIO_ID, ESTADO_ID
    FROM DIRECCION 
        LEFT JOIN MUNICIPIO ON DIRECCION.MUNICIPIO_ID = MUNICIPIO.ID
        LEFT JOIN ESTADO ON DIRECCION.ESTADO_ID = ESTADO.ID
");

$municipios = $conn->query("SELECT ID, NOMBRE FROM MUNICIPIO");
$estados = $conn->query("SELECT ID, NOMBRE FROM ESTADO");

$conn->close();

require './views/direccion.view.php';