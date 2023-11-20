<?php

// ... (código existente)

class AnunciosDAO {
    // ... (código existente)

    /**
     * Obtiene una lista paginada de anuncios
     */
    public function getPaginatedAnuncios($page, $itemsPerPage): array {
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM Anuncios ORDER BY fecha_creacion DESC LIMIT ?, ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $stmt->bind_param('ii', $offset, $itemsPerPage);
        $stmt->execute();

        $result = $stmt->get_result();

        $array_anuncios = array();

        while ($anuncio = $result->fetch_object(Anuncio::class)) {
            $array_anuncios[] = $anuncio;
        }

        return $array_anuncios;
    }

    /**
     * Verifica si hay más páginas disponibles
     */
    public function hasMorePages($currentPage, $itemsPerPage): bool {
        $offset = ($currentPage - 1) * $itemsPerPage;

        $sql = "SELECT COUNT(id) as total FROM Anuncios";
        $result = $this->conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            $totalItems = $row['total'];
            return $totalItems > ($offset + $itemsPerPage);
        }

        return false;
    }

    // ... (código existente)
}
?>
