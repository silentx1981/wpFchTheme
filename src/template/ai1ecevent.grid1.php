<div class="container">
    <div class="row">
        <?php
        foreach ($events as $event) {
            ?>
                <div class="col-sm-<?php echo floor(12 / $grid); ?>" style="margin-bottom: 20px;">
                    <div class="card h-100">
                        <div class="card-header text-center">
                            <strong><?php echo $event['post_title'] ?></strong>
                        </div>
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px;">
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
