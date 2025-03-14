<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    public function run()
    {
        $project1 = Project::first();
        $attribute1 = Attribute::where('name', 'Department')->first();

        AttributeValue::create([
            'attribute_id' => $attribute1->id,
            'entity_id' => $project1->id,
            'value' => 'IT',
        ]);
    }
}