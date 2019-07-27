<?php
$x = setlocale(LC_ALL, "de_CH.UTF-8");
$lastSpieldatum = '';
foreach ($spiele as $spieldatum => $spiel) {
    if (date('Y-m-d', strtotime($spieldatum)) !== date('Y-m-d', strtotime($lastSpieldatum))) {
        $lastSpieldatum = $spieldatum;
        ?><br><strong><?php echo date('l d.m.Y', strtotime($spieldatum)); ?></strong><br><?php
    }
    ?>
    <?php echo date('H:i', strtotime($spieldatum)).' '.$spiel['TeamA'].' - '.$spiel['TeamB']."<br>"; ?>
<?php
}
?>