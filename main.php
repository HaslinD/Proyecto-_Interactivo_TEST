<?php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Error en Conexion");

  //Recuperacion de los valores de sesion
  session_start();
  $id = $_SESSION['id'];
  $NumeroCuenta = $_SESSION['N_Cuenta'];
  $Nombre = $_SESSION['Nom'];
  $Apellido = $_SESSION['Apel'];

  //Validacion de la tabla perfil en base al ID del usuario
  $queryS = "SELECT foto, user_ID FROM perfil WHERE user_ID = '$id'";
  $resultS = $conn->query($queryS);

  if (!$resultS) die("Fatal Error");
  $rowS = $resultS->fetch_array(MYSQLI_ASSOC);

  //Recuperacion de las variables de foto y el ID
  $fotoU = $rowS['foto'];
  $uID = $rowS['user_ID'];

  //Link de busqueda a la foto de perfil del usuario
  $fileSRC = "Users/".$NumeroCuenta."/".$fotoU;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="css/styles_main.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <title>AnimationStudents</title>
</head>
<body>
    <div id="contenedor">
        <div id="columnaizquierda">
            <div id="menuizquierda">
                <div id="menuizquni">
                    <a href="main.php"><img src="images/Logo_UNITEC.png" class="logoMain"></a>
                </div>
                <div id="menuizqperfil">
                    <img src="<?php echo $fileSRC;?>" class="imgUsuario"> <i class="fas fa-pen"></i><br>
                    <h1 class="nombre"><?php echo $Nombre." ".$Apellido;?></h1>
                </div>
                <div id="menuizqopciones">
                    <a href="perfil.php" class="botonizq">VER PERFIL</a><br>
                    <a class="botonizq" href="CrearPost.php" id="publicacionBTN"><i class="fas fa-plus"></i>NUEVA PUBLICACIÓN</a>
                </div>
            </div>

            <a href="#" onclick="botonSalir()"><i class="fas fa-sign-out-alt"></i></a>
        </div>
        <!--Pop up de botonSalir -->
        <div id="ventanaSalir" class="modal" style="display: none;">
            <div class="contenidoSalir">
                <h4>¿Estás seguro que quieres cerrar sesión?</h4>
                <div class="opcionesSalir">
                    <a href="index.php" class="botonSi">SI</a><a onclick="botonSalir()" href="#" class="botonNo">NO</a>
                </div>
            </div>
        </div>

        <!--Pop UP Publicacion-->

        <div id="myModal" class="modal">
            <div id="ventanaPublicar">
                <div class="content">
                    <div class="container">
                        <div class="borde">
                            <h1>Nueva Publicación</h1>
                        </div>
                        <div class="agregarArchivo borde">


                                    <img class="imgPublicar" src="images/ejemplo1.png" alt="placeholder">


                                    <img class="imgPublicar" src="images/ejemplo2.png" alt="placeholder">

                                <button class="seleccionarArchivo">
                                    <i class="fas fa-plus-circle"></i>
                                </button>

                        </div>
                        <div class="borde descripcionInput">
                            <input type="text" name="Descripción" placeholder="Descripción..."> <p><i class="fas fa-laugh"></i></p>
                        </div>
                        <div class="publicarCancelar">
                            <input href="#" type="submit" value="Cancelar" class="btn-red cerrar">
                            <input href="#" type="submit" value="Publicar" class="btn-blue">
                        </div>
                    </div>
                </div>
             </div>
        </div>


        <div id="columnacentral">
            <div id="espacioseguro">
                <a class="todos">Todos</a> <a class="siguiendo">Siguiendo</a>
            </div>
                <span class="tabMenu">
                    <span class="todosTab">

                        <?php
                            //Control del Contador de Filas en la tabla del la Base de DATOS
                            $queryC = "SELECT imagen,descripcion,tag,user_ID FROM post";
                            $resultC = $conn->query($queryC);
                            if (!$resultC) die("Fatal Error");

                            $count = $resultC->num_rows;
                            for ($i = 0; $i < $count; $i++) {
                              //Control del FOR Loop
                              $row = $resultC->fetch_array(MYSQLI_ASSOC);
                              $uD = $row['user_ID'];

                              //Agarrar Imagen de Tabla perfil
                              $query3 = "SELECT foto FROM perfil WHERE user_ID = '$uD'";
                              $result3 = $conn->query($query3);
                              if (!$result3) die("Fatal Error");
                              $rowF = $result3->fetch_array(MYSQLI_ASSOC);
                              $fotoU = $rowF['foto'];

                              //Agarrar nombre apellido y numero de cuenta de tabla de usuarios
                              $query2 = "SELECT nombre, apellido, num_cuenta FROM usuarios WHERE ID = '$uD'";
                              $result2 = $conn->query($query2);
                              if (!$result2) die("Fatal Error");
                              $rowN = $result2->fetch_array(MYSQLI_ASSOC);

                              //Variables
                              $Nombre2 = $rowN['nombre'];
                              $Apellido2 = $rowN['apellido'];
                              $numC = $rowN['num_cuenta'];
                              $imagen = $row['imagen'];
                              $descripcion = $row['descripcion'];

                              //Direccion de Imagen (IMPORTANTE)
                              $imgUser = "Users/".$numC."/".$fotoU;
                              $imgPost = "Users/".$numC."/Posts/".$imagen;
                              ?>
                                <div class="publicacion">
                                  <div class="cont-publicacion">
                                    <div class="infousuario">
                                        <img src="<?php echo $imgUser;?>" class="imgSugerencia"><h6><?php echo $Nombre2.' '.$Apellido2; ?></h6><i class="fas fa-flag"></i>
                                    </div>
                                    <div class="contenido">

                                        <img src="<?php echo $imgPost;?>" class="contenidoImg" width="100%" height="100%">

                                    </div>
                                    <p><?php echo $descripcion; ?></p>
                                    <div class="flex-container iconos">
                                        <i class="fas fa-comment-dots icono"></i>
                                        <h1 class="texto-icono">522</h1>
                                      <div class="emotes">
                                        <span class="emotestodos">
                                            <i class="fas fa-heart"></i>
                                            <i class="fas fa-thumbs-up sombrathumb"></i>
                                            <i class="fas fa-thumbs-up"></i>
                                            <span class="sorpresa">&#128562;</span>
                                            <span class="emocion">&#128518;</span>
                                        </span>

                                            <span class="emotesrow"><i class="fas fa-heart"></i> <i class="fas fa-thumbs-up"></i>&#128562;&#128518;</span>
                                        </div>

                                        <h1 class="texto-icono">5k</h1>
                                            <div class="program">
                                                <i class="fab fa-adobe"></i>
                                            </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                            }
                          $conn->close();
                        ?>

                    </span>
                </span>

        </div>
        <div id="columnaderecha">
            <div id="menuderecha">

                <div id="menuderbusqueda">
                    <i class="fas fa-search"></i><input id="taskInput" type="text" placeholder="Buscar...">
                </div>
                <div id="menudersugerencias">
                    <div id="mdspersonas">
                        <h6>SUGERENCIAS PARA TI</h6>
                        <dl class="mdspersonas">
                            <dt>
                                <img src="images/baba.jpg" class="imgSugerencia" alt="sugerencia"> Naima Roig <a class="botonder">SEGUIR</a>
                            </dt>
                        </dl>

                    </div>
                    <div id="mdstags">
                        <h6>EXPLORAR TAGS</h6>
                        <dl class="mdstags">
                            <dt> #Modelado3D <a class="botonder">SEGUIR</a></dt>
                            <dt>#Dibujo <a class="botonder">SEGUIR</a></dt>
                            <dt>#Animacion2D <a class="botonder">SEGUIR</a></dt>
                            <dt>#Ilustracion <a class="botonder">SEGUIR</a></dt>
                        </dl>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    function botonSalir() {
      var x = document.getElementById("ventanaSalir");
      if (x.style.display === "none") {
        x.style.display = "flex";
      } else {
        x.style.display = "none";
      }
    }
    </script>

</body>
</html>
