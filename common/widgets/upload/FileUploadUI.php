<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/9/13
 * Time: 上午9:31
 */

namespace common\widgets\upload;

use dosamigos\fileupload\BaseUpload;
use ReflectionClass;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class FileUploadUI extends \dosamigos\fileupload\FileUploadUI
{
    public $multiple = true;

    public function init()
    {
        if ($this->hasModel()) {
            $this->name = $this->name ?: Html::getInputName($this->model, $this->attribute);
        }
        if (! array_key_exists('fileparam', $this->url)) {
            $this->url['fileparam'] = $this->name;//服务器需要通过这个判断是哪一个input name上传的
        }
        $this->clientOptions['name'] = $this->name;
        BaseUpload::init();
        $this->fieldOptions['multiple'] = $this->multiple;
        $this->fieldOptions['id'] = ArrayHelper::getValue($this->options, 'id');

        $this->options['id'] .= '-fileupload';
        $this->options['data-upload-template-id'] = $this->uploadTemplateId ? : 'template-upload';
        $this->options['data-download-template-id'] = $this->downloadTemplateId ? : 'template-download';
        $this->clientOptions = ArrayHelper::merge($this->clientOptions, [
            'name'=> $this->name, //主要用于上传后返回的项目name
            'files' => $this->value?:[]
        ]);
        $this->view->registerCss(<<<css
    .files .preview img{max-width: 80px;max-height: 60px;}
css
);

    }
    public function run()
    {
        $value = Html::getAttributeValue($this->model, $this->attribute);
        $attachments = $this->multiple == true ? $value :[$value];
        $this->value = [];
        if ($attachments) {
            foreach ($attachments as $attachment) {
                if ($attachment) {
                    $this->value[] = $attachment;
                }
            }
        }
        echo $this->render($this->uploadTemplateView);
        echo $this->render($this->downloadTemplateView);
        echo $this->render($this->formView, [
            'files' => $this->value
        ]);

        if ($this->gallery) {
            echo $this->render($this->galleryTemplateView);
        }

        $this->registerClientScript();
    }
}