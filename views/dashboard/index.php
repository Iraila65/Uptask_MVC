<?php include_once __DIR__."/header.php"; ?>  

    <?php if (count($proyectos) == 0) { ?>
        <div class="no-proyectos">
            <p>No hay proyectos</p>
            <a class="enlace-no-proyectos" href="/crear-proyecto">Comienza creando uno</a>
        </div>
        
        
    <?php } else { ?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto) { ?>
                <li class="proyecto">
                    <a href="/proyecto?url=<?php echo $proyecto->url ?>" > 
                        <?php echo $proyecto->proyecto ?> 
                    </a>
                </li>
            <?php }  ?>
        </ul>

    <?php }  ?>



<?php include_once __DIR__."/footer.php"; ?> 