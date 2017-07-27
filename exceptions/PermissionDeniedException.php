<?php

namespace app\exceptions;

class PermissionDeniedException extends \yii\base\Exception
{
    public function getName()
    {
        return "Permission denied";
    }
}
