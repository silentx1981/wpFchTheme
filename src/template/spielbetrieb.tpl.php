<?php

$lastSpieldatum = '';
?><div class="list-group"><?php
foreach ($spiele as $spieldatum => $spiel) {
	if (date('Y-m-d', strtotime($spieldatum)) !== date('Y-m-d', strtotime($lastSpieldatum))) {
	    $lastSpieldatum = $spieldatum;
        ?><br><div class="list-group-item bg-light"><?php echo $locale['wochentagLong'][date('N', strtotime($spieldatum))].' '.date('d.m.Y', strtotime($spieldatum)); ?></div><?php
    }
    ?><div class="list-group-item">
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
                        <span class="text-right"><?php echo ($spiel['TorA'] ?? ''); ?></span>
                    </div>
                    <div class="col-12"><?php echo ($spiel['TorB'] ?? ''); ?></div>
                </div>
            </div>
            <?php if (isset($spiel['Status']) && $spiel['Status'] !== '') { ?>
                <div class="col-12 text-danger">
                    <small><i class="fas fa-exclamation-triangle"></i> <?php echo $spiel['Status']; ?></small>
                </div>
            <?php } ?>
        </div>
    </div><?php
}
?></div>
