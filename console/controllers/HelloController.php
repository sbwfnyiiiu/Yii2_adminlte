<?php
namespace console\controllers;

use yii\console\Controller;
use yii\console\widgets\Table;
class HelloController extends Controller
{
    public $message;
    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    
    public function actionIndex()
    {
        echo Table::widget([
            'headers' => ['Project', 'Status', 'Participant'],
            'rows' => [
                ['Yii', 'OK', '@samdark'],
                ['Yii', 'OK', '@cebe'],
            ],
        ]);
    }
}