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
            <div class="col-md-1 col-sm-12 col-12">
                <?php echo date('H:i', strtotime($spieldatum)); ?>
            </div>
            <div class="col-md-8 col-sm-10 col-10">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <?php echo $spiel['TeamA']; ?>
                    </div>
                    <div class="col-md-2 d-none d-md-block">-</div>
                    <div class="col-md-5 col-sm-12">
                        <?php echo $spiel['TeamB']; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-2 col-2">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <span class="text-right"><?php echo ($spiel['Goals'][0] ?? ''); ?></span>
                    </div>
                    <div class="col-md-2 d-none d-lg-block d-xl-block"><?php echo ($spiel['Goals'][1] ?? ''); ?></div>
                    <div class="col-md-3 col-sm-12"><?php echo ($spiel['Goals'][2] ?? ''); ?></div>
                </div>
            </div>
            <?php if ($spiel['Status'] === 'G') { ?>
                <div class="col-12 text-danger">
                    <small><i class="fas fa-exclamation-triangle"></i> nicht gespielt (Gegner)</small>
                </div>
            <?php }
            elseif ($spiel['Status'] === 'V') { ?>
            <div class="col-12 text-danger">
                <small><i class="fas fa-exclamation-triangle"></i> Verschoben</small>
            </div>
	        <?php }
            ?>
        </div>
    </div><?php
}
?></div><?php

?>