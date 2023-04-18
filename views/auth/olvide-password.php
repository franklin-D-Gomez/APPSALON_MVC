<h1 class="nombre-pagina" > Olvide Password</h1>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<p class="descripcion-pagina">Restable su password escribiendo tu email a continuacion</p>


<form method="POST" action="/olvide" class="formulario">

    <div class="campo">
        <label for="email"> E-mail : </label>
        <input type="email" id="email" name="email" placeholder="Tu E-mail" />
    </div>

    <input type = "submit" class="boton" value="enviar instrucciones">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta ? Volver al login</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta? Crear Una</a>
</div>