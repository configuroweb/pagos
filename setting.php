<?php $page = 'setting';
include("php/dbconnect.php");
include("php/checklogin.php");
$error = '';
if (isset($_POST['save'])) {

	$oldpassword = mysqli_real_escape_string($conn, $_POST['oldpassword']);
	$newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);
	$sql = "select * from user where id= '" . $_SESSION['rainbow_uid'] . "' and password='" . md5($oldpassword) . "'";
	$q = $conn->query($sql);
	if ($q->num_rows > 0) {

		$sql = "update user set  password = '" . md5($newpassword) . "' WHERE id = '" . $_SESSION['rainbow_uid'] . "'";
		$r = $conn->query($sql);
		echo '<script type="text/javascript">window.location="setting.php?act=1"; </script>';
	} else {
		$error = '<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error!</strong> Contraseña previa incorrecta
</div>';
	}
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

	<script src="js/jquery-1.10.2.js"></script>

	<script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>

</head>
<?php
include("php/header.php");
?>
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-head-line">Cambiar Contraseña</h1>

				<?php
				if (isset($_REQUEST['act']) &&  @$_REQUEST['act'] == '1') {
					echo '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Exito!</strong> Cambio de contraseña correcto.
</div>';
				}
				echo $error;
				?>
			</div>
		</div>
		<!-- /. ROW  -->
		<div class="row">

			<div class="col-sm-8 col-sm-offset-2">
				<div class="panel panel-success">
					<div class="panel-heading">
						Cambiar Contraseña
					</div>
					<form action="setting.php" method="post" id="signupForm1" class="form-horizontal">
						<div class="panel-body">




							<div class="form-group">
								<label class="col-sm-4 control-label" for="Old">Contraseña Previa</label>
								<div class="col-sm-5">
									<input type="password" class="form-control" id="oldpassword" name="oldpassword" />
								</div>
							</div>


							<div class="form-group">
								<label class="col-sm-4 control-label" for="Password"> Nueva Contraseña</label>
								<div class="col-sm-5">
									<input class="form-control" name="newpassword" id="newpassword" type="password">
								</div>
							</div>


							<div class="form-group">
								<label class="col-sm-4 control-label" for="Confirm">Confirmar Contraseña</label>
								<div class="col-sm-5">
									<input class="form-control" name="confirmpassword" type="password">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-9 col-sm-offset-4">
									<button type="submit" name="save" class="btn btn-success" style="border-radius:0%">Cambiar Contraseña </button>
								</div>
							</div>





						</div>
					</form>

				</div>
			</div>


		</div>
		<!-- /. ROW  -->


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

<script type="text/javascript">
	$(document).ready(function() {

		$("#signupForm1").validate({
			rules: {
				oldpassword: "required",

				newpassword: {
					required: true,
					minlength: 6
				},

				confirmpassword: {
					required: true,
					minlength: 6,
					equalTo: "#newpassword"
				}
			},
			messages: {
				oldpassword: "Por favor ingrese su antigua contraseña",

				newpassword: {
					required: "Por favor proporcione una contraseña",
					minlength: "Tu contraseña debe tener al menos 6 caracteres"
				},
				confirmpassword: {
					required: "Por favor proporcione una contraseña",
					minlength: "Tu contraseña debe tener al menos 6 caracteres",
					equalTo: "Por favor ingrese la misma contraseña que arriba"
				}
			},
			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");

				// Add `has-feedback` class to the parent div.form-group
				// in order to add icons to inputs
				element.parents(".col-sm-5").addClass("has-feedback");

				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.parent("label"));
				} else {
					error.insertAfter(element);
				}

				// Add the span element, if doesn't exists, and apply the icon classes to it.
				if (!element.next("span")[0]) {
					$("<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
				}
			},
			success: function(label, element) {
				// Add the span element, if doesn't exists, and apply the icon classes to it.
				if (!$(element).next("span")[0]) {
					$("<span class='glyphicon glyphicon-ok form-control-feedback'></span>").insertAfter($(element));
				}
			},
			highlight: function(element, errorClass, validClass) {
				$(element).parents(".col-sm-5").addClass("has-error").removeClass("has-success");
				$(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents(".col-sm-5").addClass("has-success").removeClass("has-error");
				$(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
			}
		});
	});
</script>

<?php
include("php/footer.php");
?>

</body>

</html>