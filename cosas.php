//index.com
<main class="contenedor">
        <h1>Lo mejor, al mejor precio</h1>
        <?php 
        imprimirMensaje();
        ?>
        <?php foreach ($anuncios as $anuncio): ?>
            <div class="">
            <h4 class="titulo">
                <a href="ver_anuncio.php?id=<?=$anuncio->getId()?>"><?= $anuncio->getTitulo() ?></a>
                </h4>
                <?php if(isset($_SESSION['email']) && $_SESSION['id']==$anuncio->getIdUsuario()): ?>
                    <span class="icono_borrar"><a href="borrar_anuncio.php?id=<?=$anuncio->getId()?>"><i class="fa-solid fa-trash color_gris"></i></a></span>
                    <span class="icono_editar"><a href="editar_anuncio.php?id=<?=$anuncio->getId()?>"><i class="fa-solid fa-pen-to-square color_gris"></i></a></span>
                <?php endif; ?>
            <p class="texto"><?= $anuncio->getDescripcion() ?></p>
            </div>
        <?php endforeach; ?>
       <?php if(isset($_SESSION['email'])): ?>
            <a href="insertar_anuncio.php" class="nuevoAnuncio">Nuevo anuncio</a>
        <?php endif; ?>  

    </main>        
    <script>
        setTimeout(function(){document.getElementById('mensajeError').style.display='none'},5000);
    </script>



//insertar_anuncio

<body>
    <?= $error ?>
    <form action="insertar_anuncio.php" method="post">
        <input type="text" name="titulo" placeholder="Titulo"><br>
        <input type="number" name="precio" placeholder="Precio"><br>
        <textarea class="editor" name="descripcion" placeholder="descripcion"></textarea><br>
        <!--<select name="idUsuario">
            <?php foreach($usuarios as $usuario): ?>
                <option value="<?= $usuario->getId() ?>"><?= $usuario->getEmail() ?></option>
            <?php endforeach; ?>
        </select><br>-->
        <input type="submit">
    </form>
    <script>
        $(".editor").jqte();
    </script>
</body>