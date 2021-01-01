<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\FileScanner;
use app\models\Storage;
use Exception;
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

        $count = $scannerComponent->saveNewFiles();

        echo "FileScanner: Found " . $count . " new files." . PHP_EOL;
        return ExitCode::OK;
    }


    public function actionAnalyze()
    {
        foreach (Storage::find()->all() as $storage) {
            foreach ($storage->getFiles()->all() as $file) {
                try {
                    $file->analyze();
                    echo "FileAnalyzer: Analyzed `" . $file->getFileName() . "`" . PHP_EOL;
                } catch (Exception $e) {
                    echo PHP_EOL . "FileAnalyzer: Error while analyzing `" . $file->absolutePath . "`" . PHP_EOL;
                    echo $e->getMessage() . PHP_EOL;
                    echo $e->getTraceAsString() . PHP_EOL . PHP_EOL;
                }
            }
        }

        return ExitCode::OK;
    }

}
