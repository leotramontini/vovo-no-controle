<?php

namespace Vovo\Controllers\Traits;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;

trait MakesResponses
{
    /**
     * Retorna uma coleção
     *
     * @param \Illuminate\Support\Collection $collection
     * @param string $transformer
     * @return mixed
     */
    public function collection($collection, $transformer)
    {
        return $this->response->collection($collection, new $transformer);
    }

    /**
     * Retorna um array
     *
     * @param array $data
     * @return mixed
     */
    public function array($data)
    {
        return $this->response->array($data);
    }

    /**
     * Retorna um item
     *
     * @param \Illuminate\Database\Eloquent\Model $item
     * @param string $transformer
     * @return mixed
     */
    public function item($item, $transformer)
    {
        return $this->response->item($item, new $transformer);
    }

    /**
     * Retorna 401
     *
     * @param mixed $message
     * @param array $errors
     * @return void
     */
    public function throwErrorStore($message = null, $errors = [])
    {
        throw new StoreResourceFailedException($message, $errors);
    }

    /**
     * Retorna 401
     *
     * @param mixed $message
     * @param array $errors
     * @return void
     */
    public function throwErrorDelete($message = null, $errors = [])
    {
        throw new DeleteResourceFailedException($message, $errors);
    }

    /**
     * Retorna 404
     *
     * @param mixed $message
     * @return void
     */
    public function throwErrorNotFound($message = null)
    {
        return $this->response->errorNotFound($message);
    }

    /**
     * Retorna 400
     *
     * @param mixed $message
     * @return void
     */
    public function throwErrorBadRequest($message = null)
    {
        return $this->response->errorBadRequest($message);
    }

    /**
     * Retorna 401
     *
     * @param mixed $message
     * @param array $errors
     * @return void
     */
    public function throwErrorUpdate($message = null, $errors = [])
    {
        throw new UpdateResourceFailedException($message, $errors);
    }
}
