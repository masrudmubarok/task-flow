<?php

namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository
{
    public function getAll(array $filters)
    {
        return Attribute::where($filters)->get();
    }

    public function getById($id)
    {
        return Attribute::findOrFail($id);
    }

    public function create(array $data)
    {
        return Attribute::create($data);
    }

    public function update($id, array $data)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update($data);
        return $attribute;
    }

    public function delete($id)
    {
        return Attribute::destroy($id);
    }
}