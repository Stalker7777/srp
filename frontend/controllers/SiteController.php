<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;
use frontend\models\search\OrdersSearch;

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
                'only' => ['logout'],
                'rules' => [
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['loginsignup']);
        }
    
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['orders']);
        }
        
        return $this->render('index');
    }
    
    /**
     * @param bool $is_login
     * @return string|\yii\web\Response
     */
    public function actionLoginsignup($is_login = true)
    {
        $login = new LoginForm();
        $signup = new SignupForm();
    
        if ($login->load(Yii::$app->request->post())) {
            if($login->login()) {
                if(time() > $login->getPeriod()) {
                    Yii::$app->user->logout();
                    Yii::$app->session->setFlash('error', 'Необходимо сменить пароль!');
                    return $this->redirect(['/site/loginsignup', 'is_login' => true]);
                }
                else {
                    return $this->goHome();
                }
            }
            else {
                return $this->redirect(['/site/loginsignup', 'is_login' => false]);
            }
        }
    
        if ($signup->load(Yii::$app->request->post())) {
            if($result = $signup->signup()) {
                if($result['create_user']) {
                    Yii::$app->session->setFlash('success', 'Ваш код ' . $signup->password);
                    return $this->redirect(['/site/loginsignup', 'is_login' => true]);
                }
                else {
                    Yii::$app->session->setFlash('success', 'Вы зарегистированы, можете войти!');
                    return $this->redirect(['/site/loginsignup', 'is_login' => true]);
                }
            }
        }
    
        return $this->render('loginsignup', [
            'login' => $login,
            'signup' => $signup,
            'is_login' => $is_login,
        ]);
    }

    public function actionOrders()
    {
        //Yii::$app->getUser()->getId();
        
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('orders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

}
