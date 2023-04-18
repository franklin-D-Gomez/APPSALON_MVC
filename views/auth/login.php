<h1 class="nombre-pagina">login</h1>

<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form method="POST" action="/" class="formulario">
    <div class="campo">
        <label for="email">Email : </label>
        <input
        type= "email"
        id="emial"
        placeholder="Tu Email"
        name="email"
        />
    </div>

    <div class="campo">
        <label for="password">Password : </label>
        <input
        type="password"
        id="password"
        placeholder="Tu Password"
        name="password"
        />
    </div>

    <input type="submit" class="boton" value = "iniciar sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Aun no tienes una cuenta? Crear Una</a>
    <a href="/olvide">Olvidastes tu password? Reestablecer</a>
</div>