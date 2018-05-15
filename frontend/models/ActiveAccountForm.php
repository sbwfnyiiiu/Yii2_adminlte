<?php
namespace frontend\models;

use yii\base\Model;
use yii\base\UserException;
use common\models\User;

/**
 * Active account form
 */
class ActiveAccountForm extends Model
{
    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('帐号激活令牌不能为空.');
        }
        $this->_user = User::findByActiveAccountToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('帐号激活令牌错误.');
        }
        // //判断$token的时效性1小时内有效
        // $oldtimestamp = substr($token,-10); //获取生成的时间戳
        // if(time()-$oldtimestamp > 900){
        //     throw new UserException('重置密码令牌已过有效期.');
        // }
        parent::__construct($config);
    }


    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function activeAccount()
    {
        $user = $this->_user;
        $user->removeActiveToken();
        $user->status=10;
        return $user->save(false);
    }
}
