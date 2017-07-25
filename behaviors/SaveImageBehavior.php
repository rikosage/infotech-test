<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Поведение для удобного сохранения изображений в модели.
 */
class SaveImageBehavior extends Behavior
{

    /**
     * Аттрибут, в котором хранится имя файла изображения
     * @var string
     */
    public $attribute;

    /**
     * Аттрибут формы, из которой происходит загрузка
     * @var string
     */
    public $imageAttribute;

    /**
     * Папка с изображениями. Может быть путем, без / в начале и конце
     * @var string
     */
    public $folder = "uploads";

    /**
     * Инстанс загруженного файла
     * @var \yii\web\UploadedFile
     */
    private $file;

    /**
     * @inheritDoc
     */
    public function events() : array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'saveImageFile',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'saveImageFile',
        ];
    }

    /**
     * Получить имя класса без неймспейса.
     * @return string
     */
    protected function getShortOwnerClassName() : string
    {
      return (new \ReflectionClass($this->owner::className()))->getShortName();
    }

    /**
     * Сгенерировать имя файла. Итоговое значение будет ИмяМодели-случайная_строка.расширение
     * @return string
     */
    protected function generateFileName() : string
    {
        $className = strtolower($this->getShortOwnerClassName());
        return sprintf("%s.%s", uniqid("$className-"), $this->file->extension);
    }

    /**
     * Сохраняет изображение в папку и назначает значение переданной модели.
     * @return bool TRUE, если сохранение успешно
     */
    public function saveImageFile() : bool
    {
        $this->file = UploadedFile::getInstance($this->owner, $this->imageAttribute);
        if (!$this->file) {
            $this->owner->image = NULL;
            return false;
        }
        $filename = $this->generateFileName();
        $this->owner->{$this->attribute} = $filename;

        // Если не получилось сохранить - возвращаем false
        try {
            $this->file->saveAs(vsprintf("%s/%s/%s", [
                Yii::getAlias('@app/web/' . $this->folder),
                strtolower($this->getShortOwnerClassName()),
                $filename,
            ]));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Получить путь по файла изображения
     * @return string URL
     */
    public function getImagePath() : string
    {
        return vsprintf("/%s/%s/%s", [
            $this->folder,
            strtolower($this->getShortOwnerClassName()),
            $this->owner->{$this->attribute}
        ]);
    }
}
