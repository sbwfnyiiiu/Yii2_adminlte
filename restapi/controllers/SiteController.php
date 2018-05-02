<?php
namespace restapi\controllers;

use yii\rest\ActiveController;
use restapi\models\ApiLoginForm;


/**
 * Site controller
 */
class SiteController extends ActiveController
{
   public $modelClass = 'common\models\User';

   public function actionLogin()
   {
       $model = new ApiLoginForm();
       $model->username = $_POST['username'];
       $model->password = $_POST['password'];

       if($model->login()){
            return ['access_token' => $model->login()];
       }else{
           $model->validate();
           return $model;
       }
   }
}
