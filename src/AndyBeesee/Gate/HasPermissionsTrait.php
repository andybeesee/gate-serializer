<?php namespace AndyBeesee\Gate;

use AndyBeesee\Gate\Serializer as PermissionsSerializer;

trait HasPermissionsTrait
{
    public function getPermissionsAttribute()
    {
        $serializer = new PermissionsSerializer();
        return $serializer->get($this);
    }
}
