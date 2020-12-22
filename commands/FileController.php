<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\FileScanner;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class FileController extends Controller
{

    /**
     * This command echoes what you have entered as the message.
     *
     * @return int Exit code
     */
    public function actionScan()
    {
        /** @var FileScanner $scannerComponent */
        $scannerComponent = Yii::$app->fileScanner;

        echo print_r($scannerComponent->findAllPhysicalFiles(), 1);

        return ExitCode::OK;
    }


}
