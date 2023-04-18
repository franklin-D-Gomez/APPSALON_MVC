<?php
    foreach($alertas as $key => $mensajes ): // recorrer el arreglo de error
        foreach($mensajes as $mensaje): // recorre el arreglo de mensaje que estan dentro del arreglo de errores
?>

<!--Muestra las alertas  en el formulario-->
<div class="alerta <?php echo $key; ?>"> <?php echo $mensaje; ?> </div>

<?php
        endforeach;
    endforeach;
?>