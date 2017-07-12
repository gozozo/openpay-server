<?php

/**
 * Created by Gozozo.
 * Date: 7/12/17
 * Time: 1:46 PM
 */

namespace Gozozo\OpenpayServer\Traits;

trait ActionObjects
{
    function create ($array){
        foreach ($array as $key => $value)
        {
            $this->$key = $value;
        }
    }

    function toArray()
    {
        return (array)$this;
    }

    function toJson()
    {
        return json_encode($this);
    }
}