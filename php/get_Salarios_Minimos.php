<?php
$cnx=cnx();
$query=sprintf("SELECT * FROM salarios_minimos ");
$result=mysqli_query($cnx,$query);
while ($row=mysqli_fetch_array($result)) {
  echo "<option value='".$row["idSalario_Minimo"]."'>".$row["NombreRubro"]."</option>";
}
mysqli_close($cnx);

 ?>
