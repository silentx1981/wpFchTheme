
<div class="col-sm-6">
	<div class="card">
		<img src="<?php echo $personData['avatar']; ?>" class="card-img-top" alt="<?php echo "$personData[vorname] $personData[name]" ?>">
		<div class="card-body">
			<h5 class="card-title"><?php echo "$personData[vorname] $personData[name]" ?></h5>
			<?php if ($personData['mail'] !== null) { ?>
				<div>
					<a href="javascript:open_mailto('<?php echo $personData['maillink']; ?>')"><i class="far fa-envelope fa-fw"></i> <?php echo $personData['mail']; ?></a>
				</div>
			<?php } ?>
			<?php if ($personData['mobile'] !== null) { ?>
				<div>
					<a href="tel:open_tel('<?php echo $personData['mobile'] ?>')"><i class="fas fa-mobile fa-fw"></i> <?php echo $personData['mobile'] ?></a>
				</div>
			<?php } ?>
			<?php if ($personData['phone'] !== null) { ?>
				<div>
					<a href="tel:open_tel('<?php echo $personData['phone'] ?>')"><i class="fas fa-phone fa-fw"></i> <?php echo $personData['phone'] ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
