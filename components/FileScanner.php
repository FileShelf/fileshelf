<?php

namespace app\components;

use app\models\Storage;
use yii\base\Component;
use yii\helpers\FileHelper;

class FileScanner extends Component
{

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
