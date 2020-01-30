
<style>
    .rowSlider {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
    }
    .rowSlider > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }
</style>

<div class="container text-center my-3">
    <div class="row mx-auto my-auto">
        <div id="spielBetriebCarousel" class="carousel slide w-100" data-ride="carousel" data-interval="false">
            <div class="carousel-inner" role="listbox"><?php
                foreach ($slideSpiele as $spieleday) {
                    ?>
                    <div class="carousel-item py-5 <?php echo $spieleday['Active']; ?>">
                        <div class="row"><?php
                        foreach ($spieleday['Spieltage'] as $spieldatum => $spiele) {
                            ?>
                            <div class="col-sm-<?php echo floor(12 / $grid); ?>" style="margin-bottom: 20px;">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <strong>
                                            <?php echo $locale['wochentagLong'][date('N', strtotime($spieldatum))].' '.date("d.m.Y", strtotime($spieldatum)); ?>
                                        </strong>
                                    </div>
                                    <div class="card-body text-left">
                                        <?php
                                        foreach ($spiele['spiele'] as $spiel) {
                                            ?>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="badge <?php echo $spiel['TypClass']; ?>">
                                                            <?php echo $spiel['Typ'] ?>
                                                        </span>
                                                    </div>
                                                    <div class="col-12">
                                                        <?php echo date('H:i', strtotime($spiel['Datumzeit'])); ?>
                                                        <?php
                                                        if ($spiel['Location'] !== '') {
                                                            ?>
                                                            <span data-toggle="tooltip" data-placement="top" title="<?php echo $spiel['Location']; ?>">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                            </span>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="row">
                                                            <div class="col-12 <?php if ($spiel['HomeTeam'] === 'TeamA') echo 'font-weight-bold'; ?>">
                                                                <?php echo $spiel['TeamA']; ?>
                                                            </div>
                                                            <div class="col-12 <?php if ($spiel['HomeTeam'] === 'TeamB') echo 'font-weight-bold'; ?>">
                                                                <?php echo $spiel['TeamB']; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="text-right"><?php echo($spiel['TorA'] ?? ''); ?></span>
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
                                            </div>
                                            <hr>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?></div><?php
                    ?></div><?php
                }
                ?>
            </div>
            <?php
                if (count($slideSpiele) > $grid) {
                    ?>
                        <a class="carousel-control-prev" href="#spielBetriebCarousel" role="button" data-slide="prev" style="justify-content: left; width: 30px;">
                            <i class="fas fa-3x fa-chevron-left text-info"></i>
                        </a>
                        <a class="carousel-control-next" href="#spielBetriebCarousel" role="button" data-slide="next" style="justify-content: flex-end; width: 30px;">
                            <i class="fas fa-3x fa-chevron-right text-info"></i>
                        </a>
                    <?php
                }
            ?>
        </div>
    </div>
</div>



