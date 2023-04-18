<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    
    <div class="contenedor-app">
        <!--Para la insertion de la imagen-->
        <div class="imagen"></div>

        <!--Para el contenido-->
        <div class="app">

        <!--La Vista -->
        <?php echo $contenido; ?>

        </div>
    </di>

    <?php 
        echo $script ?? '';
    ?>
            
</body>

</html>