<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Empleado | Recursos Humanos</title>

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
                <h1 class="text-4xl font-medium text-slate-200 ml-5">Contacto de emergencia</h1>
            </header>

            <div class="m-5 grid grid-cols-[15%_1fr]">
                <?php require "./common/views/menu.view.php" ?>

                <main>
                    <section class="w-full bg-neutral-800 p-5 rounded-lg shadow-sm w-2/5">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="grid grid-cols-[1fr_auto] items-center mb-0">
                            <div class="mr-10 space-y-5">
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="name" class="text-xs mb-2 text-neutral-400">Nombre</label>
                                    <input required type="text" name="name" id="name" placeholder="Nombre del empleado" value="<?php echo isset($_GET["name"]) ? $_GET["name"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="paternalSurname" class="text-xs mb-2 text-neutral-400">Apellido paterno</label>
                                    <input type="text" name="paternalSurname" id="paternalSurname" placeholder="Apellido paterno" value="<?php echo isset($_GET["paternalSurname"]) ? $_GET["paternalSurname"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="maternalSurname" class="text-xs mb-2 text-neutral-400">Apellido materno</label>
                                    <input type="text" name="maternalSurname" id="maternalSurname" placeholder="Apellido materno" value="<?php echo isset($_GET["maternalSurname"]) ? $_GET["maternalSurname"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="parentesco" class="text-xs mb-2 text-neutral-400">Parentesco</label>
                                    <select required name="parentesco" id="parentesco" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                        <option value="PADRE" <?php echo isset($_GET["parentesco"]) && "PADRE" == $_GET["parentesco"] ? 'selected' : '' ?>>PADRE</option>                                        <option value="0" <?php echo isset($_GET["gender"]) && "0" == $_GET["gender"] ? 'selected' : '' ?>>Masculino</option>
                                        <option value="MADRE" <?php echo isset($_GET["parentesco"]) && "MADRE" == $_GET["parentesco"] ? 'selected' : '' ?>>MADRE</option>
                                        <option value="HIJO(A)" <?php echo isset($_GET["parentesco"]) && "HIJO(A)" == $_GET["parentesco"] ? 'selected' : '' ?>>HIJO(A)</option>
                                        <option value="TIO(A)" <?php echo isset($_GET["parentesco"]) && "TIO(A)" == $_GET["parentesco"] ? 'selected' : '' ?>>TIO(A)</option>
                                    </select>
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="email" class="text-xs mb-2 text-neutral-400">Correo</label>
                                    <input required type="email" name="email" id="email" placeholder="Correo electrónico" value="<?php echo isset($_GET["email"]) ? $_GET["email"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="phone" class="text-xs mb-2 text-neutral-400">Telefono</label>
                                    <input required type="tel" name="phone" id="phone" placeholder="Telefono" value="<?php echo isset($_GET["phone"]) ? $_GET["phone"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
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
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Parentesco</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Empleado</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Telefono</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($result as $key => $value): ?>
                                        <tr class="text-white">
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["ID"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["NOMBRE"] . " " . $value["APELLIDO_PAT"] . " " . $value["APELLIDO_MAT"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["PARENTESCO"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["EMPLEADO_NOMBRE"] . " " . $value["EMPLEADO_APELLIDO_PAT"] . " " . $value["EMPLEADO_APELLIDO_MAT"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["TELEFONO"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3">
                                                <div class="flex text-xl justify-center">
                                                    <button class="mr-5" onclick="updateItem('contacto_emerg', '<?php echo "action=update&id={$value["ID"]}&name={$value["NOMBRE"]}&paternalSurname={$value["APELLIDO_PAT"]}&maternalSurname={$value["APELLIDO_MAT"]}&parentesco={$value["PARENTESCO"]}&employeeId={$value["EMPLEADO_ID"]}&phone={$value["TELEFONO"]}&email={$value["CORREO"]}" ?>')">
                                                        <i class="bx bx-edit-alt text-amber-300"></i>
                                                    </button>
                                                    <button onclick="deleteItem('empleado', <?php echo $value["ID"]; ?>)">
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