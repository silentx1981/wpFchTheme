<?php
$lastSpieldatum = '';
foreach ($spiele as $spieldatum => $spiel) {
    if (date('Y-m-d', strtotime($spieldatum)) !== date('Y-m-d', strtotime($lastSpieldatum))) {
        $lastSpieldatum = $spieldatum;
        ?><br><strong>
            <?php echo $locale['wochentagLong'][date('N', strtotime($spieldatum))].' '.date('d.m.Y', strtotime($spieldatum)); ?>
        </strong><br><?php
    }
    ?>
    <?php
        if($spiel['Status'] === 'G') {
	        echo '<s>'.date('H:i', strtotime($spieldatum)).' '.$spiel['TeamA'].' - '.$spiel['TeamB']."</s><br>";
	        echo "<small>nicht gespielt (Gegner)</small><br>";
        } else {
	        echo date('H:i', strtotime($spieldatum)).' '.$spiel['TeamA'].' - '.$spiel['TeamB']." | ".($spiel['Goals'][0] ?? '')." ".($spiel['Goals'][1] ?? '')." ".($spiel['Goals'][2] ?? '')."<br>";
        }
	?>
<?php
}
?>