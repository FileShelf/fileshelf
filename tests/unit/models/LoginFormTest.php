<?php

namespace tests\unit\models;

use app\models\form\LoginForm;
use Codeception\Test\Unit;
use Yii;

class LoginFormTest extends Unit
{

    private $model;


    public function testLoginNoUser() : void
    {
        $this->model = new LoginForm([
            'userName' => 'not_existing_userName',
            'password' => 'not_existing_password',
        ]);

        expect_not($this->model->login());
        expect_that(Yii::$app->user->isGuest);
    }


    public function testLoginWrongPassword() : void
    {
        $this->model = new LoginForm([
            'userName' => 'admin',
            'password' => 'wrong_password',
        ]);

        expect_not($this->model->login());
        expect_that(Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('password');
    }


    public function testLoginCorrect() : void
    {
        $this->model = new LoginForm([
            'userName' => 'admin',
            'password' => 'admin',
        ]);

        $success = $this->model->login();
        expect_that($success);
        expect_not(Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('password');
    }


    protected function _after() : void
    {
        Yii::$app->user->logout();
    }

}
