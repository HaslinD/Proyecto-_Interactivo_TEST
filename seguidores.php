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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


    <title>AnimationStudents</title>
</head>
<body>
    <div id="contenedor">

        <div id="columnaizquierda">
            <div id="menuizquierda">
                <div id="menuizquni">
                    <a href="main.php"><img src="images/Logo_UNITEC.png" class="logoMain"></a>
                </div>


                <!--Perfil Columna Derecha-->
                <div id="menuizqperfil">
                    <img src="<?php echo $fileSRC;?>" class="imgUsuario"> <i class="fas fa-pen"></i><br>
                    <h1 class="nombre"><?php echo $Nombre." ".$Apellido;?></h1>
                </div>
                <!--Perfil Columna Derecha-->


                <!--Botones Opciones-->
                <div id="menuizqopciones">
                    <a href="perfil.php" class="botonizq">VER PERFIL</a><br>
                    <a class="botonizq" href="CrearPost.php" id="publicacionBTN"><i class="fas fa-plus"></i>NUEVA PUBLICACI??N</a>
                </div>
            </div>
            <!--Botones Opciones-->

            <!--Boton Salir-->
            <a href="#" onclick="botonSalir()"><i class="fas fa-sign-out-alt"></i></a>
            <!--Boton Salir-->
        </div>

        <!--Pop up de botonSalir -->
        <div id="ventanaSalir" class="modal" style="display: none;">
            <div class="contenidoSalir">
                <h4>??Est??s seguro que quieres cerrar sesi??n?</h4>
                <div class="opcionesSalir">
                    <a href="index.php" class="botonSi">SI</a>
                    <a onclick="botonSalir()" href="#" class="botonNo">NO</a>
            </div>
            </div>
        </div>


        <!--Pop UP Publicacion-->
        <div id="myModal" class="modal">
            <div id="ventanaPublicar">
                <div class="content">
                    <div class="container">

                         <!--Titulo de Nueva Publicaci??n-->
                        <div id="tituloNuevaPub" class="borde">
                            <h1>Nueva Publicaci??n</h1>

                            <!--X de cierre-->
                            <span class="xCerrar"><i class="fas fa-times"></i></span>
                        </div>

                        <div class="agregarArchivo borde">

                            <!--Seleccion de Archivos a Publicar-->
                             <div>
                                <p>Seleccione un archivo de foto, video o pdf para publicar.</p>
                            </div>
                            <div class="seleccionados">
                                <img class="imgPublicar" src="images/ejemplo1.png" alt="placeholder">
                                <img class="imgPublicar" src="images/ejemplo2.png" alt="placeholder">

                                <!--BOTON de SELECCIONAR Archivos-->
                                <button class="seleccionarArchivo">
                                        <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>

                        <div class="borde descripcionInput">

                            <!--Input de DESCRIPCION del Post-->
                            <input type="text" name="Descripci??n" placeholder="Descripci??n...">

                            <!--EMOTES-->
                            <div class="emotes">
                                <span class="smile">&#128512;</span>
                                <span class="emotesrow"><i class="fas fa-heart"></i> <i class="fas fa-thumbs-up"></i>&#128562;&#128518;</span>
                            </div>
                        </div>

                        <div class="publicarCancelar">

                            <!--Botones para PUBLICAR o CANCELAR el post-->
                            <input href="#" type="submit" value="Cancelar" class="btn-red cerrar">
                            <input href="#" type="submit" value="Publicar" class="btn-blue">
                        </div>
                    </div>
                </div>
             </div>
        </div>

        <!--Pop UP Publicacion-->

        <div id="columnacentral" style="background-color: white">
            <div>
      				<div class="seguidores-contenedor">
      				<div style="text-align: center; background-color:#707070; font-size: 20px; color: white;">Personas</div>
      				<a href="#" class="tab" onclick="showStuff(this);changeColor(this.id);" id="seguidos1">Seguidos</a><a href="#" class="tab" onclick="showStuff(this);changeColor(this.id)" id="seguidos2">Seguidores</a>

      				<div class="perfiles-contenedor, tabContent" id="seguidos-1">
      					<div class="perfiles"><img src="images/baba.jpg" width="400" height="400" alt=""/><p>Haslin Avila</p><button class="seguir"><span class="remover">Remover</span><span class="seguir-t">Seguido</span></button>
      				    </div>
      				</div>
      				<div class="perfiles-contenedor, tabContent" id="seguidos-2">

      				</div>
      			</div>
    			</div>
			</div>



        <div id="columnaderecha">
            <div id="menuderecha">
                <!---Barra de Busqueda---->
                <div id="menuderbusqueda">
                    <i class="fas fa-search"></i><input id="taskInput" type="text" placeholder="Buscar...">
                </div>
                <!---Barra de Busqueda---->


                <div id="menudersugerencias">
                    <!---Sugerencias de Personas---->
                    <div id="mdspersonas">
                        <h6>SUGERENCIAS PARA TI</h6>

                        <?php
                            //Control del Contador de Filas en la tabla del la Base de DATOS
                            $queryC = "SELECT * FROM perfil WHERE user_ID != $id";
                            $resultC = $conn->query($queryC);
                            if (!$resultC) die("Fatal Error");

                            $count = $resultC->num_rows;
                            for ($i = 0; $i < $count; $i++) {
                              //Control del FOR Loop
                              $row = $resultC->fetch_array(MYSQLI_ASSOC);
                              $uD = $row['user_ID'];

                              //verificar si existe relaci??n en la tabla
                              $queryFL = "SELECT * FROM follow WHERE userL_ID = $id and userF_ID = $uD";
                              $resultFL = $conn->query($queryFL);

                              $ctfl = $resultFL->num_rows;
                              if ($ctfl == 0) {
                                  //No encontro relaci??n (imprimir)
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

                                  //Direccion de Imagen (IMPORTANTE)
                                  $imgUser = "Users/".$numC."/".$fotoU;
                                  ?>
                                    <form class="" action="seguidores.php" method="post">
                                      <div class="mdspersonas row">
                                          <article class="col-md-2">
                                              <img src="<?php echo $imgUser;?>" class="imgSugerencia" alt="sugerencia">
                                          </article>
                                          <article class="col-md-5 personas">
                                              <?php echo $Nombre2.' '.$Apellido2; ?>
                                          </article>
                                          <article class="col-md-5">
                                             <button type="submit" name="buton" value="<?php echo $uD;?>" class="botonder">SEGUIR</button>
                                          </article>
                                      </div>
                                    </form>
                                  <?php

                               } else {

                               }
                            }
                            if (isset($_POST['buton'])) {
                               $nm = $_POST['buton'];

                               $querySeg = "INSERT INTO follow (userL_ID, userF_ID) VALUES" . "($id,$nm)";
                               $resultSeg = $conn->query($querySeg);
                               if (!$resultSeg) die("Fatal Error");
                           }

                          $conn->close();
                        ?>

                    </div>
                    <!---Sugerencias de Personas---->



                    <!---Sugerencias de Tags---->
                    <div id="mdstags">
                        <h6>EXPLORAR TAGS</h6>
                        <div class="mdstags row">
                            <article class="col-md-7">
                                #Modelado3D
                            </article>
                            <article class="col-md-5">
                                <a class="botonder">SEGUIR</a>
                            </article>

                            <article class="col-md-7">
                                #Dibujo
                            </article>
                            <article class="col-md-5">
                                <a class="botonder">SEGUIR</a>
                            </article>

                            <article class="col-md-7">
                                #Animacion2D
                            </article>
                            <article class="col-md-5">
                                <a class="botonder">SEGUIR</a>
                            </article>

                            <article class="col-md-7">
                                #Ilustracion
                            </article>
                            <article class="col-md-5">
                                <a class="botonder">SEGUIR</a>
                            </article>
                        </div>
                    </div>
                    <!----Sugerencias de Tags---->

                </div>
            </div>
        </div>
		</div>



    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>
<script>
function showStuff(element)  {
    var tabContents = document.getElementsByClassName('tabContent');
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = 'none';
    }

    // change tabsX into tabs-X in order to find the correct tab content
    var tabContentIdToShow = element.id.replace(/(\d)/g, '-$1');
    document.getElementById(tabContentIdToShow).style.display = 'block';
}

function changeColor(id) {
        var tabs = document.getElementsByClassName('tab')
        for (var i = 0; i < tabs.length; ++i) {
            var item = tabs[i];
            item.style.backgroundColor = (item.id == id) ? "#3B5F93" : "white";
			item.style.color = (item.id == id) ? "white" : "#3B5F93";
        }
    }
</script>
