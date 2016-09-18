<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '个人相册';
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('修改用户', ['/user/admin/update', 'id' => $user->id], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <?php
                $category = [
                    ['id' => 1, 'name' => '身份证'],
                    ['id' => 2, 'name' => '结婚证'],
                ];
                $items = array_map(function($value) use($cid) {
                    return [
                        'label' => $value['name'],
                        'url' => \yii\helpers\Url::current(['cid' => $value['id']]),
                        'active' => $value['id'] == $cid
                    ];
                }, $category);
                ?>
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked',
                    ],
                    'items' => $items
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-solid">
            <div class="box-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
