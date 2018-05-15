<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ActiveAccountForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', '<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>  谢谢，您的讯息已收到！商讨后我们将立即给予反馈。');
            } else {
                Yii::$app->session->setFlash('error', '发送提示信息时错误！！');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                //注册成功提示信息
                Yii::$app->session->setFlash('info', '账号注册成功，请您登录注册时填写的邮箱,根据邮件提示激活您的账号后方可登录。');
                //发送邮件确认账号
                $email = $user->email;
                $sendActiveEmail = Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'accountActiveToken-html', 'text' => 'accountActiveToken-text'],
                    ['user' => $user]
                )
                ->setFrom(['noreply@wuuye.com' => Yii::$app->name])
                ->setTo($email)
                ->setSubject('用户账号激活(请勿回复)')
                ->send();
                //登录邮箱激活账号
                //跳转到登录界面
                if(!$sendActiveEmail)
                {
                    Yii::$app->session->setFlash('error', '激活邮件发送失败!');
                }
                return $this->redirect('/site/login');
                // if (Yii::$app->getUser()->login($user)) {
                //     return $this->goHome();
                // }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionActiveAccount($token)
    {
        try {
            $model = new ActiveAccountForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->activeAccount())
        {
            Yii::$app->session->setFlash('success', '您的帐号已经成功激活,请登录.');
        }else{
            Yii::$app->session->setFlash('error', '您的帐号激活失败,请联系管理员.');
        }
        return $this->redirect('/site/login');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '我们已发送密码重置链接到您的邮箱，请根据指示在15分钟内完成操作。');

                // return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', '抱歉, 出现错误或技术故障，请稍后重试或联系本站服务人员。');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '密码已更新成功,请登录.');

            return $this->redirect('/site/login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
