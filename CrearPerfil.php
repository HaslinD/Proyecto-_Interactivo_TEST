<?php

    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error en Conexion");

    //Recuperacion de la informacion de la tabla perfil en base al ID (ID es un valor de sesion)
    session_start();
    $id = $_SESSION['id'];
    $query3 = "SELECT user_ID FROM perfil WHERE user_ID = '$id'";
    $result3 = $conn->query($query3);

    if (!$result3) die("Fatal Error");

    $row2 = $result3->fetch_array(MYSQLI_ASSOC);
    $u2 = $row2['user_ID'];

    //Verifica si el perfil ya existe en el usuario con el que inicio sesion
    if ($id != $u2) {
      //Cuando el usuario le da click al boton de enviar
      if (isset($_POST['enviar'])){

        //Variables recuperadas de los campos ingresados
        $perfil = $_FILES['perfil']['name'];
        $banner = $_FILES['banner']['name'];
        $nivel = $_POST['estudio'];
        $descripcion = $_POST['descripcion'];
        $campus = $_POST['campus'];
        $carrera = $_POST['carrera'];
        $software = $_POST['software'];

        //Variables de sesion
        $NombreUsuario = $_SESSION['Nom'];
        $NumeroCuenta = $_SESSION['N_Cuenta'];

        //Creacion de la carpeta "Posts"
        mkdir("Users/".$NumeroCuenta."/Posts", 0700);
        //Destino a la carpeta del Usuario
        $destdir = 'Users/'.$NumeroCuenta.'/';

        //Validacion si la imagen es JPG o PNG
        switch ($_FILES['perfil']['type']) {

          case 'image/jpeg':
            $ext = 'jpg';
            break;

          case 'image/png':
            $ext = 'png';
            break;

          default:
            $ext = '';
            break;
        }

        //Agrega la imagen a la carpeta del usuario (perfil)
        if ($ext) {

          $PERFIL  = $NombreUsuario.'_Perfil.'.$ext;
          move_uploaded_file($_FILES['perfil']['tmp_name'], $destdir.$PERFIL);
        }

        //Validacion si la imagen es JPG o PNG
        switch ($_FILES['banner']['type']) {

          case 'image/jpeg':
            $ext = 'jpg';
            break;

          case 'image/png':
            $ext = 'png';
            break;

          default:
            $ext = '';
            break;
        }

        //Agrega la imagen a la carpeta del usuario (banner)
        if ($ext) {

          $BANNER  = $NombreUsuario.'_Banner.'.$ext;
          move_uploaded_file($_FILES['banner']['tmp_name'], $destdir.$BANNER);

        }

        //Validacion en base del numero de cuenta para obtener el ID del usuario (Numero de cuenta es una variable de sesion)
        $query2 = "SELECT ID FROM usuarios WHERE num_cuenta = '$NumeroCuenta' ";
        $result2 = $conn->query($query2);

        if (!$result2) die("Fatal Error");

        $row = $result2->fetch_array(MYSQLI_ASSOC);
        $u = $row['ID'];

        //Inserta a la tabla de perfil
        $query = "INSERT INTO perfil (foto, banner, nivel_estudio, descripcion, campus, carrera, software, user_ID)
                 VALUES" . "('$PERFIL','$BANNER','$nivel','$descripcion','$campus','$carrera','$software', $u)";

        $result = $conn->query($query);
        if (!$result) die("Fatal Error");

        //Cuando se le da click al boton de Registrarse
        if (isset($_POST['enviar'])){
            ?>
                <script type="text/javascript">
                window.location = "main.php";
                </script>
            <?php
        }

        $result->close();
        $result2->close();
        $result3->close();
        $conn->close();

      }
    //Si el usuario ya tiene perfil lo redirige a la pantalla principal
    } else {
        ?>
            <script type="text/javascript">
              window.location = "main.php";
            </script>
        <?php
    }

?>

<!doctype html>
<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link href="css/CrearPerfil.css" rel="stylesheet">
        <meta charset="utf-8">
        <title>RedSocial</title>
    </head>
    <body>

        <header>
            <!--<div class="container">

                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="index.php"><img src="img/Logo.png" alt="Logo Terceto" class="img-fluid" width="20%"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">

                    </ul>

                    <ul class="navbar-nav ml-auto lista-redes">
                        <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                    </div>
                </nav>

            </div>-->
        </header>

        <section id="">
            <div class="card-container">

                <div id="myForm">
                    <form method="post" action="CrearPerfil.php" class="form-container" enctype="multipart/form-data">

                        <label for="Perfil"><b>Perfil</b></label>
                        <div class="imgUp">
                            <div class="imagePreview "></div>
                            <label class="btn btn-primary">
                                Upload<input type="file" name="perfil" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                            </label>
                        </div>
                        <br>

                        <label for="banner"><b>Banner</b></label>
                        <div class="imgUp">
                            <div class="imagePreview "></div>
                            <label class="btn btn-primary">
                                Upload<input type="file" name="banner" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                            </label>
                        </div>
                        <br>

                      <label for="estudio"><b>Nivel de estudio</b></label>
                      <select name="estudio" class="custom-select">
                        <option selected>Seleccione una opci??n</option>
                        <option value="Primer A??o">Primer A??o</option>
                        <option value="Segundo A??o">Segundo A??o</option>
                        <option value="Tercer A??o">Tercer A??o</option>
                        <option value="Cuarto A??o">Cuarto A??o</option>
                        <option value="Graduado">Graduado</option>
                      </select>
                      <br><br>

                      <label for="descripcion"><b>Descripci??n de usted mismo</b></label>
                      <textarea name="descripcion" rows="5" cols="30"></textarea>
                      <br><br>

                      <label for="campus"><b>Campus:</b></label>
                      <select name="campus" class="custom-select">
                        <option selected>Seleccione una opci??n</option>
                        <option value="TGU">TGU</option>
                        <option value="SPS">SPS</option>
                      </select>
                      <br><br>

                      <label for="carrera"><b>Carrera:</b></label>
                      <select name="carrera" class="custom-select">
                        <option selected>Seleccione una opci??n</option>
                        <option value="Animaci??n digital y dise??o interactivo">Animaci??n digital y dise??o interactivo</option>
                      </select>
                      <br><br>

                      <label for="Software"><b>Software:</b></label>
                      <br>
                      <input type="checkbox" name="software" value="Blender">
                        <label value="blender">
                        Blender
                        </label>
                      <br><br>

                      <button type="submit" name="enviar" value="submit" class="btn">REGISTRARSE</button>

                    </form>
                  </div>
            </div>
        </section>

    </body>

    <script>
        $(".imgAdd").click(function(){
            $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
        });
        $(document).on("click", "i.del" , function() {
            $(this).parent().remove();
        });
        $(function() {
            $(document).on("change",".uploadFile", function()
            {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function(){ // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                    }
                }

            });
        });
    </script>

</html>
