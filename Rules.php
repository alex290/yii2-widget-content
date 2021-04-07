<?php

namespace alex290\widgetContent;



class Rules
{
    public static function add($model, $field)
    {
        if (!empty($field)) {
            foreach ($field as $key => $value) {
                if ($value[0] == 'image') {
                    $model->addRule($key, 'file', ['extensions' => 'png, jpg']);
                } else {
                    if (array_key_exists('max', $value)) $model->addRule($key, $value[0], ['max' => $value['max']]);
                    else $model->addRule($key, $value[0]);
                }
            }
        }

        return $model;
    }

    public static function update($model, $data, $field)
    {
        if (!empty($field)) {
            foreach ($data as $key => $value) {
                if (array_key_exists('max', $field[$key])) $model->addRule($key, $field[$key][0], ['max' => $field[$key]['max']]);
                else $model->addRule($key, $field[$key][0]);
                $model->$key = $value;
            }
        }

        return $model;
    }
}
