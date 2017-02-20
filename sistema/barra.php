        <div class="sidebar" data-active-color="green" data-background-color="black" data-image="../img/sidebar-1.jpg">
        <!--
            Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
            Tip 2: you can also add an image using data-image tag
            Tip 3: you can change the color of the sidebar with data-background-color="white | black"
        -->

            <div class="logo">
                <a href="menu.php" class="simple-text">
                    ASCAS, S.A. DE C.V.
                </a>
            </div>

            <div class="logo logo-mini">
                <a href="menu.php" class="simple-text">
                </a>
            </div>

                <div class="sidebar-wrapper">
                    <div class="user">
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                                <?php echo $_SESSION['usuario_sesion']->getPrimernombre()." ".$_SESSION['usuario_sesion']->getPrimerapellido(); ?>
                               <?php
                                      $cargo=new cargos_class();
                                      $cargo=getInfoCargos($_SESSION['usuario_sesion']->getIdcargos());
                               ?>
                                <b class="caret"></b>
                            </a>
                            <div class="collapse" id="collapseExample">
                                <ul class="nav">
                                    <li><a href="#">Perfil</a></li>
                                    <li><a href="#">Editar Perfil</a></li>
                                    <li><a href="../php/logout.php">Salir</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <ul class="nav">
                    <!--Planilla-->
                    <?php
                    if($cargo->getPPlanilla()){
                      echo "
                      <li>
                      <a data-toggle='collapse' href='#componentsExamples'>
                      <p>PLANILLAS <b class='caret'></b> </p>
                      </a>
                      <div class='collapse' id='componentsExamples'>
                        <ul class='nav'>
                          <li><a href=''>Salarios</a></li>
                          <li><a href=''>Horas Extras</a></li>
                          <li><a href=''>Aguinaldo</a></li>
                          <li><a href=''>Comisiones</a></li>
                          <li><a href='Prestaciones_Laborales.php'>Prestaciones Laborales</a></li>
                        </ul>
                      </div>
                    </li>
                    <!--Seguro Social-->
                    <li>
                        <a href=''>
                            <p>SEGURO SOCIAL</p>
                        </a>
                    </li>
                    <!--Pensiones-->
                    <li>
                        <a href=''>
                            <p>FONDO DE PENSIONES</p>
                        </a>
                    </li>
                    <!--Ministerio de hacienda-->
                    <li>
                        <a href=''>
                            <p>MINISTERIO DE HACIENDA</p>
                        </a>
                    </li>
                    <!--Jornadas-->
                     <li>
                      <a data-toggle='collapse' href='#componentsExamples4'>
                      <p>JORNADAS <b class='caret'></b> </p>
                      </a>
                      <div class='collapse' id='componentsExamples4'>
                        <ul class='nav'>
                          <li><a href='turno.php'>Turnos</a></li>
                          <li><a href='semanal.php'>Semanal</a></li>
                          <li><a href='ReporteSemanal.php'>Reporte  Semanal</a></li>
                        </ul>
                      </div>
                    </li>
                      ";

                    };
                    ?>
                    <!--Agregar Empleados-->
                    <?php
                      if($cargo->getPempleado()){
                        echo "<li>
                              <a data-toggle='collapse' href='#componentsExamples3'>
                              <p>EMPLEADOS <b class='caret'></b> </p>
                              </a>
                              <div class='collapse' id='componentsExamples3'>
                                <ul class='nav'>
                                  <li><a href='AgregarEmpleado.php'>Agregar</a></li>
                                  <li><a href='verEmpleados.php'>Ver</a></li>
                                </ul>
                                </div>
                              </li> ";
                      };
                    ?>

                     <li>
                        <a data-toggle="collapse" href="#componentsExamples2">
                          <p>CONTROL R.R.H.H. <b class="caret"></b> </p>
                          </a>
                          <div class="collapse" id="componentsExamples2">
                            <ul class="nav">
                              <li><a href="#">Constancias de Salarios</a></li>
                              <li><a href="usuarios.html">Expedientes de Empleados</a></li>
                              <li><a href="#">Prestaciones Laborales</a></li>
                            </ul>
                          </div>
                        </li>
                      </ul>



                            </div>
            </div>
