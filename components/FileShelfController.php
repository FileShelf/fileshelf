<?php

namespace app\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class FileShelfController extends Controller
{

    public const LAYOUT_MAIN = 'main';
    public const LAYOUT_EMPTY = 'empty';


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'accessControl' => [
                'class' => AccessControl::class,
                'only'  => [],
                'rules' => [],
            ],
            'verbs'         => [
                'class'   => VerbFilter::class,
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
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
