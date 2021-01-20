<?php

namespace app\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * The main controller for the FileShelf frontend of which all others should extend
 *
 * @package app\components
 */
class FileShelfController extends Controller
{

    public const LAYOUT_MAIN = 'main';
    public const LAYOUT_EMPTY = 'empty';


    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
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
    public function actions() : array
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
