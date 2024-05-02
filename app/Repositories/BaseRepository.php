<?php

namespace App\Repositories;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->findOrFail($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->findOrFail($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}
