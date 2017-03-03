        <div class="sidebar" data-active-color="green" data-background-color="black" data-image="../img/sidebar-1.jpg">
        <!--
            Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
            Tip 2: you can also add an image using data-image tag
            Tip 3: you can change the color of the sidebar with data-background-color="white | black"
        -->


                <div class="sidebar-wrapper">
                  <div style="padding-bottom:2px;" class="user">
                    <div style="width: 120px;height: 140px;overflow: hidden;  margin: 0 auto;">
                      <a href="menu.php" class="simple-text">
		                    <img  style="height:100%;width:100%;" src="../img/LogoBlanco.png" />
                      </a>
		                </div>

                  </div>
                    <div class="user">
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                                <?php echo $_SESSION['usuario_sesion']->getPrimernombre()." ".$_SESSION['usuario_sesion']->getPrimerapellido(); ?>
                               <?php
                                      $NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
                                      $cnx=cnx();
                                  		$query=sprintf("SELECT * FROM empresa where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
                                  		$result=mysqli_query($cnx,$query);
                                      $row=mysqli_fetch_array($result);
                                      $TipoEmpresa=$row["TipoEmpresa"];
                                      mysqli_close($cnx);
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
                  <!--enclosure-->
                  <?php
                    if($TipoEmpresa==1){
                      echo "
                      <li>
                      <a data-toggle='collapse' href='#componentsExamples'>
                      <p>EMPRESA <b class='caret'></b> </p>
                      </a>
                      <div class='collapse' id='componentsExamples'>
                        <ul class='nav'>
                          <li><a href='ENCLOSURE-EMPRESAS.php'>EMPRESAS</a></li>
                        </ul>
                      </div>
                    </li>
                    ";

                    }

                   ?>

                  <!--/enclosure-->



                    <!--Planilla-->
                    <?php
                    if($cargo->getPPlanilla()&& $TipoEmpresa!=1){
                      echo "
                      <li>
                      <a data-toggle='collapse' href='#componentsExamples'>
                      <p>PLANILLAS <b class='caret'></b> </p>
                      </a>
                      <div class='collapse' id='componentsExamples'>
                        <ul class='nav'>
                          <li><a href='#'>Salarios</a></li>
                          <li>
                            <a data-toggle='collapse' href='#componentsExamples5'>
                            <p>HorasExtras <b class='caret'></b> </p>
                            </a>
                            <div class='collapse' id='componentsExamples5'>
                            <ul class='nav'>
                              <li><a href='Horas_Extras.php'><span style='font-size:14px;margin-left:10%;'>Crear Horas Extras</span></a></li>
                              <li><a href='Reporte_Horas_Extras.php'><span style='font-size:14px;margin-left:10%;'>Reporte Horas Extras</span></a></li>
                            </ul>
                          </li>
                          <li><a href='#'>Aguinaldo</a></li>
                          <li><a href='#'>Comisiones</a></li>
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
                    if($TipoEmpresa!=1){
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
                      echo "
                        <li>
                         <a data-toggle='collapse' href='#componentsExamples2'>
                           <p>CONTROL R.R.H.H. <b class='caret'></b> </p>
                           </a>
                           <div class='collapse' id='componentsExamples2'>
                             <ul class='nav'>
                               <li><a href='departamento.php'>Departamentos</a></li>
                               <li><a href='cargos.php'>Cargos</a></li>
                               <li><a href='#'>Constancias de Salarios</a></li>
                               <li><a href='#'>Expedientes de Empleados</a></li>
                             </ul>
                           </div>
                         </li>
                      ";
                    }
                    ?>


                      </ul>



                            </div>
            </div>
