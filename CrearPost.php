<?php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Error en Conexion");

  if (isset($_POST['enviar'])){
    $perfil = $_FILES['perfil']['name'];
    $descripcion = $_POST['descripcion'];
    $tag = $_POST['tag'];

    if ($perfil != "" || $descripcion != "") {
        session_start();
        $NombreUsuario = $_SESSION['Nom'];
        $NumeroCuenta = $_SESSION['N_Cuenta'];
        $id = $_SESSION['id'];
        $date = Date('Y-m-d H:i:s.n');

        $query3 = "SELECT count(user_ID) AS count FROM post WHERE user_ID = '$id'";
        $result3 = $conn->query($query3);

        if (!$result3) die("Fatal Error");

        $row2 = $result3->fetch_array(MYSQLI_ASSOC);
        $count = $row2['count'] + 1;

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

        if ($ext) {
          $n  = $count.".".$ext;
          $destdir = 'Users/'.$NumeroCuenta.'/Posts/';
          move_uploaded_file($_FILES['perfil']['tmp_name'], $destdir.$n);

        } else {

        }
        $query2 = "SELECT ID FROM usuarios WHERE num_cuenta = '$NumeroCuenta' ";
        $result2 = $conn->query($query2);

        if (!$result2) die("Fatal Error");

        $row = $result2->fetch_array(MYSQLI_ASSOC);
        $u = $row['ID'];

        $query = "INSERT INTO post (imagen, descripcion, tag, fecha, user_ID)
                  VALUES" . "('$n','$descripcion','$tag','$date', $u)";

        $result = $conn->query($query);
        if (!$result) die("Fatal Error");

        if (isset($_POST['enviar'])){
            ?>
                <script type="text/javascript">
                window.location = "main.html";
                </script>
            <?php
        }
        
        $result->close();
        $result2->close();
        $conn->close();

    } else {
        echo "Error perro";
    }
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
        <section id="CrearPost">
            <div class="container">
              <form method="post" action="CrearPost.php" class="form-container" enctype="multipart/form-data">
                <div class="row">
                    <article class="col-md-8">
                        <label for="Perfil"><b>Subir Imagen</b></label>
                        <div class="imgUp">
                            <div class="imagePreview "></div>
                            <label class="btn btn-primary">
                                Upload<input type="file" name="perfil" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                            </label>
                        </div>
                    </article>
                    <article class="col-md-4">
                        <label for="descripcion"><b>Descripción del post</b></label>
                        <textarea name="descripcion" rows="5" cols="30"></textarea>
                        <label for="Tag"><b>Tag:</b></label>
                        <br>
                        <input type="checkbox" name="tag" value="Blender">
                        <label value="blender">
                            Blender
                        </label>
                        <br><br>
                        <button type="submit" name="enviar" value="submit" class="btn btn-black">Listo</button>
                    </article>
                </div>
              </form>
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
