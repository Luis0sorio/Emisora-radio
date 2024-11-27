<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<div class="contenedor">
    <form method='POST' class="form-container">
      <div class="form-group">
        <h2>NUEVA CONTRASEÑA</h2>
        <input type="text" name="usuario" placeholder="Usuario"><br>
        <br>
        <input type="password" name="password" placeholder="Nueva contraseña"><br>
        <br>
        <input type="submit" name="canfirmar" value="Confirmar">
      </div>
      <br>
      <?php foreach ($errores as $error) {
        echo "<div class='errores style='color: crimson;'> $error </div>";
      }
      ?>
    </form>
</div>
</body>
</html>