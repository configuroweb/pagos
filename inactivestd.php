<?php $page = 'inact';
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg = '';
$action = "add";

$id = "";
$emailid = '';
$sname = '';
$joindate = '';
$remark = '';
$contact = '';
$balance = 0;
$fees = '';
$about = '';
$grade = '';




if (isset($_GET['action']) && $_GET['action'] == "delete") {

    $conn->query("DELETE FROM student WHERE id='" . $_GET['id'] . "'");
    header("location: student.php?act=3");
}

if (isset($_GET['action']) && $_GET['action'] == "approve") {

    $conn->query("UPDATE student set delete_status = '0'  WHERE id='" . $_GET['id'] . "'");
    header("location: inactivestd.php?act=2");
}



if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "1") {
    $errormsg = "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>¡Se ha agregado el registro del estudiante!</div>";
} else if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "2") {
    $errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>¡El registro del estudiante ha sido actualizado!</div>";
} else if (isset($_REQUEST['act']) && @$_REQUEST['act'] == "3") {
    $errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>¡El estudiante ha sido eliminado!</div>";
}

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

    <link href="css/ui.css" rel="stylesheet" />
    <link href="css/datepicker.css" rel="stylesheet" />

    <script src="js/jquery-1.10.2.js"></script>

    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>


</head>
<?php
include("php/header.php");
?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Estudiantes Inactivos</h1>

                <?php

                echo $errormsg;
                ?>
            </div>
        </div>



        <?php
        if (isset($_GET['action']) && @$_GET['action'] == "add" || @$_GET['action'] == "edit") {
        ?>

            <script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>


        <?php
        } else {
        ?>

            <link href="css/datatable/datatable.css" rel="stylesheet" />


            <div class="panel panel-default">
                <div class="panel-heading">
                    Gestionar Estudiantes Inactivos
                </div>
                <div class="panel-body">
                    <div class="table-sorting table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tSortable22">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre | Contacto</th>
                                    <th>Grado</th>
                                    <th>Ingreso</th>
                                    <th>Pagos</th>
                                    <th>Balance</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "select * from student where delete_status='1'";
                                $q = $conn->query($sql);
                                $i = 1;
                                while ($r = $q->fetch_assoc()) {

                                    echo '<tr ' . (($r['balance'] > 0) ? 'class="primary"' : '') . '>
                                            <td>' . $i . '</td>
                                            <td>' . $r['sname'] . '<br/>' . $r['contact'] . '</td>
                                            <td>' . $r['grade'] . '</td>
                                            <td>' . date("d M y", strtotime($r['joindate'])) . '</td>
                                            <td>' . $r['fees'] . '</td>
											<td>' . $r['balance'] . '</td>
											<td>
											
											<a href="inactivestd.php?action=approve&id=' . $r['id'] . '" class="btn btn-success btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-ok"></span></a>
											
											<a onclick="return confirm(\'Deseas eliminar permanentemente este registro?\');" href="inactivestd.php?action=delete&id=' . $r['id'] . '" class="btn btn-danger btn-xs" style="border-radius:60px;"><span class="glyphicon glyphicon-trash"></span></a> </td>
											
                                        </tr>';
                                    $i++;
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script src="js/dataTable/jquery.dataTables.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#tSortable22').dataTable({
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bInfo": false,
                        "bAutoWidth": true
                    });

                });
            </script>

        <?php
        }
        ?>



    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->




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