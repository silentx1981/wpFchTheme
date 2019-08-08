<?php
if ($spiele['typ'] === '') {

    ?>
    <table role="table" class="table table-bordered table-striped fch-table-responsive">
        <thead role="rowgroup" class="bg-light">
            <tr role="row">
                <th class="text-center">Rang</th>
                <th>Mannschaft</th>
                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Spiele"> S </th>
                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Siege"> S </th>
                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Unentschieden"> U </th>
                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Niederlagen"> N </th>
                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Strafpunkte"> S </th>
                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Tore"> T </th>
                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Punkte"> P </th>
            </tr>
        </thead>
        <tbody role="rowgroup">
        <?php
            foreach ($spiele['rangliste'] as $row) {
	            ?>
                <tr>
                    <td role="cell" data-title="Rang"><?php echo $row['rang']; ?>&nbsp;</td>
                    <td role="cell" data-title="Mannschaft"><?php echo $row['team']; ?></td>
                    <td class="text-center" role="cell" data-title="Spiele"><?php echo $row['spiele']; ?></td>
                    <td class="text-center" role="cell" data-title="Siege"><?php echo $row['siege']; ?></td>
                    <td class="text-center" role="cell" data-title="Unentschieden"><?php echo $row['unentschieden']; ?></td>
                    <td class="text-center" role="cell" data-title="Niederlagen"><?php echo $row['niederlagen']; ?></td>
                    <td class="text-center" role="cell" data-title="Strafpunkte"><?php echo $row['strafpunkte']; ?></td>
                    <td class="text-center" role="cell" data-title="Tore"><?php echo $row['tore']; ?> : <?php echo $row['gegentore']; ?></td>
                    <td class="text-center" role="cell" data-title="Punkte"><?php echo $row['punkte']; ?></td>

                </tr>
	            <?php
            }
        ?>
        </tbody>
    </table>

    <?php

} else {

	$lastSpieldatum = '';
	?>
    <div class="list-group"><?php
	foreach ($spiele['spiele'] as $spieldatum => $spiel) {
		if (date('Y-m-d', strtotime($spieldatum)) !== date(
				'Y-m-d', strtotime($lastSpieldatum)
			)) {
			$lastSpieldatum = $spieldatum;
			?><br>
            <div class="list-group-item bg-light"><?php echo $locale['wochentagLong'][date(
					'N', strtotime($spieldatum)
				)] . ' ' . date('d.m.Y', strtotime($spieldatum)); ?></div><?php
		}
		?>
        <div class="list-group-item">
        <div class="row">
            <div class="col-12">
				<?php echo date('H:i', strtotime($spieldatum)); ?>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-12">
						<?php echo $spiel['TeamA']; ?>
                    </div>
                    <div class="col-12">
						<?php echo $spiel['TeamB']; ?>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="row">
                    <div class="col-12">
                        <span class="text-right"><?php echo($spiel['TorA'] ??
								''); ?></span>
                    </div>
                    <div class="col-12"><?php echo($spiel['TorB'] ??
							''); ?></div>
                </div>
            </div>
			<?php if (isset($spiel['Status']) && $spiel['Status'] !== '') { ?>
                <div class="col-12 text-danger">
                    <small>
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $spiel['Status']; ?>
                    </small>
                </div>
			<?php } ?>
        </div>
        </div><?php
	}
	?></div>
	<?php
}
