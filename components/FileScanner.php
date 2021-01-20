<?php

namespace app\components;

use app\models\File;
use app\models\Storage;
use yii\base\Component;
use yii\helpers\FileHelper;

/**
 * Scans for files in the file system
 *
 * @package app\components
 */
class FileScanner extends Component
{

    /**
     * Saves all physical files that have been found in the given storage or all storages
     *
     * To prevent duplicates, only files which checksum does not exist in the DB yet get saved.
     *
     * @param \app\models\Storage|null $inStorage
     * @return int
     */
    public function saveNewFiles(Storage $inStorage = null) : int
    {
        $newFileCount = 0;
        $storageFiles = $this->findAllPhysicalFiles($inStorage);

        foreach ($storageFiles as $storageId => $files) {
            foreach ($files as $file) {

                $checksum = sha1_file($file);

                if (File::findByChecksum($checksum) === null) {
                    $newFile = new File();
                    $newFile->storage_id = $storageId;
                    $newFile->setFile($file);
                    $newFile->sha1_checksum = $checksum;

                    if (!$newFile->save()) {
                        echo implode("\n", $newFile->getErrorSummary(true)) . "\n";
                    }

                    $newFileCount++;
                }
            }
        }

        return $newFileCount;
    }


    /**
     * Find all physical files in the given storage or all storages
     *
     * @param \app\models\Storage|null $inStorage
     * @return array
     */
    public function findAllPhysicalFiles(Storage $inStorage = null) : array
    {
        $fileList = [];
        $storages = $inStorage === null ? Storage::find()->all() : [$inStorage];

        foreach ($storages as $storage) {
            $files = FileHelper::findFiles($storage->path, [
                'only'          => $storage->storageType->getFormatList(),
                'caseSensitive' => false,
                'recursive'     => true,
            ]);

            foreach ($files as $file) {
                $fileList[$storage->id][] = $file;
            }
        }

        return $fileList;
    }
}
