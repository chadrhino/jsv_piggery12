<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>
<?php
if (isset($_POST['submit'])) {
	$name = $_POST['vitamins'];
	$brand = $_POST['brand'];
	$stock = $_POST['stock'];

	if (!empty($name) && !empty($stock) && !empty($brand)) {
		$query = $db->query("INSERT INTO vitamins(name,stock,brand)VALUES('$name', '$stock', '$brand')");

		if ($query) { ?>
			<!-- <script>
				alert('Vitamins Added. Click OK to close dialogue.')
			</script> -->
			<script>
			const Toast = Swal.mixin({
				toast: true,
				position: "top-end",
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.onmouseenter = Swal.stopTimer;
					toast.onmouseleave = Swal.resumeTimer;
				}
			});
	
			Toast.fire({
				icon: "success",
				title: "Vitamins deleted successfully"
			});
		</script>
<?php
			// header('refresh: 1.5');
		}
	}
}

if (isset($_POST['update'])) {
	$name = $_POST['vitamins'];
	$brand = $_POST['brand'];
	$stock = $_POST['stock'];
	$id = $_POST['id'];

	if (!empty($name) && !empty($stock) && !empty($brand)) {
		$query = $db->query("UPDATE vitamins SET name = '$name', stock = '$stock', brand = '$brand' WHERE id = '$id'");

		if ($query) { ?>
			<!-- <script>
				alert('Vitamins updated successfully. Click OK to close dialogue.')
			</script> -->
			<script>
			const Toast = Swal.mixin({
				toast: true,
				position: "top-end",
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.onmouseenter = Swal.stopTimer;
					toast.onmouseleave = Swal.resumeTimer;
				}
			});
	
			Toast.fire({
				icon: "success",
				title: "Vitamins updated successfully"
			}).then(() => {
				window.location.href = "manage-vitamins.php"
			})
		</script>
<?php
			// header('refresh: 1.5;url=manage-vitamins.php');
		}
	}
}

if (isset($_GET['delete'])) {
	$id = $_GET['id'];

	$query = $db->query("DELETE FROM vitamins WHERE id = '$id'");

	if ($query) { 
		?>
			<!-- <script>
				alert('Vitamins deleted successfully. Click OK to close dialogue.')
			</script> -->
			<script>
			const Toast = Swal.mixin({
				toast: true,
				position: "top-end",
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.onmouseenter = Swal.stopTimer;
					toast.onmouseleave = Swal.resumeTimer;
				}
			});
	
			Toast.fire({
				icon: "success",
				title: "Vitamins deleted successfully"
			}).then(() => {
				window.location.href = "manage-vitamins.php"
			})
		</script>
		<?php
		// header('refresh: 1.5; url=manage-vitamins.php');
	}

}
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

	<!-- Header -->
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
	</header>

	<?php #include 'inc/data.php'; 
	?>


	<div class="w3-container" style="padding-top:22px">
		<div class="w3-row">
			<h2>Pig Vitamins</h2>
			<div class="col-md-12">
				<a title="Check to delete from list" data-toggle="modal" data-target="#_removed" id="delete" class="btn btn-danger"><i class="fa fa-trash"></i>
				</a>
				<form method="post" action="delete_vitamin.php">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Brand</th>
								<th>Stock</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php

							$get = $db->query("SELECT * FROM vitamins");
							$res = $get->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $n) { ?>
								<tr>
									<td>
										<input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
									</td>
									<td> <?php echo $n->name; ?> </td>
									<td> <?php echo $n->brand; ?> </td>
									<td> <?php echo $n->stock; ?> </td>
									<td class="dropdown">
										<button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option
											<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="manage-vitamins.php?edit&id=<?php echo $n->id ?>"><i class="fa fa-edit"></i> Edit</a></li>
											<li><a onclick="return confirm('Continue delete vitamins ?')" href="?delete&id=<?php echo $n->id ?>"><i class="fa fa-trash"></i> Delete</a></li>
										</ul>
									</td>
								</tr>
							<?php }

							?>
						</tbody>
					</table>

					<?php include('inc/modal-delete.php'); ?>
				</form>
			</div>

			<?php 
				$title = "Add New Vitamins";
				$name = "";
				$brand = "";
				$stock = null;
				$button_name = "submit";
				$id = "";
				if (isset($_GET['edit'])) {
					$id = $_GET['id'];
					$get = $db->query("SELECT * FROM vitamins WHERE id = '$id'");
					$res = $get->fetch(PDO::FETCH_OBJ);
					$title = "Edit Vitamin";
					$name = $res->name;
					$brand = $res->brand;
					$stock = $res->stock;
					$button_name = "update";
				}
			?>				

			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading"><?= $title ?></div>
					<div class="panel-body">
						<form method="post">
							<div class="form-group">
								<?php 
									if ($id !== null) {
									?>
									<input type="hidden" name="id" value="<?= $id ?>">
									<?php 
									}
								?>
								<label class="control-label">Vitamin Name</label>
								<input type="text" name="vitamins" class="form-control" placeholder="Enter vitamin name" value="<?= $name ?>">
								<label class="control-label">Vitamin Brand</label>
								<input type="text" name="brand" class="form-control" placeholder="Enter vitamin brand" value="<?= $brand ?>">
								<label class="control-label">Vitamin Stock</label>
								<input type="number" name="stock" class="form-control" value="<?= $stock ?? 1 ?>">
							</div>

							<button class="btn btn-sm btn-default" type="submit" name="<?= $button_name ?>">Submit</button>


						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php include 'theme/foot.php'; ?>