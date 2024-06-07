<?php

use Bitrix\Iblock\PropertyTable;
//todo делаем ссылку на наш класс
use ProjectNamespace\SectionLinkPropertiesTable;

$sectionId = '';
$allProperty = [];
//todo собираем коды св-тв для группированной выборки значений св-тв у элементов
$arGroup = [];

//todo производим выборку из таблицы b_iblock_section_property наших id свойств которые мы выбрали для раздела,
//todo runtime - join выборка из таблицы b_iblock_property, там лежит полное описание св-тв

//todo сюда передать id раздела у которого мы делаем выборку св-тв, SECTION_ID
    //todo для выборки всех полей таблицы b_iblock_property, раскоментировать 'ALL_' => 'PROP'

$rsData = SectionLinkPropertiesTable::getList([
    'filter' => [
        'SECTION_ID' => $sectionId,
        'SMART_FILTER' => 'Y'
    ],
    'select' => [
        'PROPERTY_ID',
        'NAME' => 'PROP.NAME',
        'CODE' => 'PROP.CODE',
        'PROPERTY_TYPE' => 'PROP.PROPERTY_TYPE',
        'SORT' => 'PROP.SORT',
        // 'ALL_' => 'PROP'
    ],
    'order' => [
        'SORT' => 'ASC'
    ],
    'runtime' => [
        'PROP' => [
            'data_type' => 'Bitrix\Iblock\PropertyTable',
            'reference' => [
                'this.PROPERTY_ID' => 'ref.ID',
            ],
        ],
    ],
]);

while ($res = $rsData->fetch()) {
    $allProperty[$res['CODE']] = $res;
    $arGroup[] =  'PROPERTY_' . $res['CODE'];
}



if ($allProperty && $arGroup) {
    
    //todo производим значения для наших св-тв, передаем $arGroup с кодами св-тв и $sectionId
    $valueProps = CIBlockElement::GetList(
        [
            'SORT' => 'ASC'
        ],
        [
            'IBLOCK_ID' => MAIN_CATALOG_ID,
            'SECTION_ID' => $sectionId
        ],
        $arGroup,
        false,
        false
    );

    //todo мы получаем группированные массивы со значениями св-тв, тут мы производим проверку на пустые значения и складываем значения в $allProperty['value']
    while ($res = $valueProps->Fetch()) {
        foreach ($res as $key => $item) {   // производим итерацию по массиву со св-ми
            if (mb_substr($key, 0, 8) == 'PROPERTY') {  // в массив попадают CNT поле которое нам не нужно, делаем проверку что это св-во
                $propCode = str_replace(['PROPERTY_', '_VALUE'], '', $key); // забираем код св-ва, из ключа
                if (isset($allProperty[strtoupper($propCode)])) {  //проверка 
                    if (!isset($allProperty[strtoupper($propCode)]['VALUES'])) {
                        $allProperty[strtoupper($propCode)]['VALUES'] = [];
                    }
                    if (isset($item) && !in_array($item, $allProperty[strtoupper($propCode)]['VALUES'])) {
                        $allProperty[strtoupper($propCode)]['VALUES'][] = $item;
                    }
                }
            }
        }
    }
}

include 'filter_file.php';