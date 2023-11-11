<?php
include ("conbd.php")
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Universidad de los Lagos</title>
  <link rel="stylesheet" type="text/css" href="login_css.css">  
</head>
<body>
  <div class="login-form">
    <h2>Universidad de los Lagos</h2>
    <form action="login.php" method="POST">
      <input type="text" name="username" placeholder="Nombre de usuario" required>
      <select name="domain" required>
        <option value="@ulagos.cl">@ulagos.cl</option>
        <option value="@alumnos.ulagos.cl">@alumnos.ulagos.cl</option>
      </select>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Entrar</button>
    </form>
  </div>
  
</body>
</html>