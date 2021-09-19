<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>RedSocial</title>
  </head>

  <body>

    <div class="content">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-md-6">
            <img src="images/Login-Arte.png" alt="Image" class="img-fluid" width="80%">
          </div>
          <div class="col-md-6 contents">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <img src="images/Logo_UNITEC.png" alt="Image" class="img-fluid" width="50%">
                <div class="mb-4">
                <h3>Iniciar sesión</h3>
                <p class="mb-4">Ingrese sus datos para continuar.</p>
              </div>
              <form action="index.php" method="post">
                <div class="form-group first">
                  <label for="username">Correo</label>
                  <input type="text" class="form-control" id="username" name="user">

                </div>
                <div class="form-group last mb-4">
                  <label for="password">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="pass">

                </div>

                <div class="d-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-0"><span class="caption">Recuerdame</span>
                    <input type="checkbox" checked="checked"/>
                    <div class="control__indicator"></div>
                  </label>
                  <span class="ml-auto"><a href="CambioContra.php" class="forgot-pass">Olvide mi contraseña</a></span>
                </div>

                <button type="submit" name="enviar" value="submit" class="btn btn-block btn-primary">CONTINUAR</button>

                <?php
                if (isset($_POST['enviar'])) {
                  require_once 'login.php';
                  $conn = new mysqli($hn, $un, $pw, $db);
                  if ($conn->connect_error) die("Error en Conexion");

                  $usuario =  $_POST['user'];
                  $contraseña =  $_POST['pass'];

                  $query = "SELECT ID, nombre, apellido, num_cuenta, num_telefono, correo, contrasenia FROM usuarios WHERE correo = '$usuario' && contrasenia = '$contraseña' ";
                  $result = $conn->query($query);

                  if (!$result) die("Fatal Error");

                  $row = $result->fetch_array(MYSQLI_ASSOC);

                  if (($usuario != "" && $contraseña != "") && (($usuario == $row['correo']) && ($contraseña == $row['contrasenia']))) {

                    session_start();
                    $_SESSION['id'] = $row['ID'];
                    $_SESSION['Nom'] = $row['nombre'];
                    $_SESSION['Apel'] = $row['apellido'];
                    $_SESSION['N_Cuenta'] = $row['num_cuenta'];
                    $_SESSION['N_Tel'] = $row['num_telefono'];
                    $_SESSION['Correo'] = $row['correo'];
                    $_SESSION['Contra'] = $row['contrasenia'];

                    if (isset($_POST['enviar'])){
                      ?>
                        <script type="text/javascript">
                          window.location = "CrearPerfil.php";
                        </script>
                      <?php
                    }

                  } else if($usuario == "" || $contraseña == "") {
                    ?>
                      <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Error!</strong> Correo o contraseña no ingresada.
                      </div>
                    <?php
                  } else if(($usuario != $row['correo']) && ($contraseña != $row['contrasenia'])) {
                    ?>
                      <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Error!</strong> Correo o contraseña incorrecta.
                      </div>
                    <?php
                  } else {

                  }

                  $result->close();
                  $conn->close();
                }
                ?>

                <div class="d-flex mb-5 align-items-center">
                  <span class="ml-left"><a href="Registro.php" class="forgot-pass">Crear una cuenta</a></span>
                  <span class="ml-auto" ><a href="Registro.php" class="forgot-pass">Ingresar como invitado</a></span>
                </div>

                </form>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>


    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>

</html>
