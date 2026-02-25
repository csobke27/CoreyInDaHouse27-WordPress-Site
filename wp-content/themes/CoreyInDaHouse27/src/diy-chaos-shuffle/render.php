<?php

$perks = new WP_Query(
    array(
        'post_type' => 'dbd_perks',
        'posts_per_page' => 4,
        'orderby' => 'rand',
        'meta_query' => array(
          array(
            'key' => 'survivor_name',
            'compare' => 'NOT IN',
            'value' => array('Ace Viscont')
          )
          )
        )
    );

$survivorList = getSurvivorList();
$killerList = getKillerList();

$survivorData = array();
if (is_wp_error($survivorList)) {
  $survivorData = array('choices' => array());
} elseif ($survivorList instanceof WP_REST_Response) {
  $survivorData = $survivorList->get_data();
} elseif (is_array($survivorList)) {
  $survivorData = $survivorList;
}

$killerData = array();
if (is_wp_error($killerList)) {
  $killerData = array('choices' => array());
} elseif ($killerList instanceof WP_REST_Response) {
  $killerData = $killerList->get_data();
} elseif (is_array($killerList)) {
  $killerData = $killerList;
}

$context = [
  'survivorList' => $survivorData,
  'killerList' => $killerData
];
// echo print_r($perks, true);
?>

<div class="dbd-container" style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/dbd-forest-background.jpg);">
  <div class="container" id="chaosShuffleApp">
    <div class="row justify-content-center">
      <h1 class="dbd-header header-outline">DIY Chaos Shuffle</h1>
      <div class="col-12 chaos-form-container">
        <div>Use this form to customize your game experience:</div>
        <br>
        <div><strong>Survivors:</strong> click "Add Survivor" to add up to 4 survivors. For each survivor, you can select which survivors they own and which they do not own. Any perks tied to an unowned survivor will be excluded from the shuffle.</div>
        <div><strong>Killers:</strong> click "Add Killer" to add a killer. You can select which killers they own and which they do not own. Any perks tied to an unowned killer will be excluded from the shuffle.</div>
        <br>
        <div>Once you've selected your survivors and killers, click "Generate Perks" to see a random selection of perks based on your owned/unowned selections.</div>
        <form id="chaosShuffleForm" method="get" action="" data-wp-interactive="survivor-template" data-wp-context='<?php echo json_encode($context); ?>'>
          <div class="row button-row">
            <div class="col-sm-6 text-center">
              <button type="button" class="btn" id="addSurvivorBtn" data-wp-on--click='actions.addSurvivor'>Add Survivor</button>
            </div>
            <div class="col-sm-6 text-center">
              <button type="button" class="btn" id="addKillerBtn" data-wp-on--click='actions.addKiller'>Add Killer</button>
            </div>
          </div>
          <div class="survivor-options-container">
            <!-- Survivor options will be dynamically added here -->
          </div>
          <div class="killer-options-container">
            <!-- Killer options will be dynamically added here -->
          </div>
          <div class="row">
            <div class="col-12 text-center">
              <button type="button" class="btn btn-primary" id="generatePerksBtn" data-wp-on--click='actions.generatePerks'>Generate Perks</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="dbd-results-container">
    </div>
</div>

<template id="perk-container-template">
  <div class="row justify-content-center perk-row">
    <div class="col-12 text-center">
        <h2 class="dbd-player-name">Name goes here:</h2>
        <div class="perks-container">
          <!-- Perk cards will be dynamically added here -->
        </div>
    </div>
    <div class="col-12 perk-description-container">
      <div class="collapse" id="perkDescriptionCollapse">
        <div class="card card-body dbd-card-body">
          <strong><div class="perk-header">Perk title goes here</div></strong>
          <div class="perk-character">Character association goes here</div>
          <div class="perk-description">Perk description goes here</div>
        </div>
      </div>
    </div>
  </div>
</template>

<template id="perk-card-template">
  <a class="perk-card" data-toggle="collapse" href="" role="button" aria-expanded="false" aria-controls="">
    <img class="perk-icon" src="" alt="" />
    <br>
    <span class="perk-title"></span>
  </a>
</template>

<!-- survivor template -->
<template id="survivor-template">
  <div class="row survivor-player-row">
    <div class="col-12 text-center survivor-player-name">
      <h4 class="player-number"></h4>
    </div>
    <div class="col-sm-6 owned-survivors-container">
      <h5>Owned Survivors:</h5>
      <ul class="owned-survivors-list">
        <!-- Owned survivors checkboxes will be added here -->
      </ul>
    </div>
    <div class="col-sm-6 unowned-survivors-container">
      <h5>Unowned Survivors:</h5>
      <ul class="unowned-survivors-list">
          <!-- Unowned survivors checkboxes will be added here -->
      </ul>
    </div>
    <div class="col-12 text-center">
      <button type="button" class="btn btn-sm btn-danger remove-survivor-btn">Remove</button>
    </div>
  </div>
</template>

<!-- killer template -->
<template id="killer-template">
  <div class="row killer-player-row">
    <div class="col-12 text-center killer-player-name">
      <h4 class="player-number"></h4>
    </div>
    <div class="col-sm-6 owned-killers-container">
      <h5>Owned Killers:</h5>
      <ul class="owned-killers-list">
        <!-- Owned killers checkboxes will be added here -->
      </ul>
    </div>
    <div class="col-sm-6 unowned-killers-container">
      <h5>Unowned Killers:</h5>
      <ul class="unowned-killers-list">
          <!-- Unowned killers checkboxes will be added here -->
      </ul>
    </div>
    <div class="col-12 text-center">
      <button type="button" class="btn btn-sm btn-danger remove-killer-btn">Remove</button>
    </div>
  </div>
</template>