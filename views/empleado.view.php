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
                <h1 class="text-4xl font-medium text-slate-200 ml-5">Empleado</h1>
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
                                    <label for="gender" class="text-xs mb-2 text-neutral-400">Género</label>
                                    <select required name="gender" id="gender" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                        <option value="1" <?php echo isset($_GET["gender"]) && "1" == $_GET["gender"] ? 'selected' : '' ?>>Masculino</option>                                        <option value="0" <?php echo isset($_GET["gender"]) && "0" == $_GET["gender"] ? 'selected' : '' ?>>Masculino</option>
                                        <option value="2" <?php echo isset($_GET["gender"]) && "2" == $_GET["gender"] ? 'selected' : '' ?>>Femenino</option>
                                    </select>
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="birthdate" class="text-xs mb-2 text-neutral-400">Fecha de nacimiento</label>
                                    <input required type="date" name="birthdate" id="birthdate" placeholder="Fecha de nacimiento" value="<?php echo isset($_GET["birthdate"]) ? $_GET["birthdate"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="email" class="text-xs mb-2 text-neutral-400">Correo</label>
                                    <input required type="email" name="email" id="email" placeholder="Correo electrónico" value="<?php echo isset($_GET["email"]) ? $_GET["email"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <?php if (isset($address)): ?>
                                    <div class="grid grid-rows-[auto_auto]">
                                        <label for="addressId" class="text-xs mb-2 text-neutral-400">Dirección</label>
                                        <select required name="addressId" id="addressId" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                            <?php foreach ($address as $key => $value): ?>
                                                <option value="<?php echo $value["ID"] ?>" <?php echo isset($_GET["addressId"]) && $value["ID"] == $_GET["addressId"] ? 'selected' : '' ?>>
                                                    <?php echo $value["CALLE"] . ". " . $value["MUNICIPIO"] . ". " . $value["ESTADO"]; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($positions)): ?>
                                    <div class="grid grid-rows-[auto_auto]">
                                        <label for="positionId" class="text-xs mb-2 text-neutral-400">Cargo</label>
                                        <select required name="positionId" id="positionId" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                            <?php foreach ($positions as $key => $value): ?>
                                                <option value="<?php echo $value["ID"] ?>" <?php echo isset($_GET["positionId"]) && $value["ID"] == (int)$_GET["positionId"] ? 'selected' : '' ?>><?php echo $value["NOMBRE"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($departments)): ?>
                                    <div class="grid grid-rows-[auto_auto]">
                                        <label for="departmentId" class="text-xs mb-2 text-neutral-400">Departamento</label>
                                        <select required name="departmentId" id="departmentId" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                            <?php foreach ($departments as $key => $value): ?>
                                                <option value="<?php echo $value["ID"] ?>" <?php echo isset($_GET["departmentId"]) && $value["ID"] == (int)$_GET["departmentId"] ? 'selected' : '' ?>><?php echo $value["NOMBRE"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($employees)): ?>
                                    <div class="grid grid-rows-[auto_auto]">
                                        <label for="supervisorId" class="text-xs mb-2 text-neutral-400">Supervisor</label>
                                        <select required name="supervisorId" id="supervisorId" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400">
                                            <option value="0" <?php echo !isset($_GET["supervisorId"]) ? 'selected' : '' ?>>SIN SUPERVISOR</option>
                                            <?php foreach ($employees as $key => $value): ?>
                                                <option value="<?php echo $value["ID"] ?>" <?php echo isset($_GET["supervisorId"]) && $value["ID"] == (int)$_GET["supervisorId"] ? 'selected' : '' ?>><?php echo $value["NOMBRE"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="user" class="text-xs mb-2 text-neutral-400">Username</label>
                                    <input type="text" name="user" id="user" placeholder="Username" value="<?php echo isset($_GET["user"]) ? $_GET["user"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
                                <div class="grid grid-rows-[auto_auto]">
                                    <label for="password" class="text-xs mb-2 text-neutral-400">Contraseña</label>
                                    <input type="password" name="password" id="password" placeholder="Contraseña" value="<?php echo isset($_GET["password"]) ? $_GET["password"] : "" ?>" class="outline-none bg-neutral-800 border-solid border-b-2 py-1 border-neutral-700 text-neutral-50 focus:border-blue-400" />
                                </div>
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
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Corre</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Cargo</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left">Departamento</th>
                                        <th class="border border-solid border-neutral-500 py-2.5 px-3 text-left"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($result as $key => $value): ?>
                                        <tr class="text-white">
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["ID"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["NOMBRE"] . $value["APELLIDO_PAT"] . $value["APELLIDO_MAT"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["CORREO"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["CARGO"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3"><?php echo $value["DEPARTAMENTO"]; ?></td>
                                            <td class="border border-solid border-neutral-500 py-2.5 px-3">
                                                <div class="flex text-xl justify-center">
                                                    <button class="mr-5" onclick="updateItem('empleado', '<?php echo "action=update&id={$value["ID"]}&name={$value["NOMBRE"]}&paternalSurname={$value["APELLIDO_PAT"]}&maternalSurname={$value["APELLIDO_MAT"]}&gender={$value["GENERO"]}&birthdate={$value["FECHA_NACIMIENTO"]}&addressId={$value["DIRECCION_ID"]}&departmentId={$value["DEPARTAMENTO_ID"]}&positionId={$value["CARGO_ID"]}&email={$value["CORREO"]}&supervisorId={$value["SUPERVISOR_ID"]}&user={$value["USERNAME"]}" ?>')">
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