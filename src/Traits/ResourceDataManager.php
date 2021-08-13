<?php

namespace Mawuekom\Usercare\Traits;

use Mawuekom\ModelUuid\Utils\ValidatesUuid;
use Mawuekom\RepositoryLayer\BaseApiRepository;
use RuntimeException;

trait ResourceDataManager
{
    use ValidatesUuid;

    /**
     * Get resource item by...
     *
     * @param array $params
     * @param string $entity
     * @param bool $inTrashed
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getResourceItemBy(array $params, string $entity = null, $inTrashed = false)
    {
        $entity = $this ->resolveEntity($entity);
        $modelRepo = $this ->getModelRepo($entity);

        if ($modelRepo instanceof BaseApiRepository) {
            $data = ($inTrashed)
                        ? $modelRepo ->getModel() ->onlyTrashed() ->where($params) ->first()
                        : $modelRepo ->getResourceBy($params);
        }

        else {
            $data = ($inTrashed)
                        ? $modelRepo::where($params) ->withTrashed() ->first()
                        : $modelRepo::where($params) ->first();
        }

        return $data;
    }

    /**
     * Get entity on which to perform actions.
     *
     * @param string $entity
     *
     * @return string|null
     */
    protected function resolveEntity(string $entity = null): ?string
    {
        if (!is_null($entity)) {
            return $entity;
        }

        elseif (property_exists($this, 'entity')) {
            return $this ->entity;
        }

        else {
            throw new RuntimeException("Entity must be specified.");
        }
    }

    /**
     * Resolve model repository
     *
     * @param string $entity
     *
     * @return \Mawuekom\RepositoryLayer\BaseApiRepository|\Mawuekom\RepositoryLayer\BaseRepository|\Illuminate\Database\Eloquent\Model
     */
    protected function getModelRepo(string $entity = null)
    {
        $model = config('userly.'.$this->resolveEntity($entity).'.model');

        return (property_exists($this, 'repository'))
                ? $this ->repository
                : app() ->make($model);
    }
}