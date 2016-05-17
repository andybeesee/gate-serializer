<?php namespace AndyBeesee\Gate;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class Serializer {
    protected $baseObject;

    public function get($baseObject, $user = null)
    {
        if (!is_object($baseObject)) {
            throw new \Exception("You must pass an object to PermissionsSerializer");
        }

        $this->baseObject = $baseObject;

        //Default permissions are always false
        $default = $this->getDefaultPermissions();
        if(is_null($user) && !Auth::check()){
            return $default;
        } else if(is_null($user)){
            //no user given, use the logged in user
            $user = Auth::user();
        }

        $final = [];

        foreach($default as $action => $value){
            //Get results of permission check
            $final[$action] = Gate::forUser($user)->allows($action, $this->baseObject);
        }

        return $final;
    }

    protected function getPermissionNames()
    {
        try {
            $policy = Gate::getPolicyFor($this->baseObject);
            $methods = get_class_methods($policy);

            //pull out the 'before' name if it is set
            if($methods[0] === 'before'){
                unset($methods[0]);
            }

            return array_except($methods, 'before');
        } catch (\InvalidArgumentException $e){
            return [];
        }

    }

    protected function getDefaultPermissions()
    {
        $permissions = [];
        foreach($this->getPermissionNames() as $v){
            $permissions[$v] = false;
        }

        return $permissions;
    }
}
