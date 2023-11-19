<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    if (empty($action)) {
        header("Location:" . URL . "contacto_emerg.php");
    }

    $name = strtoupper(htmlspecialchars(trim($_POST["name"])));
    $paternalSurname = strtoupper(htmlspecialchars(trim($_POST["paternalSurname"])));
    $maternalSurname = strtoupper(htmlspecialchars(trim($_POST["maternalSurname"])));
    $parentesco = strtoupper(htmlspecialchars(trim($_POST["parentesco"])));
    $employeeId = strtoupper(htmlspecialchars(trim($_POST["employeeId"])));
    $phone = strtoupper(htmlspecialchars(trim($_POST["phone"])));
    $email = strtoupper(htmlspecialchars(trim($_POST["email"])));

    switch ($action) {
        case "create":
            if (
                empty($name) || empty($paternalSurname) || empty($maternalSurname) || empty($parentesco) ||
                empty($employeeId) || empty($phone) || empty($email)
            ) {
                $error = "Los datos del nuevo contacto de emergencia están incompletos";
            } else {
                $employeeExists = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = '$employeeId'");
                $employeeExists = mysqli_fetch_array($employeeExists);

                if ($employeeExists["COUNT"] == 0) {
                    $error = "El empleado asignado al contacto no existe.";
                } else {
                    $conn->query("INSERT INTO CONTACTO_EMERG (NOMBRE, APELLIDO_PAT, APELLIDO_MAT, PARENTESCO, EMPLEADO_ID, TELEFONO, CORREO)
                            VALUES ('$name', '$paternalSurname', '$maternalSurname', '$parentesco', '$employeeId', '$phone', '$email')");
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));

            $employeeExists = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = '$id'");
            $employeeExists = mysqli_fetch_array($employeeExists);

            if ($employeeExists["COUNT"] == "0") {
                $error = "El empleado asignado no existe.";
            } else {
                $conn->query("UPDATE CONTACTO_EMERG SET 
                    NOMBRE = '$name',
                    APELLIDO_PAT = '$paternalSurname',
                    APELLIDO_MAT = '$maternalSurname',
                    PARENTESCO = '$parentesco',
                    EMPLEADO_ID = '$employeeId',
                    TELEFONO = '$phone',
                    CORREO = '$email'
                    WHERE ID = $id;
                ");
                header("Location:" . URL . "contacto_emerg.php");
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
            $contactExists = $conn->query("SELECT COUNT(*) AS COUNT FROM CONTACTO_EMERG WHERE ID = '$id'");
            $contactExists = mysqli_fetch_array($contactExists);

            if ($contactExists["COUNT"] === 0) {
                $error = "El contacto no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM CONTACTO_EMERG WHERE ID = $id");
                header("Location:" . URL . "contacto_emerg.php");
            }
        }
    }
}

$result = $conn->query(
    "SELECT CONTACTO_EMERG.ID AS ID, CONTACTO_EMERG.NOMBRE, CONTACTO_EMERG.APELLIDO_PAT, CONTACTO_EMERG.APELLIDO_MAT, CONTACTO_EMERG.CORREO AS CORREO,
        TELEFONO, EMPLEADO.NOMBRE AS EMPLEADO_NOMBRE, EMPLEADO.APELLIDO_PAT AS EMPLEADO_APELLIDO_PAT, EMPLEADO.APELLIDO_MAT AS EMPLEADO_APELLIDO_MAT, PARENTESCO,
        EMPLEADO_ID
    FROM CONTACTO_EMERG
    LEFT JOIN EMPLEADO ON CONTACTO_EMERG.EMPLEADO_ID = EMPLEADO.ID"
);

$employees = $conn->query("SELECT ID, NOMBRE, APELLIDO_PAT, APELLIDO_MAT FROM EMPLEADO");

$conn->close();

require "./views/contacto_emerg.view.php";