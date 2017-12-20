<div class="section matchfunding auto-update-calls" id="matchfunding" >
    <div class="drop-img-container">
        <img class="center-block drop-img" src="/assets/img/project/drop.svg" alt="matchfunding">
    </div>
    <h2 class="title text-center">
        <?= $this->text('home-matchfunding-title') ?>
    </h2>
    <ul class="filters list-inline center-block text-center">
        <li class="active" data-status="3">
            <?= $this->text('home-matchfunding-open') ?>
        </li>
        <li class="active" data-status="4">
            <?= $this->text('home-matchfunding-active') ?>
        </li>
        <li data-status="5">
            <?= $this->text('home-matchfunding-finish') ?>
        </li>
    </ul>
    
    <div class="container" id="calls-container">
        <?= $this->insert('home/partials/calls_list', [
            'calls' => $this->calls
        ]) ?>
    </div>


    <div class="fluid-container details-container" id="matchfunding-advantages">
        <div class="container">
            <div class="row details-title">
                <div class="col-xs-12">
                    <h2 class="title text center">
                        <?= $this->text('home-matchfunding-details-title') ?>
                    </h2>
                </div>
            </div>
            <div class="row details">
                <div class="col-md-2 col-md-offset-1">
                        <div class="detail-item item-1 center-block">
                            <img class="img-responsive" src="/assets/img/home/icon_1.png" >
                        </div>
                        <div class="item-label text-center">
                            <?= $this->text('home-matchfunding-details-participation') ?>
                        </div>
                </div>
                <div class="col-md-2">
                    <div class="detail-item item-2 center-block">
                        <img class="img-responsive" src="/assets/img/home/icon_2.png" >
                    </div>
                    <div class="item-label text-center">
                        <?= $this->text('home-matchfunding-details-transparent') ?>
                    </div>
                </div>
                <div class="col-md-2">
                     <div class="detail-item item-3 center-block">
                            <img class="img-responsive" src="/assets/img/home/icon_3.png" >
                        </div>
                    <div class="item-label text-center">
                        <?= $this->text('home-matchfunding-details-legacy') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="detail-item item-4 center-block">
                        <img class="img-responsive" src="/assets/img/home/icon_4.png" >
                    </div>
                    <div class="item-label text-center">
                        <?= $this->text('home-matchfunding-details-learning') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="detail-item item-5 center-block">
                        <img class="img-responsive" src="/assets/img/home/icon_5.png" >
                    </div>
                    <div class="item-label text-center">
                        <?= $this->text('home-matchfunding-details-economy') ?>
                    </div>
                </div>
            </div>
            
            <div class="row call-action">
                <div class="col-md-9">
                    <div class="title">
                        Join the moviment
                    </div>
                    <div class="description">
                        Únete a nuestra red de ayuntamientos y fundaciones.
                    </div>
                </div>
                <div class="col-md-3 col-button">
                    <a href="" class="btn btn-white">QUIERO HACER MATCH</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Impact data -->

    <div class="fluid-container data-container" >
        <div class="container">
            <div class="impact-title">
                <?= $this->text('home-advantages-impact-data-title') ?>
            </div>
            <div class="row impact-data">
                <div class="col-md-2 col-md-offset-3 item">
                    <?= amount_format($this->stats->getMatchfundingRaised(), 0, false) ?>
                    <div class="description">
                        <?= $this->text('home-adventages-impact-data-matchfunding-raised') ?>
                    </div>
                </div>
                <div class="col-md-2 item">
                     <?= amount_format($this->stats->getMatchfundingSucessfulPercentage(), 0, true).'%' ?>
                    <div class="description">
                        <?= $this->text('home-adventages-impact-data-success-projects-matchfunding') ?>
                    </div>
                </div>
                <div class="col-md-2 item">
                    --
                    <div class="description">
                        Género
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>