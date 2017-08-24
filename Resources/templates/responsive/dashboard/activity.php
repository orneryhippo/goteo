<?php $this->layout('dashboard/layout') ?>

<?php $this->section('dashboard-content') ?>
<?php
/*
<div class="dashboard-content">

    <div class="inner-container">
        <?= $this->raw('message') ?>
    </div>

</div>
*/
?>
<div class="dashboard-content">
  <div class="inner-container">
    <div class="projects-container" id="projects-support-container">
        <h2><?= $this->text('profile-invest_on-header') ?></h2>
        <?= $this->insert('dashboard/partials/projects_interests', [
            'projects' => $this->invested,
            'total' => $this->invested_total,
            'interests' => null,
            'auto_update' => '/dashboard/ajax/projects/invested',
            'limit' => $this->limit
            ]) ?>
    </div>
  </div>
</div>

<div class="dashboard-content cyan">
  <div class="inner-container">
    <div class="projects-container" id="projects-interests-container">
        <h2><?= $this->text('profile-suggest-projects-interest') ?></h2>
        <?= $this->insert('dashboard/partials/projects_interests', [
            'projects' => $this->favourite,
            'total' => $this->favourite_total,
            'interests' => $this->interests,
            'auto_update' => '/dashboard/ajax/projects/interests',
            'limit' => $this->limit
            ]) ?>
    </div>

  </div>
</div>

<?php $this->replace() ?>
