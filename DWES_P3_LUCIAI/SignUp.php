<?php
// Variables para guardar los valores introducidos
$id = $nombre = $email = $telefono = $pass = $pass2 = $genero = "";

// Variables para los mensajes de error
$idErr = $nombreErr = $emailErr = $telefonoErr = $passErr = $pass2Err = $generoErr = "";

$errores = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Validación del id
      if (!empty(($_POST["id"]))) {
        $id = $_POST["id"];
    } else {
        $idErr = "El id es obligatorio";
        $errores = true;
    }

    // Validación del nombre
    if (!empty(($_POST["nombre"]))) {
        $nombre = $_POST["nombre"];
    } else {
        $nombreErr = "El nombre es obligatorio";
        $errores = true;
    }

      // Validación del email
      if (!empty(($_POST["email"]))) {
        $email = $_POST["email"];
    } else {
        $emailErr = "El email es obligatorio";
        $errores = true;
    }

    // Validación de la contraseña
    if (!empty($_POST["pass"])) {
        $pass = $_POST["pass"];
    } else {
        $passErr = "La contraseña es obligatoria";
        $errores = true;
    }

    // Validación de repetir la contraseña
    if (!empty($_POST["pass2"])) {
        $pass2 = $_POST["pass2"];
        if ($pass !== $pass2) {
            $pass2Err = "Las contraseñas no coinciden";
            $errores = true;
        }
    } else {
        $pass2Err = "Debe repetir la contraseña";
        $errores = true;
    }
    // validacion de genero
    $genero = $_POST["genero"];

    // Mensaje con todos los datos si ha validado el  formulario
    if (!$errores) {
        echo "<p>Te damos la bienvenida, $nombre. Tu contraseña es $pass y tu grupo de edad es $edad.</p>";
}
}
?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registrarse </title>
</head>
<body>
<form method="POST" action="">
    <fieldset>
       
        <legend>SignUp</legend>
        <br>
        <!-- id -->
        <label> Id *: </label>
        <input type="text" name="id" value="" class="<?php echo empty($idErr) ? "" : "err"; ?>"><br>
        <?php if (!empty($idErr)) {
            echo "<label class='error'>$idErr</label>";
        }
        ?>
        <br>
        <!--nombre -->
        <label>Nombre *: </label>
        <input type="text" name="nombre" value="" class="<?php echo empty($nombreErr) ? "" : "err"; ?>"><br>
        <?php if (!empty($nombreErr)) {
            echo "<label class='error'>$nombreErr</label>";
        }
        ?>
        <br>
        <!-- Email --> 
    <label>Email *: </label>
        <input type="email" name="email" value="" class="<?php echo empty($emailErr) ? "" : "err"; ?>"><br>
        <?php if (!empty($emailErr)) {
            echo "<label class='error'>$emailErr</label>";
        }
        ?>
        <br>
        <!-- Telefono -->
        <label>Teléfono *: </label>
        <input type="text" name="telefono" value="" class="<?php echo empty($telefonoErr) ? "" : "err"; ?>"><br>
        <?php if (!empty($telefonoErr)) {
            echo "<label class='error'>$telefonoErr</label>";
        }
        ?>
        <br>

        <!-- Pass -->
    <label>Contraseña: *</label>
        <input type="password" name="pass" 
        class="<?php echo empty($passErr) ? "" : "err"; ?>">
        <?php 
        if (!empty($passErr)) {
            echo "<label class='error'>$passErr</label>";
        } 
        ?>
        <!-- Pass2 -->
        <label>Repite la contraseña: *</label>
        <input type="password" name="pass2" 
        class="<?php echo empty($pass2Err) ? "" : "err"; ?>">
        <?php if (!empty($pass2Err)) {
            echo "<label class='error'>$pass2Err</label>";
        } 
        ?>
        <br>
        <br>
        <!-- Genero -->
         Genero:<br>
        <input type="radio" name="tipo" value="hombre" <?php if (isset($_POST["tipo"]) && $_POST["tipo"] == "hombre") echo "checked"; ?>>Hombre
        <br>
        <input type="radio" name="tipo" value="mujer" <?php if (isset($_POST["tipo"]) && $_POST["tipo"] == "mujer") echo "checked"; ?>>Mujer
        <br>
        <input type="radio" name="tipo" value="otro" <?php if (isset($_POST["tipo"]) && $_POST["tipo"] == "otro") echo "checked"; ?>>Otro
        <br>
        
        
         <br>

       
        
        

        <!-- Falta la fecha -->


        <input type="submit" name="enviar" value="Envíar">
        </fieldset>
</body>
</html>
    
</body>
</html>