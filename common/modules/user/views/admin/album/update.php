<?php
use common\behaviors\AttachmentBehavior;
?>
<?php $this->beginContent('@common/modules/user/views/admin/album/_menu.php', ['user' => $user, 'cid' => $cid]) ?>
<?php $form = \yii\widgets\ActiveForm::begin() ?>
<?=  $form->field($model, AttachmentBehavior::$formName)->label(false)->widget(\common\widgets\upload\MultipleWidget::className(), [
    'maxNumberOfFiles' => 10
]) ?>
<?php /*= $form->field($model, AttachmentBehavior::$formName)->label(false)->widget(\common\widgets\upload\FileUploadUI::className(), [
    'url' => ['/upload/images-upload'],
])*/ ?>
<?= \yii\helpers\Html::submitButton('提交', [
    'class' => 'btn bg-maroon btn-flat btn-block'
]) ?>
<?php \yii\widgets\ActiveForm::end() ?>
<?php $this->endContent() ?>

