<?php

namespace MrShan0\PHPFirestore\Fields;

use DateTime;
use MrShan0\PHPFirestore\Contracts\FireStoreDataTypeContract;

class FireStoreGeoPoint implements FireStoreDataTypeContract
{
    private $data;

    public function __construct($latitude='', $longitude='')
    {
        return $this->setData([$latitude, $longitude]);
    }

    public function setData($data)
    {
        return $this->data = [
            'latitude' => $data[0],
            'longitude' => $data[1],
        ];
    }

    public function getData()
    {
        return $this->data;
    }

    public function parseValue()
    {
        $value = $this->getData();

        return $value;
    }
}
