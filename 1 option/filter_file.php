
<?php 

use Bitrix\Main\Application;
$request = Application::getInstance()->getContext()->getRequest();
$ajax = $request->isAjaxRequest();


?>
<!-- 
    В js можно сделать функцию которая будет брать все формы и навешивать на них событие submit и выполнять ветки true или false.
    
    Итерируем по массиву всех свойст и в зависимости от типа св-ва выводим нужную html верстку.
    
    Для типа св-ва case 'N' : иногда нужно для этого типа сделать фильтр типа диапозон,
    тут желательно добавить проверку чтобы два значения св-ва были != и 2 > 1 иначе делаем continue этой итерации
-->
<form method="GET" data-form-filter action="<?= $APPLICATION->GetCurPage() ?>">
    <?php foreach ($allProperty as $p => $prop):
        // у input name делаем код св-ва это более удобнене
        // иногда со св-вом нужно передавать и его тип data-prop-type="<?=$prop['PROPERTY_TYPE'] для вализации на js 
        switch ($prop['PROPERTY_TYPE']) {
            case 'N' : ?>
                    <input data-type="get-field" data-prop-type="<?=$prop['PROPERTY_TYPE']?>" name="<?=$prop['CODE']?>" value="<?=$prop['VALUES']?>"  placeholder="test">
                <?php 
                break;
            case 'S': ?>
                    <input data-type="get-field" data-prop-type="<?=$prop['PROPERTY_TYPE']?>" name="<?=$prop['CODE']?>" value="<?=$prop['VALUES']?>"  placeholder="test">
                <?php 
                break;
        }

        endforeach; 
    ?>
    <button>filter</button>
</form>

<!-- блок с элементами -->
<?php if ($ajax) { $APPLICATION->RestartBuffer(); } ?>
    <div data-main-catalog data-replace="main_catalog">
        <div class="catalog" data-container="items-list" data-add-elems>
            <div data-add-elem>1</div>
            <div data-add-elem>2</div>
            <div data-add-elem>3</div>
            <div data-add-elem>4</div>
        </div>

        <div data-elem-nav data-replace="nav_catalog"></div>
        
    </div>
<?php if ($ajax) { exit; } ?>
