<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

if ($index < 2) {
    return [
        'id'            => ($index + 1),
        'name'          => $index === 0 ? 'system' : 'admin',
        'email'         => null,
        'password_hash' => $index === 0 ? null : Yii::$app->getSecurity()->generatePasswordHash('admin', 4),
        'auth_key'      => Yii::$app->getSecurity()->generateRandomString(),
        'access_token'  => Yii::$app->getSecurity()->generateRandomString(),
        'is_deletable'  => false,
        'created_at'    => 0,
        'created_by'    => 1,
    ];
}

return [
    'id'            => ($index + 1),
    'name'          => $faker->userName,
    'email'         => $faker->email,
    'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index, 4),
    'auth_key'      => Yii::$app->getSecurity()->generateRandomString(),
    'access_token'  => Yii::$app->getSecurity()->generateRandomString(),
    'created_at'    => 0,
    'created_by'    => 1,
];
