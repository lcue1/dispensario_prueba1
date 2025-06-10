<?php
$data = []; // arreglo vacío por defecto

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $coneccion = mysqli_connect("localhost", "root", "", "dispensario");
    if (!$coneccion) {
        die("Error en la conexión " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM usuario";
    $ejecutar = mysqli_query($coneccion, $sql);
    if (!$ejecutar) {
        die("Error en la consulta");
    }

    if (mysqli_num_rows($ejecutar) > 0) {
        while ($fila = mysqli_fetch_assoc($ejecutar)) {
            $data[] = $fila;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <style>
        input[type="text"] {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            width: 100%;
        }

        button {
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #6c63ff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #554de3;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        thead {
            background-color: #6c63ff;
            color: white;
        }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Administrar usuarios</h1>
    <button style="display:block; margin: 1rem auto;">Agregar</button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE USUARIO</th>
                <th>PASSWORD</th>
                <th>EDITAR</th>
                <th>ELIMINAR</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $fila): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila["ID_USUARIO"]); ?></td>
                        <td>
                            <input type="text" value="<?php echo htmlspecialchars($fila["NOMBRE_USUARIO"]); ?>" disabled>
                        </td>
                        <td>
                            <input type="text" value="<?php echo htmlspecialchars($fila["PASS_USUARIO"]); ?>" disabled>
                        </td>
                        <td>
                            <button onclick="actualizar(this)">Editar</button>
                        </td>
                        <td>
                            <button>X</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No hay registros disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function actualizar(btn) {
            // Encuentra la fila donde está el botón
            const fila = btn.closest("tr");
            // Obtiene todos los inputs de esa fila
            const inputs = fila.querySelectorAll("input[type='text']");
            // Habilita todos los inputs
            inputs.forEach(input => input.disabled = false);
            

        }
    </script>

</body>
</html>
