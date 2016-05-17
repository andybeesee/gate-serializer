<?php
/**
 * Created by PhpStorm.
 * User: andrewhollandmoritz
 * Date: 5/17/16
 * Time: 5:07 AM
 */

namespace AndyBeesee\Gate;

use AndyBeesee\Serializer as PermissionsSerializer;

trait HasPermissionsTrait
{
    public function getPermissionsAttribute()
    {
        $serializer = new PermissionsSerializer();
        return $serializer->get($this);
    }
}