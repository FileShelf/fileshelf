<?php

namespace app\commands;

use app\components\FileScanner;
use app\models\Storage;
use Exception;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command performs File-related actions
 *
 * @package app\commands
 */
class FileController extends Controller
{

    /**
     * This command runs the file scanner
     * It scans all storages for new files and saves them to the DB
     *
     * @return int Exit code
     */
    public function actionScan() : int
    {
        /** @var FileScanner $scannerComponent */
        $scannerComponent = Yii::$app->fileScanner;

        $count = $scannerComponent->saveNewFiles();

        $this->stdout("FileScanner: Found " . $count . " new files.");
        return ExitCode::OK;
    }


    /**
     * This command runs an Analysis over all files in the DB
     *
     * @return int Exit code
     */
    public function actionAnalyze() : int
    {
        foreach (Storage::find()->all() as $storage) {
            foreach ($storage->getFiles()->all() as $file) {
                try {
                    $file->analyze();
                    $this->stdout("FileAnalyzer: Analyzed `" . $file->getFileName() . "`");
                } catch (Exception $e) {
                    $this->stderr("FileAnalyzer: Error while analyzing `" . $file->absolutePath . "`");
                    $this->stderr($e);
                }
            }
        }

        return ExitCode::OK;
    }

}
