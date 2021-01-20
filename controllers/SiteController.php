<?php

namespace app\controllers;

use app\components\FileShelfController;
use app\models\form\ContactForm;
use app\models\form\LoginForm;
use Yii;
use yii\web\Response;

/**
 * Controller to handle all common actions related to the application frontend
 *
 * @package app\controllers
 * @see     \app\components\View
 */
class SiteController extends FileShelfController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
    {
        $behaviors = parent::behaviors();

        $behaviors['accessControl']['only'] = ['logout'];
        $behaviors['accessControl']['rules'] = [
            [
                'actions' => ['logout'],
                'allow'   => true,
                'roles'   => ['@'],
            ],
        ];
        $behaviors['verbs']['actions'] = [
            'logout' => ['post'],
        ];

        return $behaviors;
    }


    /**
     * Renders the homepage
     *
     * @return string
     */
    public function actionIndex() : string
    {
        return $this->render('index');
    }


    /**
     * Login action
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = self::LAYOUT_EMPTY;
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() : Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() : string
    {
        return $this->render('about');
    }
}
