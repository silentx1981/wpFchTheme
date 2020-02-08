<div class="container">
    <div class="row mx-auto my-auto">
        <div id="eventCarousel" class="carousel slide w-100" data-ride="carousel" data-interval="false">
            <div class="carousel-inner" role="listbox">
                <?php
                $active = 'active';
                foreach($sliderEvents as $events) {
                    ?>
                    <div class="carousel-item <?php echo $active; ?>">
                        <div class="row">
                            <?php
                            foreach ($events as $event) {
                                ?>
                                <div class="col-sm-<?php echo floor(12 / $grid); ?>" style="margin-bottom: 20px;">
                                    <div class="card h-100" style="min-height: 250px;">
                                        <div class="card-header text-center">
                                            <strong><?php echo $event['post_title']; ?></strong>
                                        </div>
                                        <div class="card-body" style="padding-left: 10px; padding-right: 10px;">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="d-flex mb-2">
                                                            <div class="align-self-start text-center" style="width: 50px;"> <i class="far fa-2x fa-calendar-alt"></i>&nbsp;&nbsp;</div>
                                                            <div class="align-self-center"><?php echo $locale['wochentagLong'][date('N', strtotime($event['Von']))].' '.date("d.m.Y", strtotime($event['Von'])); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex mb-2">
                                                            <div class="align-self-start text-center" style="width: 50px;"><i class="far fa-2x fa-clock"></i>&nbsp;&nbsp;</div>
                                                            <div class="align-self-center">
                                                                <h5>
                                                                    <?php
                                                                    echo date("H:i", strtotime($event['Von']));
                                                                    if ((int) $event['instant_event'] !== 1)
                                                                        echo " - ".date("H:i", strtotime($event['Bis']));
                                                                    ?>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($event['beschreibung'])) {
                                                        ?>
                                                        <div class="col-12">
                                                            <div class="d-flex mb-2">
                                                                <div class="align-self-start text-center" style="width: 50px;"><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;</div>
                                                                <div class="align-self-center"><?php echo $event['beschreibung']; ?></div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $active = '';
                }
                ?>
            </div>
            <?php
            if (count($sliderEvents) > 1) {
                ?>
                <a class="carousel-control-prev" href="#eventCarousel" role="button" data-slide="prev" style="justify-content: left; width: 30px;">
                    <i class="fas fa-3x fa-chevron-left text-info"></i>
                </a>
                <a class="carousel-control-next" href="#eventCarousel" role="button" data-slide="next" style="justify-content: flex-end; width: 30px;">
                    <i class="fas fa-3x fa-chevron-right text-info"></i>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</div>
