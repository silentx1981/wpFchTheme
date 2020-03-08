<div class="container">
    <div class="row mx-auto my-auto">
        <div id="spielBetriebCarousel" class="carousel slide w-100" data-ride="carousel" data-interval="false">
            <div class="carousel-inner" role="listbox"><?php
                foreach ($slideSpiele as $spieleday) {
                    ?>
                    <div class="carousel-item <?php echo $spieleday['Active']; ?>">
                        <div class="row"><?php
                        foreach ($spieleday['Spieltage'] as $spieldatum => $spiele) {
                            ?>
                            <div class="col-sm-<?php echo floor(12 / $grid); ?>" style="margin-bottom: 20px;">
                                <div class="card h-100">
                                    <div class="card-header text-center">
                                        <strong>
                                            <?php echo $locale['wochentagLong'][date('N', strtotime($spieldatum))].' '.date("d.m.Y", strtotime($spieldatum)); ?>
                                        </strong>
                                    </div>
                                    <div class="card-body text-left">
                                        <?php
                                        foreach ($spiele['spiele'] as $spiel) {
                                            ?>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="badge <?php echo $spiel['TypClass']; ?> w-100" style="overflow: hidden;  margin-bottom: 10px;">
                                                            <?php echo $spiel['Typ'] ?>
                                                        </span>
                                                    </div>
                                                    <?php
                                                    if (isset($spiel['Status']) && $spiel['Status'] !== '') { ?>
                                                        <div class="col-12">
                                                            <div class="d-flex mb-2 text-danger">
                                                                <div class="align-self-start text-center" style="width: 50px;"> <i class="fas fa-exclamation-triangle"></i>&nbsp;</div>
                                                                <div class="align-self-center"><?php echo $spiel['Status']; ?></div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-12">
                                                        <div class="d-flex mb-2">
                                                            <div class="align-self-start text-center" style="width: 50px;"> <i class="far fa-2x fa-clock"></i>&nbsp;</div>
                                                            <div class="align-self-center"><?php echo date('H:i', strtotime($spiel['Datumzeit'])); ?></div>
                                                            <div class="align-self-start ml-auto p-2">
                                                                <?php if(!empty($spiel['Link'])) {
                                                                    ?>
                                                                    <a href="<?php echo $spiel['Link']; ?>" target="_blank"><i class="far fa-file-alt"></i></a>
                                                                    <?php
                                                                } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($spiel['Location'])) {
                                                        ?>
                                                        <div class="col-12">
                                                            <div class="d-flex mb-2">
                                                                <div class="align-self-start text-center" style="min-width: 50px;"><i class="fas fa-2x fa-map-marker-alt"></i>&nbsp;</div>
                                                                <div class="align-self-center"><?php echo $spiel['Location']; ?></div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-10" style="margin-top: 10px;">
                                                        <div class="row">
                                                            <div class="col-12 <?php if ($spiel['HomeTeam'] === 'TeamA') echo 'font-weight-bold'; ?>">
                                                                <?php echo $spiel['TeamA']; ?>
                                                            </div>
                                                            <div class="col-12 <?php if ($spiel['HomeTeam'] === 'TeamB') echo 'font-weight-bold'; ?>">
                                                                <?php echo $spiel['TeamB']; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2" style="margin-top: 10px;">
                                                        <div class="row">
                                                            <div class="col-12 <?php if ($spiel['HomeTeam'] === 'TeamA') echo 'font-weight-bold'; ?>">
                                                                <span class="text-right"><?php echo($spiel['TorA'] ?? ''); ?></span>
                                                            </div>
                                                            <div class="col-12 <?php if ($spiel['HomeTeam'] === 'TeamB') echo 'font-weight-bold'; ?>"><?php echo($spiel['TorB'] ?? ''); ?></div>
                                                        </div>
                                                    </div>
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
                if (count($slideSpiele) > 1) {
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



