<?php

//todo класс для работы с таблицей b_iblock_section_property, производит выборку id св-тв
//todo имя нашего namespace делаем по названию проекта
namespace ProjectNamespace;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\ORM\Fields;

class SectionLinkPropertiesTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_iblock_section_property';
    }

    public static function getMap()
    {
        return [
            'SECTION_ID' => new Fields\StringField('SECTION_ID', [
                'primary' => true,
            ]),
            'PROPERTY_ID' => new Fields\StringField('PROPERTY_ID'),
            'DISPLAY_TYPE' => new Fields\StringField('DISPLAY_TYPE'),
            'SMART_FILTER' => new Fields\BooleanField('SMART_FILTER'),
        ];
    }
}