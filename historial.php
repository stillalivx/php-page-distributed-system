<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    $position = strtoupper(htmlspecialchars(trim($_POST["position"])));
    $dateStart = strtoupper(htmlspecialchars(trim($_POST["dateStart"])));
    $dateEnd = strtoupper(htmlspecialchars(trim($_POST["dateEnd"])));
    $employeeId = strtoupper(htmlspecialchars(trim($_POST["employeeId"])));
    $salary = strtoupper(htmlspecialchars(trim($_POST["salary"])));

    if (empty($action)) {
        header("Location:" . URL . "historial.php");
    }

    switch ($action) {
        case "create":
            if (empty($position) || empty($dateStart) || empty($dateEnd) || empty($employeeId) || empty($salary)) {
                $error = "La información para registrar el historial está incompleta.";
            } else {
                $userExits = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = '$employeeId'");
                $userExits = mysqli_fetch_array($userExits);

                if ($userExits["COUNT"] == 0) {
                    $error = "El empleado no existe en la base de datos.";
                } else {
                    $conn->query("INSERT INTO HISTORIAL (CARGO, FECHA_INICIO, FECHA_TERMINACION, SALARIO, EMPLEADO_ID) 
                        VALUES ('$position', '$dateStart', '$dateEnd', '$salary', '$employeeId')");
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));

            $historyExists = $conn->query("SELECT COUNT(*) AS COUNT FROM HISTORIAL WHERE ID = $id");
            $historyExists = mysqli_fetch_array($historyExists);

            $userExits = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = $employeeId");
            $userExits = mysqli_fetch_array($userExits);

            if ($historyExists["COUNT"] == 0 || $userExits["COUNT"] == 0) {
                $error = "Información invalida";
            } else {
                $conn->query("UPDATE HISTORIAL SET
                    CARGO = '$position',
                    FECHA_INICIO = '$dateStart',
                    FECHA_TERMINACION = '$dateEnd',
                    SALARIO = '$salary',
                    EMPLEADO_ID = '$employeeId'
                WHERE ID = $id");
                header("Location:" . URL . "historial.php");
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
            $historyExists = $conn->query("SELECT COUNT(*) AS COUNT FROM HISTORIAL WHERE ID = '$id'");
            $historyExists = mysqli_fetch_array($historyExists);

            if ($historyExists["COUNT"] == 0) {
                $error = "El registro no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM HISTORIAL WHERE ID = $id");
                header("Location:" . URL . "historial.php");
            }
        }
    }
}

$result = $conn->query("SELECT HISTORIAL.ID AS ID, CARGO, FECHA_INICIO, FECHA_TERMINACION, SALARIO,
        EMPLEADO.NOMBRE AS NOMBRE, EMPLEADO.APELLIDO_PAT AS APELLIDO_PAT, EMPLEADO.APELLIDO_MAT AS APELLIDO_MAT, EMPLEADO_ID 
    FROM HISTORIAL
    LEFT JOIN EMPLEADO ON HISTORIAL.EMPLEADO_ID = EMPLEADO.ID");

$employees = $conn->query("SELECT ID, NOMBRE, APELLIDO_PAT, APELLIDO_MAT FROM EMPLEADO");

$conn->close();

require "./views/historial.view.php";