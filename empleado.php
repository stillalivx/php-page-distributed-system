<?php

require_once "./common/utils.php";

$conn = conn_database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = strtolower(htmlspecialchars(trim($_POST["action"])));

    if (empty($action)) {
        header("Location:" . URL . "empleado.php");
    }

    $name = strtoupper(htmlspecialchars(trim($_POST["name"])));
    $paternalSurname = strtoupper(htmlspecialchars(trim($_POST["paternalSurname"])));
    $maternalSurname = strtoupper(htmlspecialchars(trim($_POST["maternalSurname"])));
    $gender = strtoupper(htmlspecialchars(trim($_POST["gender"])));
    $birthdate = strtoupper(htmlspecialchars(trim($_POST["birthdate"])));
    $addressId = strtoupper(htmlspecialchars(trim($_POST["addressId"])));
    $departmentId = strtoupper(htmlspecialchars(trim($_POST["departmentId"])));
    $positionId = strtoupper(htmlspecialchars(trim($_POST["positionId"])));
    $email = strtoupper(htmlspecialchars(trim($_POST["email"])));
    $supervisorId = strtoupper(htmlspecialchars(trim($_POST["supervisorId"])));
    $user = strtoupper(htmlspecialchars(trim($_POST["user"])));
    $password = strtoupper(htmlspecialchars(trim($_POST["password"])));

    $supervisorId = $supervisorId == "0" ? NULL : $supervisorId;

    switch ($action) {
        case "create":
            if (
                empty($name) || empty($paternalSurname) || empty($maternalSurname) || empty($birthdate) || empty($addressId) ||
                empty($departmentId) || empty($positionId) || empty($user) || empty($password)
            ) {
                $error = "Los datos del nuevo empleado están incompletos";
            } else {
                $departmentExists = $conn->query("SELECT COUNT(*) AS COUNT FROM DEPARTAMENTO WHERE ID = '$departmentId'");
                $departmentExists = mysqli_fetch_array($departmentExists);

                $addressExists = $conn->query("SELECT COUNT(*) AS COUNT FROM DIRECCION WHERE ID = '$addressId'");
                $addressExists = mysqli_fetch_array($addressExists);

                $positionExists = $conn->query("SELECT COUNT(*) AS COUNT FROM CARGO WHERE  ID = '$positionId'");
                $positionExists = mysqli_fetch_array($positionExists);

                if ($supervisorId != "0") {
                    $supervisorExists = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = '$supervisorId'");
                    $supervisorExists = mysqli_fetch_array($supervisorExists);
                } else {
                    $supervisorExists["COUNT"] = 1;
                }

                if ($departmentExists["COUNT"] == 0 || $addressExists["COUNT"] == 0 || $positionExists["COUNT"] == 0) {
                    $error = "Los datos son inválidos.";
                } else {
                    if ($supervisorId != "0") {
                        $userExists = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = '$supervisorId'");
                        $userExists = mysqli_fetch_array($userExists);

                        if ($userExists["COUNT"] == "0") {
                            $supervisorId = "NULL";
                        } else {
                            $supervisorId = "'$supervisorId'";
                        }
                    }

                    $userExists = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE USERNAME = '$user'");
                    $userExists = mysqli_fetch_array($userExists);

                    if ($userExists["COUNT"] != 0) {
                        $error = "El nombre de usuario ya existe";
                    } else {
                        $conn->query("INSERT INTO EMPLEADO (NOMBRE, APELLIDO_PAT, APELLIDO_MAT, GENERO, FECHA_NACIMIENTO, DIRECCION_ID, DEPARTAMENTO_ID, CARGO_ID, CORREO, SUPERVISOR_ID, USERNAME, PASSWORD)
                            VALUES ('$name', '$paternalSurname', '$maternalSurname', '$gender', '$birthdate', '$addressId', '$departmentId', '$positionId', '$email', $supervisorId, '$user', '$password')");
                    }
                }
            }

            break;

        case "update":
            $id = htmlspecialchars(trim($_POST["id"]));

            if ($supervisorId == "0" || empty($supervisorId)) {
                $supervisorId = "NULL";
            } else {
                $supervisorId = "'$supervisorId'";
            }

            echo $supervisorId;

            $query = "UPDATE EMPLEADO SET 
                 NOMBRE = '$name',
                 APELLIDO_PAT = '$paternalSurname',
                 APELLIDO_MAT = '$maternalSurname',
                 FECHA_NACIMIENTO = '$birthdate',
                 DIRECCION_ID = '$addressId',
                 DEPARTAMENTO_ID = '$departmentId',
                 CARGO_ID = '$positionId',
                 CORREO = '$email',
                 SUPERVISOR_ID = $supervisorId,
                 USERNAME = '$user'
            ";

            if (!empty($password)) {
                $query = $query . ", PASSWORD = '$password'";
            }

            $query = $query . " WHERE ID = $id";

            $conn->query($query);
            header("Location:" . URL . "empleado.php");

            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["action"])) {
    $action = strtolower(htmlspecialchars(trim($_GET["action"])));

    if ($action === "delete") {
        $id = htmlspecialchars(trim($_GET["id"]));

        if (empty($id)) {
            $error = "Es necesario incluir el id del registro que se desea eliminar";
        } else {
            $employeeExists = $conn->query("SELECT COUNT(*) AS COUNT FROM EMPLEADO WHERE ID = '$id'");
            $employeeExists = mysqli_fetch_array($employeeExists);

            if ($employeeExists["COUNT"] === 0) {
                $error = "El empleado no existe en la base de datos.";
            } else {
                $conn->query("DELETE FROM EMPLEADO WHERE ID = $id");
                header("Location:" . URL . "empleado.php");
            }
        }
    }
}

$result = $conn->query(
    "SELECT EMPLEADO.ID, EMPLEADO.NOMBRE, APELLIDO_PAT, APELLIDO_MAT, CORREO, CARGO.NOMBRE AS CARGO,
       CARGO.ID AS CARGO_ID, DEPARTAMENTO.ID AS DEPARTAMENTO_ID, DEPARTAMENTO.NOMBRE AS DEPARTAMENTO, GENERO,
       DIRECCION.ID AS DIRECCION_ID, SUPERVISOR_ID, USERNAME, FECHA_NACIMIENTO
       FROM EMPLEADO
       LEFT JOIN CARGO ON EMPLEADO.CARGO_ID = CARGO.ID
       LEFT JOIN DEPARTAMENTO ON EMPLEADO.DEPARTAMENTO_ID = DEPARTAMENTO.ID
       LEFT JOIN DIRECCION ON EMPLEADO.DIRECCION_ID = DIRECCION.ID"
);

$address = $conn->query(
    "SELECT DIRECCION.ID AS ID, CALLE, MUNICIPIO.NOMBRE AS MUNICIPIO, ESTADO.NOMBRE AS ESTADO FROM DIRECCION
    LEFT JOIN MUNICIPIO ON DIRECCION.MUNICIPIO_ID = MUNICIPIO.ID
    LEFT JOIN ESTADO ON DIRECCION.ESTADO_ID = ESTADO.ID"
);
$positions = $conn->query("SELECT ID, NOMBRE FROM CARGO");
$departments = $conn->query("SELECT ID, NOMBRE FROM DEPARTAMENTO");
$employees = $conn->query("SELECT ID, NOMBRE, APELLIDO_PAT, APELLIDO_MAT FROM EMPLEADO");

$conn->close();

require "./views/empleado.view.php";