<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Setting;
use kartik\form\ActiveForm;
// use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\switchinput\SwitchInput;
use app\modules\admin\models\WebSetting;

// var_dump($paypal_setting);exit;
/* @var $this yii\web\View */
/* @var $model app\models\Setting */

$this->title = Yii::t('app', 'Dispatch Settings');
$this->params['header'] = Yii::t('app', 'Settings');
$this->params['description'] = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['dispatch']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
  .file-loading:before {
    display: none
  }

  body {
    padding: 1rem;
    color: hsla(215, 5%, 50%, 1);
  }

  h1 {
    color: hsla(215, 5%, 10%, 1);
    margin-bottom: 2rem;
  }

  section {
    display: flex;
    flex-flow: row wrap;
  }

  section>div {
    flex: 1;
    padding: 0.5rem;
  }

  input[type="radio"] {
    display: none;

    &:not(:disabled)~label {
      cursor: pointer;
    }

    &:disabled~label {
      color: hsla(150, 5%, 75%, 1);
      border-color: hsla(150, 5%, 75%, 1);
      box-shadow: none;
      cursor: not-allowed;
    }
  }

  label {
    height: 100%;
    display: block;
    background: white;
    border: 2px solid hsla(150, 75%, 50%, 1);
    border-radius: 20px;
    padding: 1rem;
    margin-bottom: 1rem;
    //margin: 1rem;
    text-align: center;
    box-shadow: 0px 3px 10px -2px hsla(150, 5%, 65%, 0.5);
    position: relative;
  }

  input[type="radio"]:checked+label {
    background: hsla(150, 75%, 50%, 1);
    color: hsla(215, 0%, 100%, 1);
    box-shadow: 0px 0px 20px hsla(150, 100%, 50%, 0.75);

    &::after {
      color: hsla(215, 5%, 25%, 1);
      font-family: FontAwesome;
      border: 2px solid hsla(150, 75%, 45%, 1);
      content: "\f00c";
      font-size: 24px;
      position: absolute;
      top: -25px;
      left: 50%;
      transform: translateX(-50%);
      height: 50px;
      width: 50px;
      line-height: 50px;
      text-align: center;
      border-radius: 50%;
      background: white;
      box-shadow: 0px 2px 5px -2px hsla(0, 0%, 0%, 0.25);
    }
  }

  input[type="radio"]#control_05:checked+label {
    background: red;
    border-color: red;
  }

  p {
    font-weight: 900;
  }


  @media only screen and (max-width: 700px) {
    section {
      flex-direction: column;
    }
  }
</style>
<div class="setting-create">

  <div class="card">

    <div class="card-body">

      <p class="card-text">Enable this option to automatically assign Task to your Agent. You can select the assignment logic that best suits your business needs.</p>
    </div>
  </div>

  <div class="card" id="auto-allocate">

    <div class="card-body">

      <h2>Select a method to auto-allocate the tasks&hellip;</h2>
      <section>
        <?php
        $setting = new WebSetting();
        $auto_dispatch_type = $setting->getSettingBykey('auto_dispatch_type');
        if ($auto_dispatch_type) {
        }
        ?>


        <div>
          <input type="radio" id="cms_b" name="WebSetting[value]" data-id="29" value="2" <?php if ($auto_dispatch_type == 2) echo 'checked="checked"'; ?>>
          <label for="cms_b">
            <h2>Send to All</h2>
            <img class="card-img-top" src="https://app.tookanapp.com/v2/en/assets/images/send-to-all@2x.png" alt="">
          </label>
        </div>
        <div>
          <input type="radio" id="cms_c" name="WebSetting[value]" data-id="29" value="3" <?php if ($auto_dispatch_type == 3) echo 'checked="checked"'; ?>>
          <label for="cms_c">
            <h2>Nearest Available</h2>
            <img class="card-img-top" src="https://app.tookanapp.com/v2/en/assets/images/nearest-available@2x.png" alt="">
          </label>
        </div>


      </section>





    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <?php
    // var_dump($others);exit;

    $form = ActiveForm::begin(); ?>
    <div class="row">
      <?php foreach ($others as $setting) {
        if ($setting->setting_key == 'enable_auto_dispatch' || $setting->setting_key == 'auto_dispatch_type') {

          echo $form->field($setting, 'setting_id')->hiddenInput(['maxlength' => false])->label(false);
        } else { ?>
          <div class="col-md-6">
            <?= $form->field($setting, 'setting_id')->hiddenInput(['maxlength' => true])->label(false) ?>
            <h6><?= $setting->name ?></h6>
            <?= $form->field($setting, 'value')->textInput(['id' => 'cms_' . $setting->setting_id, 'data-id' => $setting->setting_id])->label(false) ?>
          </div>
        <?php  }
        ?>

      <?php } ?>
    </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  $(document).on('change', 'input[id^=cms_]', function() {
    var id = $(this).attr('data-id');
    var value = $(this).val();
    // alert($(this).val());
    $.ajax({
      type: "GET",
      url: "<?= Url::toRoute(['web-setting/save-cms']) ?>",
      data: {
        id: id,
        value: value
      },
      cache: false,
      success: function(data) {
        swal("Good job!", "Settings Saved!", "success");
      }
    });
  });
</script>
<script>
  $("#enable_auto").click(function() {
    // assumes element with id='button'
    $("#auto-allocate").toggle();
  });

  $("#enable_auto").click(function() {
    // assumes element with id='button'
    $("#auto-allocate").toggle();
  });
</script>

<script>
  $(document).on("change", 'select[id^=cms_]', function() {
    var id = $(this).attr('data-id');
    var value = $(this).val();
    $.ajax({
      type: "GET",
      url: "<?= Url::toRoute(['web-setting/save-cms']) ?>",
      data: {
        id: id,
        value: value
      },
      cache: false,
      success: function(data) {
        swal("Good job!", "Settings Saved!", "success");
      }
    });
  });
</script>