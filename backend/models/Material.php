<?php

namespace backend\models;

use Yii;
use crazyfd\qiniu\Qiniu;
/**
 * This is the model class for table "material".
 *
 * @property int $id
 * @property int $uid Upload user id
 * @property string $name
 * @property string $url Qiniu return hyper link
 * @property int $format Material format
 0-apk
 1-jpg
 2-png
 3-zip
 4-mp4
 5-pdf
 6-excel(x)
 7-word(x)
 8-ppt(x)
 * @property int $created_at Upload timestamp
 */
class Material extends \yii\db\ActiveRecord
{
    public $uploadFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'created_at'], 'integer','on' => 'addNew'],
            [['uid','name', 'url', 'format','created_at'], 'required','on' => 'addNew'],
            [['name'], 'string', 'max' => 255,'on' => 'addNew'],
            [['url'], 'string', 'max' => 512,'on' => 'addNew'],
            [['uploadFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'apk, jpg, jpeg, png, zip, mp4, mpg, pdf, excel, excelx, word, wordx, ppt, pptx','on' => 'upload'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '素材ID',
            'uid' => '上传者',
            'name' => '名称',
            'url' => '链接',
            'format' => '格式',
            'created_at' => '上传日期',
        ];
    }

    /**
     * 七牛云存储
     */
    public function upload($temp,$timeStampName)
    {
        if($this->validate()){
            $qiniu = new Qiniu(Yii::$app->params['qiniu']['ak'], Yii::$app->params['qiniu']['sk'],Yii::$app->params['qiniu']['domain'], Yii::$app->params['qiniu']['bucket'],Yii::$app->params['qiniu']['zone']);
            $qiniu->uploadFile($temp,$timeStampName);
            $url = $qiniu->getLink($timeStampName);
            return $url;
        }else{
            return false;
        }
    }

    public function deleteQiniu($key)
    {
        $qiniu = new Qiniu(Yii::$app->params['qiniu']['ak'], Yii::$app->params['qiniu']['sk'],Yii::$app->params['qiniu']['domain'], Yii::$app->params['qiniu']['bucket'],Yii::$app->params['qiniu']['zone']);
        $res = $qiniu->delete($key,Yii::$app->params['qiniu']['bucket']);
        return $res;
    }
    /**
     * {@inheritdoc}
     * @return MaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaterialQuery(get_called_class());
    }
}
