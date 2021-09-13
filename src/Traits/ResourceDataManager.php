<?php

namespace Mawuekom\Usercare\Traits;

use Exception;
use Illuminate\Http\Response;
use Mawuekom\ModelUuid\Utils\ValidatesUuid;
use Mawuekom\RepositoryLayer\BaseApiRepository;
use Mawuekom\Usercare\Traits\DataRecordsChecker;
use RuntimeException;

trait ResourceDataManager
{
    use ValidatesUuid, DataRecordsChecker;

    /**
     * Validate and get resource by ID
     * 
     * @param int|string $id
     * @param string $resource
     * @param boolean $inTrashed
     * 
     * @throws \App\Exceptions\ResourceNotFoundException
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function validateAndGetResourceById(int|string $id, string $resource = null, $inTrashed = false)
    {
        $resourceKey = resolve_key($resource, $id, $inTrashed);
        $data = $this->getResourceItemBy([$resourceKey => $id], $resource, $inTrashed);

        $this ->checkDataResource($data, trans('usercare::messages.resource.not_found'));

        return $data;
    }

    /**
     * Validate and get resource by Slug
     * 
     * @param string $slug
     * @param string $resource
     * @param boolean $inTrashed
     * 
     * @throws \App\Exceptions\ResourceNotFoundException
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function validateAndGetResourceBySlug(string $slug, string $resource = null, $inTrashed = false)
    {
        $data = $this->getResourceItemBy(['slug' => $slug], $resource, $inTrashed);

        $this ->checkDataResource($data, trans('usercare::messages.resource.not_found'));

        return $data;
    }
    
    /**
     * Validate slug
     * 
     * @param string $resource
     * @param string $slug
     * @param int|string $id
     * 
     * @return void
     */
    public function validateSlug(string $slug, string $resource = null, int|string $id = null)
    {
        $resourceKey = resolve_key($resource, $id);
        $data = $this->getResourceItemBy(['slug' => $slug], $resource);

        if ($data !== null) {
            if (is_null($id)) {
                throw new Exception(
                    trans('usercare::messages.attribute_already_exists', [
                        'attribute' => trans('usercare::entity.attributes.slug')
                    ]), Response::HTTP_CONFLICT
                );
            }

            else {
                if (!is_null($id) && $data ->{$resourceKey} !== $id) {
                    throw new Exception(
                        trans('usercare::messages.attribute_already_exists', [
                            'attribute' => trans('usercare::entity.attributes.slug')
                        ]), Response::HTTP_CONFLICT
                    );
                }
            }
        }
    }
    
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
        $model = config('usercare.'.$this->resolveEntity($entity).'.model');

        return (property_exists($this, 'repository'))
                ? $this ->repository
                : app() ->make($model);
    }
}