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

    <section id="Formulario">
      <div class="container">

        <!--<button class="open-button" onclick="openForm()">Open Form</button>-->

        <div id="myForm">
          <form method="post" action="CambioContra.php" class="form-container" enctype="multipart/form-data">
            <h1>Cambio de Contraseña</h1>
            <h6>Para Cambiar su contraseña confirme su Numero de Cuenta y Correo</h6>
            <label for="numcuenta"><b>Numero de Cuenta</b></label>
            <input type="text" placeholder="Ingrese Numero de cuenta" name="numcuenta" value="<?php if (isset($_POST['enviar'])){ echo htmlentities($_POST['numcuenta']); } ?>" required>

            <label for="correo"><b>Correo</b></label>
            <input type="text" placeholder="Ingrese su Correo" name="correo" value="<?php if (isset($_POST['enviar'])){ echo htmlentities($_POST['correo']); } ?>" required>

            <label for="Contra1"><b>Nueva Contraseña</b></label>
            <input type="password" placeholder="Ingrese su nueva Contraseña" name="Contra1" value="<?php if (isset($_POST['enviar'])){ echo htmlentities($_POST['Contra1']); } ?>" required>

            <button type="submit" name="enviar" value="submit" class="btn">CONFIRMAR</button>

            <?php
              //metodo para cambiar contraseña
              if (isset($_POST['enviar'])) {
                require_once 'login.php';
                $conn = new mysqli($hn, $un, $pw, $db);
                if ($conn->connect_error) die("Error en Conexion");

                $NCuenta =  $_POST['numcuenta'];
                $Correo =  $_POST['correo'];
                $ContraNueva = $_POST['Contra1'];

                //recuperacion de el usuario a base del numero de cuenta y correo
                $query = "SELECT ID , num_cuenta, correo FROM usuarios WHERE num_cuenta = '$NCuenta' && correo = '$Correo' ";
                $result = $conn->query($query);

                if (!$result) die("Fatal Error");
                $row = $result->fetch_array(MYSQLI_ASSOC);

                //comparacion si valores son los correctos
                if (($NCuenta != "" && $Correo != "") && (($NCuenta == $row['num_cuenta']) && ($Correo == $row['correo']))) {
                  $id = $row['ID'];
                  $query = "UPDATE usuarios SET contrasenia='$ContraNueva' WHERE ID = '$id'";
                  $result = $conn->query($query);
                  if (isset($_POST['enviar'])) {
                    ?>
                      <!-- <script type="text/javascript">
                        window.location = "index.php";
                      </script> -->
                    <?php
                    require 'Success.php';
                  }
                  //Alerta si el campo del numero de cuenta y del correo estan vacios
                } else if($NCuenta == "" || $Correo == "") {
                  ?>
                    <div class="alert">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                      <strong>Error!</strong> Numero de cuenta o Correo no ingresados.
                    </div>
                  <?php
                  //Alerta si el numero de cuenta o el correo no son iguales a los de la base de datos
                } else if(($NCuenta != $row['num_cuenta']) && ($Correo != $row['correo'])) {
                  ?>
                    <div class="alert">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                      <strong>Error!</strong> Numero de Cuenta o contraseña incorrectas.
                    </div>
                  <?php
                }

                $result->close();
                $conn->close();
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
