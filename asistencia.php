<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    $status = strtoupper(htmlspecialchars(trim($_POST["status"])));
    $datetime = strtoupper(htmlspecialchars(trim($_POST["datetime"])));
    $employeeId = strtoupper(htmlspecialchars(trim($_POST["employeeId"])));

    if (empty($action)) {
        header("Location:" . URL . "asistencia.php");
    }

    switch ($action) {
        case "create":
            if (empty($status) || empty($datetime) || empty($employeeId)) {
                $error = "La información para registrar la asistencia está incompleta.";
            } else {
                $userExits = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = '$employeeId'");
                $userExits = mysqli_fetch_array($userExits);

                if ($userExits["COUNT"] == 0) {
                    $error = "El empleado no existe en la base de datos.";
                } else {
                    $conn->query("INSERT INTO ASISTENCIA (ESTADO, FECHA, EMPLEADO_ID) VALUES ('$status', '$datetime', '$employeeId')");
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));

            $checkExists = $conn->query("SELECT COUNT(*) AS COUNT FROM ASISTENCIA WHERE ID = $id");
            $checkExists = mysqli_fetch_array($checkExists);

            $userExits = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = $employeeId");
            $userExits = mysqli_fetch_array($userExits);

            if ($checkExists["COUNT"] == 0 || $userExits["COUNT"] == 0) {
                $error = "Información invalida";
            } else {
                $conn->query("UPDATE ASISTENCIA SET ESTADO = '$status', FECHA = '$datetime', EMPLEADO_ID = '$employeeId' WHERE ID = $id");
                header("Location:" . URL . "asistencia.php");
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
            $checkExits = $conn->query("SELECT COUNT(*) AS COUNT FROM ASISTENCIA WHERE ID = '$id'");
            $checkExits = mysqli_fetch_array($checkExits);

            if ($checkExits["COUNT"] == 0) {
                $error = "La asistencia no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM ASISTENCIA WHERE ID = $id");
                header("Location:" . URL . "asistencia.php");
            }
        }
    }
}

$result = $conn->query("SELECT ASISTENCIA.ID AS ID, ESTADO, FECHA, EMPLEADO.NOMBRE,  
        EMPLEADO.APELLIDO_PAT, EMPLEADO.APELLIDO_MAT, EMPLEADO_ID 
    FROM ASISTENCIA
    LEFT JOIN EMPLEADO ON ASISTENCIA.EMPLEADO_ID = EMPLEADO.ID");

$employees = $conn->query("SELECT ID, NOMBRE, APELLIDO_PAT, APELLIDO_MAT FROM EMPLEADO");

$conn->close();

require "./views/asistencia.view.php";