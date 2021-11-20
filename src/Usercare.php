<?php

namespace Mawuekom\Usercare;

use Illuminate\Database\Eloquent\Model;

class Usercare
{
    /**
     * Get entity resource by field and value
     * 
     * @param string $entity
     * @param string $attribute
     * @param string $value
     * @param bool   $inTrashed
     * @param array  $columns
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntityByField(string $entity, $field, $value = null, $inTrashed = false, $columns = ['*']): Model
    {
        $data = app(config('usercare.'.$entity.'.model')) ->where($field, '=', $value);

        return ($inTrashed)
                    ? $data ->withTrashed() ->first($columns)
                    : $data ->first($columns);
    }

    /**
     * Get entity resource by id
     * 
     * @param string        $entity
     * @param int|string    $id
     * @param bool          $inTrashed
     * @param array         $columns
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntityById(string $entity, $id, $inTrashed = false, $columns = ['*'])
    {
        $key = resolve_key('usercare', config('usercare.user.slug'), $id, $inTrashed);

        return $this ->getEntityByField($entity, $key, $id, $inTrashed, $columns);
    }
}
