<?php

namespace application\models;


/**
 * Базовая клиентская модель
 *
 */
class BaseExampleModel extends \ItForFree\SimpleMVC\MVC\Model
{
    
    public function likesUpper($id,$tableName)
    {
        $modelData = $this->getById($id, $tableName);
        $modelData->likes++;
        $modelData->update();
    }
    
    public function getModelLikes($id, $tableName) //метод не узнаёт какая именно модель
    {
        $modelData = $this->getById($id, $tableName);
        return $modelData->likes;
    }
}
