<?php

namespace App\Services;

use App\Repositories\AttributeRepository;
use App\Http\Resources\AttributeResource;

class AttributeService
{
    protected $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function getAllAttributes(array $filters = [])
    {
        $attributes = $this->attributeRepository->getAll($filters);
        return AttributeResource::collection($attributes);
    }

    public function getAttributeById(int $id)
    {
        $attribute = $this->attributeRepository->getById($id);
        return new AttributeResource($attribute);
    }

    public function createAttribute(array $data)
    {
        $attribute = $this->attributeRepository->create($data);
        return new AttributeResource($attribute);
    }

    public function updateAttribute(int $id, array $data)
    {
        $attribute = $this->attributeRepository->update($id, $data);
        return new AttributeResource($attribute);
    }

    public function deleteAttribute(int $id)
    {
        return $this->attributeRepository->delete($id);
    }
}