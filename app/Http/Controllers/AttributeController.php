<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Inclusion;
use App\Models\Rule;

class AttributeController extends Controller
{
    public function show()
    {
        $out = array();

        $out['amenities'] = Amenity::get()->where('status', 1);
        $out['facilities'] = Facility::get()->where('status', 1);
        $out['inclusions'] = Inclusion::get()->where('status', 1);
        $out['rules'] = Rule::get()->where('status', 1);

        $response = $out;

        return response($response, 201);
        
    }
}
