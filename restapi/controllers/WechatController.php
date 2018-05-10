<?php
namespace restapi\controllers;
use yii\web\Controller;
/**
 * WeChat controller
 */
class WechatController extends Controller
{
     //微信服务接入时，服务器需授权验证
     public function actionValid()
     {
         $echoStr = $_GET["echostr"];
         $signature = $_GET["signature"];
         $timestamp = $_GET["timestamp"];
         $nonce = $_GET["nonce"];
         //valid signature , option
         echo $echoStr;

     }
}
