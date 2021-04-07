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
                } elseif ($value[0] == 'file') {
                    $model->addRule($key, 'file');
                } elseif ($value[0] == 'select') {
                    $model->addRule($key, 'string', ['max' => 255]);
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
                if ($field[$key][0] == 'file') {
                    $model->addRule($key, 'file');
                } elseif ($field[$key][0] == 'select') {
                    $model->addRule($key, 'string', ['max' => 255]);
                    $model->$key = $value;
                } else {
                    if (array_key_exists('max', $field[$key])) $model->addRule($key, $field[$key][0], ['max' => $field[$key]['max']]);
                    else $model->addRule($key, $field[$key][0]);
                    $model->$key = $value;
                }

            }
        }

        return $model;
    }
}
