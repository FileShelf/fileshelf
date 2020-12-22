<?php

namespace app\components;

use app\models\File;
use app\models\Storage;
use yii\base\Component;
use yii\helpers\FileHelper;

class FileScanner extends Component
{

    public function saveNewFiles(Storage $inStorage = null)
    {
        $storageFiles = $this->findAllPhysicalFiles($inStorage);

        foreach ($storageFiles as $storageId => $files) {
            foreach ($files as $file) {
                if (File::findByChecksum(sha1_file($file)) === null) {
                    $newFile = new File();
                    $newFile->storage_id = $storageId;
                    $newFile->setFile($file);
                    $newFile->save();
                }
            }
        }
    }


    /**
     * Find physical files in the given storage or all storages
     *
     * @param \app\models\Storage|null $inStorage
     * @return array
     */
    public function findAllPhysicalFiles(Storage $inStorage = null) : array
    {
        $fileList = [];
        $storages = $inStorage == null ? Storage::find()->all() : [$inStorage];

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
