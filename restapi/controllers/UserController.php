<?php
namespace restapi\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use Yii;
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    //Checks the privilege of the current user.
    public function checkAccess($action, $model = null, $params = [])
    {
        // check if the user can access $action and $model
        // throw ForbiddenHttpException if access should be denied
        $action = '/restapi/user/'.$action;
        if(Yii::$app->user->can($action)){
            
        }else{
            throw new \yii\web\ForbiddenHttpException(sprintf('您无权进行该操作！', $action));
        }
    }
}