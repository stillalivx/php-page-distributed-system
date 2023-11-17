const URL = "http://rh-master.com";

function updateItem(root, params) {
    window.location.href = `${URL}/${root}.php?${params}`;
}

function deleteItem(root, id) {
    const confirmDel = confirm("¿Deseas eliminar el registro?");

    if (confirmDel) {
        window.location.href = `${URL}/${root}.php?action=delete&id=${id}`;
    }
}