<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Asistencia | Recursos Humanos</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            * {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="bg-neutral-900">
        <div class="grid grid-rows-[auto_1fr] my-5">
            <header class="grid grid-cols-[15%_1fr]">
                <div></div>
                <h1 class="text-4xl font-medium text-slate-200 ml-5">Asistencia</h1>
            </header>

            <div class="m-5 grid grid-cols-[15%_1fr]">
                <?php require "./common/views/menu.view.php" ?>

                <main>
                    <section class="w-full bg-neutral-800 p-5 rounded-lg shadow-sm w-2/5">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="grid grid-cols-[1fr_auto] items-center mb-0">
                            <div class="mr-10 space-y-5">
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="status" class="text-xs mb-2 text-neutral-400">Estado</label>
                                    <select required name="status" id="status" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                        <option value="FALTA" <?php echo isset($_GET["status"]) && $_GET["status"] == "FALTA" ? "selected" : "" ?>>Falta</option>
                                        <option value="ASISTENCIA" <?php echo isset($_GET["status"]) && $_GET["status"] == "ASISTENCIA" ? "selected" : "" ?>>Asistencia</option>
                                    </select>
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="datetime" class="text-xs mb-2 text-neutral-400">Día</label>
                                    <input required type="datetime-local" name="datetime" id="datetime" value="<?php echo isset($_GET["datetime"]) ? $_GET["datetime"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <?php if (isset($employees)): ?>
                                    <div class="grid grid-rows-[auto_auto]">
                                        <label for="employeeId" class="text-xs mb-2 text-neutral-400">Empleado</label>
                                        <select required name="employeeId" id="employeeId" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                            <?php foreach ($employees as $key => $value): ?>
                                                <option value="<?php echo $value["ID"] ?>" <?php echo isset($_GET["employeeId"]) && $value["ID"] == (int)$_GET["employeeId"] ? 'selected' : '' ?>><?php echo $value["NOMBRE"] . " " . $value["APELLIDO_PAT"] . " " . $value["APELLIDO_MAT"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="hidden">
                                    <label for="id"></label>
                                    <input type="text" name="id" id="id" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : "" ?>" />
                                </div>
                                <div class="hidden">
                                    <label for="action"></label>
                                    <input type="text" name="action" id="action" value="<?php echo isset($_GET["action"]) ? $_GET["action"] : "create" ?>" />
                                </div>
                            </div>
                            <button id="submit" class="rounded-lg bg-blue-600 hover:bg-blue-500 active:bg-blue-700 shadow-md active:shadow-none w-10 h-10 flex justify-center items-center outline-none">
                                <?php if (!isset($_GET["action"])): ?>
                                    <i class="bx bx-plus text-2xl text-neutral-100"></i>
                                <?php else: ?>
                                    <i class="bx bx-save text-2xl text-neutral-100"></i>
                                <?php endif; ?>
                            </button>
                        </form>
                        <?php if (isset($error)): ?>
                            <div class="mt-5 text-red-300 font-bold">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                    </section>

                    <section class="w-full bg-neutral-800 p-5 rounded-lg shadow-sm mt-5">
                        <?php if (!isset($result) || $result->num_rows == 0): ?>
                            <div class="py-5 text-center text-neutral-500">No hay datos registrados</div>
                        <?php else: ?>
                            <div class="py-5">
                                <table class="w-full">
                                    <thead>
                                    <tr class="text-neutral-400">
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">ID</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Nombre</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Estado</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Fecha</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($result as $key => $value): ?>
                                        <tr class="text-white">
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["ID"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["NOMBRE"] . " " . $value["APELLIDO_PAT"] . " " . $value["APELLIDO_MAT"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["ESTADO"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["FECHA"] ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3">
                                                <div class="flex text-xl justify-center">
                                                    <button class="mr-5" onclick="updateItem('asistencia', '<?php echo "action=update&id={$value["ID"]}&status={$value["ESTADO"]}&datetime={$value["FECHA"]}&employeeId={$value["EMPLEADO_ID"]}"; ?>')">
                                                        <i class="bx bx-edit-alt text-amber-300"></i>
                                                    </button>
                                                    <button onclick="deleteItem('asistencia', <?php echo $value["ID"]; ?>)">
                                                        <i class="bx bx-trash text-red-500"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </section>
                </main>
            </div>
        </div>
        <script src="../public/utils.js"></script>
    </body>
</html>
