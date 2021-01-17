<?php

namespace app\tests\unit\models;

use app\models\User;
use app\tests\unit\fixtures\UserFixture;
use Codeception\Test\Unit;
use UnitTester;
use Yii;

class UserTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;


    public function _fixtures() : array
    {
        return [
            'users' => [
                'class' => UserFixture::class,
            ],
        ];
    }


    public function testFindUserById() : void
    {
        /** @var User $fixtureUser */
        $fixtureUser = $this->tester->grabFixture('users', 'user2');
        $user = User::findIdentity(3);

        $this->tester->assertNotNull($user);
        expect($user->name)->equals($fixtureUser->name);

        expect_not(User::findIdentity(999));
    }


    /**
     * @depends testFindUserById
     */
    public function testHasDefaultUsers() : void
    {
        $systemUser = User::findIdentity(1);

        $this->tester->assertNotNull($systemUser);
        expect($systemUser->name)->equals('system');
        expect($systemUser->email)->null();
        expect($systemUser->is_deletable)->equals(0);
        expect($systemUser->created_at)->equals(0);
        expect($systemUser->created_by)->equals(1);

        $adminUser = User::findIdentity(2);

        $this->tester->assertNotNull($adminUser);
        expect($adminUser->name)->equals('admin');
        expect($adminUser->email)->null();
        expect($adminUser->is_deletable)->equals(0);
        expect($adminUser->created_at)->equals(0);
        expect($adminUser->created_by)->equals(1);
        expect(Yii::$app->getSecurity()->validatePassword('admin', $adminUser->password_hash))->true();
    }


    public function testFindUserByAccessToken() : void
    {
        /** @var User $fixtureUser */
        $fixtureUser = $this->tester->grabFixture('users', 'user3');
        $user = User::findIdentityByAccessToken($fixtureUser->access_token);

        $this->tester->assertNotNull($user);
        expect($user->access_token)->equals($fixtureUser->access_token);
        expect($user->name)->equals($fixtureUser->name);

        expect_not(User::findIdentityByAccessToken('non-existing'));
    }


    public function testFindUserByUsername() : void
    {
        /** @var User $fixtureUser */
        $fixtureUser = $this->tester->grabFixture('users', 'user4');
        $user = User::findByName($fixtureUser->name);

        $this->tester->assertNotNull($user);
        expect($user->name)->equals($fixtureUser->name);

        expect_not(User::findByName('not-a-user'));
    }


    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser() : void
    {
        $userIndex = 5;

        /** @var User $fixtureUser */
        $fixtureUser = $this->tester->grabFixture('users', 'user' . $userIndex);
        $user = User::findByName($fixtureUser->name);

        expect_that($user->validateAuthKey($fixtureUser->auth_key));
        expect_not($user->validateAuthKey('test100key'));

        expect_that($user->validatePassword('password_' . $userIndex));
        expect_not($user->validatePassword('123456'));
    }

}
