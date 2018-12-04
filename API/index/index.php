<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


$Param=array("string"=>"Пример строки",
    "numeric"=>100,
    "boolean"=>true,
    "null"=>null,
    "array"=>array(
        [
            "arr_element_1_field_1"=>"Первое свойство первого элемента",
            "arr_element_1_field_2"=>100,
            "arr_element_1_field_3"=>true
        ],
        [
            "arr_element_2_field_1"=>"Первое свойство второго элемента",
            "arr_element_2_field_2"=>200,
            "arr_element_2_field_3"=>true
        ]
    ),
    "object"=>array("name"=>"Пример свойства объекта")
);
echo json_encode($Param);