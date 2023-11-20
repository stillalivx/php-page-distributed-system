<?php

$sections = [
    "estado" => [
        "filename" => "estado.php",
        "label" => "ESTADO",
        "icon" => "bx-current-location"
    ],
    "municipio" => [
        "filename" => "municipio.php",
        "label" => "MUNICIPIO",
        "icon" => "bx-current-location"
    ],
    "direccion" => [
        "filename" => "direccion.php",
        "label" => "DIRECCION",
        "icon" => "bx-current-location"
    ],
    "departamento" => [
        "filename" => "departamento.php",
        "label" => "DEPARTAMENTO",
        "icon" => "bx-group"
    ],
    "cargo" => [
        "filename" => "cargo.php",
        "label" => "CARGO",
        "icon" => "bx-cog"
    ],
    "asistencia" => [
        "filename" => "asistencia.php",
        "label" => "ASISTENCIA",
        "icon" => "bx-list-check"
    ],
    "historial" => [
        "filename" => "historial.php",
        "label" => "HISTORIAL",
        "icon" => "bx-history"
    ],
    "contacto" => [
        "filename" => "contacto_emerg.php",
        "label" => "CONTACTO",
        "icon" => "bx-phone"
    ],
    "empleado" => [
        "filename" => "empleado.php",
        "label" => "EMPLEADO",
        "icon" => "bx-user"
    ]
];

?>

<div class="mr-5 bg-neutral-800 py-5 px-3 rounded-lg shadow-sm h-min">
    <ul class="space-y-3 text-neutral-300">
        <?php foreach ($sections as $key => $value): ?>
            <li>
                <a href="<?php echo URL . $value["filename"] ?>">
                    <div class="w-full p-2 hover:bg-neutral-700 rounded-lg flex items-center cursor-pointer hover:text-neutral-100">
                        <i class="<?php echo "bx mr-3 " . $value["icon"] ?>"></i>
                        <span class="font-semibold"><?php echo $value["label"] ?></span>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>