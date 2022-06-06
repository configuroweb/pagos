<?php $page = 'dashboard';
include("php/dbconnect.php");
include("php/checklogin.php");


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" sizes="16x16" href="./img/logo.png">
    <title>Gestión de Pagos ConfiguroWeb</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />


</head>
<?php
include("php/header.php");
?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Panel de Control</h1>


            </div>
        </div>
        <!-- /. ROW  -->
        <div class="row">

            <div class="col-md-4">
                <div class="main-box mb-yell">
                    <a href="student.php">
                        <h4>Estudiantes <?php include 'counter/stucount.php' ?></h4>
                        <h5>Gestionar Estudiantes</h5>
                    </a>
                </div>
            </div>




            <div class="col-md-4">
                <div class="main-box mb-yell">
                    <a href="fees.php">
                        <h4>Ganancias <?php include 'counter/totalearncount.php' ?></h4>
                        <h5>Gestionar Pagos</h5>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="main-box mb-yell">
                    <a href="report.php">
                        <i class="fa fa-file-pdf-o fa-3x"></i>
                        <h5>Reportes</h5>
                    </a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Lista de Estudiantes
            </div>
            <div class="panel-body">
                <div class="table-sorting table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tSortable22">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre | Contacto</th>
                                <th>Grado</th>
                                <th>Fecha Ingreso</th>
                                <th>Pagos</th>
                                <th>Balance</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from student where delete_status='0'";
                            $q = $conn->query($sql);
                            $i = 1;
                            while ($r = $q->fetch_assoc()) {

                                echo '<tr ' . (($r['balance'] > 0) ? 'class="primary"' : '') . '>
                                            <td>' . $i . '</td>
											<td>' . $r['sname'] . '<br/>' . $r['contact'] . '</td>
											<td>' . $r['grade'] . '' . '</td>
                                            <td>' . date("d M y", strtotime($r['joindate'])) . '</td>
                                            <td>' . $r['fees'] . '</td>
											<td>' . $r['balance'] . '</td>
											<td>
											
											

											<a href="student.php?action=edit&id=' . $r['id'] . '" class="btn btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-edit"></span></a>
											
											<a onclick="return confirm(\'¿Deseas desactivar este registro?\');" href="student.php?action=delete&id=' . $r['id'] . '" class="btn btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-remove"></span></a> </td>
											
                                        </tr>';
                                $i++;
                            }
                            ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /. ROW  -->
    </div>

</div>
<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->





<script src="js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="js/custom1.js"></script>

<?php
include("php/footer.php");
?>



</body>

</html>