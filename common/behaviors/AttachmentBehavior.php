<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午1:26
 */

namespace common\behaviors;


use common\models\AlbumAttachment;
use common\models\Attachment;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class AttachmentBehavior extends Behavior
{
    private $_attachmentUrls;

    public static $formName = "attachmentUrls";

    public static $formLable = '图片';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }
    public function getAttachments()
    {
        return $this->owner->hasMany(Attachment::className(), ['id' => 'attachment_id'])
            ->viaTable('{{%album_attachment}}', ['album_id' => 'id']);
    }

    public function getAttachmentUrls()
    {
        if($this->_attachmentUrls === null){
            $this->_attachmentUrls = array_map(function($value){
                return $value->url;
            }, $this->owner->attachments);
        }
        return $this->_attachmentUrls;
    }

    public function afterSave()
    {
        $data = \Yii::$app->request->post($this->owner->formName());
        if(isset($data[static::$formName]) && !empty($data[static::$formName])) {
            if(!$this->owner->isNewRecord) {
                $this->beforeDelete();
            }
            $attachmentUrls = $data[static::$formName];
            foreach($attachmentUrls as $url) {
                if (empty($url)) {
                    continue;
                }
                $attachmentModel = Attachment::find()->where(['url' => $url])->one();
                $albumAttachment = new AlbumAttachment();
                $albumAttachment->album_id = $this->owner->id;
                $albumAttachment->attachment_id = $attachmentModel->id;
                $albumAttachment->save();
            }
        }
    }

    public function beforeDelete()
    {
        $pks = [];

        foreach($this->owner->attachments as $attachment){
            $pks[] = $attachment->primaryKey;
        }

        AlbumAttachment::deleteAll(['album_id' => $this->owner->id]);
    }
}