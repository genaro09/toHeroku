<?php
 	$cnx=cnx();
 	$query=sprintf("SELECT * FROM empresa where TipoEmpresa!=1");
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    switch ($row["TipoEmpresa"]){
      case 0:
        $TipoEmpresa= "ACTIVA";
        break;
     case 1:
        $TipoEmpresa= "ADMIN";
        break;
     case 2:
        $TipoEmpresa= "BLOQUEADA";
        break;
    }
				 echo "<tr>
						<td>".$row["NitEmpresa"]."</td>
						<td>".$row["NombreEmpresa"]."</td>
						<td>".$row["Telefono"]."</td>
            <td>".$row["RepresentanteLegal"]."</td>
            <td>".$TipoEmpresa."</td>
						<td class='text-right'>
							<form method='post' action='Perfil_Empresa.php'>
							<input type='hidden' name='NitEmpresa' value='".$row["NitEmpresa"]."'>
              <input type='hidden' name='TipeRequest' value='1'>
							<input type='submit' style='background: url(../img/icons/setting.png);border: 0;margin-right:15px;' value='   '>
							</form>
						</td>
					</tr>";
	}
	mysqli_close($cnx);
?>
