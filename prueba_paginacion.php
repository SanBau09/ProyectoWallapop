<?php
// ... (código existente)

// Obtener la página actual desde la URL (o establecerla a 1 por defecto)
$currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

// Definir la cantidad de elementos por página
$itemsPerPage = 5;

// Obtener la lista de anuncios paginada
$anuncios = $anuncioDAO->getPaginatedAnuncios($currentPage, $itemsPerPage);
$anuncios = $anuncioDAO->getAnunPag($pagActual, $anunciosPagina);

// ... (código existente)
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ... (head existente) -->
</head>
<body>
    <!-- ... (código existente) -->

    <main class="contenedor">
        <!-- ... (código existente) -->
        <div class="listado-anuncios">
            <?php foreach ($anuncios as $anuncio): ?>
                <!-- ... (contenido del anuncio) -->
            <?php endforeach; ?>
        </div>

        <!-- Mostrar enlaces de paginación -->
        <?php if ($anuncioDAO->hasMorePages($currentPage, $itemsPerPage)): ?>
            <a href="?page=<?= $currentPage + 1 ?>">Página siguiente</a>
        <?php endif; ?>
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>">Página anterior</a>
        <?php endif; ?>
    </main>

    <!-- ... (código existente) -->
</body>
</html>