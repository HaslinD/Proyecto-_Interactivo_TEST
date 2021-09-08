<!DOCTYPE html>

<html>

  <head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="css/style2.css" rel="stylesheet">
    <meta charset="utf-8">
    <title>RedSocial</title>

  </head>

  <body>

    <header>
      <div class="container">

        <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="index.html"><img src="images/Logo_UNITEC.png" alt="Logo Terceto" class="img-fluid" width="10%"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">  

        </ul>

        <ul class="navbar-nav ml-auto lista-redes">
          <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-facebook"></i></a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-twitter"></i></a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-instagram"></i></a>
          </li>
        </ul>
        </div>
      </nav>

      </div>
    </header>

    <section id="Formulario">
      <div class="container">

        <!--<button class="open-button" onclick="openForm()">Open Form</button>-->

        <div id="myForm">
          <form method="post" action="Registro.php" class="form-container" enctype="multipart/form-data">
            <h1>Nuevo Registro</h1>
            <h6>Para registrarse recuerde que debe ser estudiante activo de UNITEC.</h6>
            <label for="nombre"><b>Nombre</b></label>
            <input type="text" placeholder="Ingrese nombre" name="nombre" required>

            <label for="apellido"><b>Apellido</b></label>
            <input type="text" placeholder="Ingrese apellido" name="apellido" required>

            <label for="Email"><b>Numero de Cuenta</b></label>
            <input type="text" placeholder="Ingrese su numero de cuenta" name="cuenta" required>

            <label for="Usuario"><b>Numero de Telefono</b></label>
            <input type="text" placeholder="Ingrese su numero Telefonico" name="numero" required>

            <label for="Email"><b>Correo electrónico</b></label>
            <input type="text" placeholder="Ingrese su Email" name="correo" required>

            <label for="Contraseña"><b>Contraseña</b></label>
            <input type="password" placeholder="Ingrese Contraseña" name="contra" required>

            <button type="submit" name="enviar" value="submit" class="btn">REGISTRARSE</button>

            <?php

              require_once 'login.php';
              $conn = new mysqli($hn, $un, $pw, $db);
              if ($conn->connect_error) die("Error en Conexion");

              if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['cuenta']) && isset($_POST['numero']) && isset($_POST['correo']) && isset($_POST['contra'])) {

                  $Nombre = get_post($conn, 'nombre');
                  $Apellido = get_post($conn, 'apellido');
                  $NumCuenta = get_post($conn, 'cuenta');
                  $NumTelefono = get_post($conn, 'numero');
                  $Correo = get_post($conn, 'correo');
                  $Contraseña = get_post($conn, 'contra');

                  $query = "SELECT nombre, apellido, num_cuenta, num_telefono, correo, contrasenia FROM usuarios WHERE correo = '$Correo'";
                  $result = $conn->query($query);

                  if (!$result) die("Fatal Error");

                  $row = $result->fetch_array(MYSQLI_ASSOC);

                  if ($Correo != $row['correo']) {
                    $query = "INSERT INTO usuarios (nombre, apellido, num_cuenta, num_telefono, correo, contrasenia)
                              VALUES" . "('$Nombre','$Apellido','$NumCuenta','$NumTelefono','$Correo','$Contraseña')";

                    $result = $conn->query($query);
                    if (!$result) echo "INSERT no se ha realizado<br><br>";


                    $nom_dir = "$Nombre"."_"."$Apellido"."_"."$NumCuenta";
                    mkdir("Users/"."$nom_dir", 0700);

                    if (isset($_POST['enviar'])){
                      ?>
                        <script type="text/javascript">
                          window.location = "index.php";
                        </script>
                      <?php
                    }
                  } else if($Correo == $row['correo']) {
                    ?>
                      <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <strong>Error!</strong> El correo electronico que ingreso esta en uso.
                      </div>
                    <?php
                  }
                
              }

              $conn->close();

              function get_post($conn, $var) {
                return $conn->real_escape_string($_POST[$var]);
              }


              ?>
          </form>
        </div>
        

      </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/FileSaver.js"></script>

  </body>

</html>