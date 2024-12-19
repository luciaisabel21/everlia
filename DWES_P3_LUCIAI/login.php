<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>
<body>
    <fieldset> 
        <legend> Iniciar Sesion </legend>
     <!-- Email --> 
     <label>Email *: </label>
        <input type="email" name="email" value="" class="<?php echo empty($emailErr) ? "" : "err"; ?>"><br>
        <?php if (!empty($emailErr)) {
            echo "<label class='error'>$emailErr</label>";
        }
        ?>
        <br>
    <label>Contraseña: *</label>
        <input type="password" name="pass" 
        class="<?php echo empty($passErr) ? "" : "err"; ?>">
        <?php 
        if (!empty($passErr)) {
            echo "<label class='error'>$passErr</label>";
        } 
        ?>
        </fieldset>
</body>
</html>