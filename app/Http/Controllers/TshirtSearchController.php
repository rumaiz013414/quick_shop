<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use Illuminate\Http\Request;

class TshirtSearchController extends Controller
{
    // Search T-shirts by name
    public function search(Request $request)
    {
        $query = $request->input('search');
        if ($query) {
            // Limit results for autocomplete (e.g., 5 suggestions)
            $tshirts = Tshirt::where('name', 'like', '%' . $query . '%')->limit(5)->get(['name']);
        } else {
            $tshirts = [];
        }

        // Return JSON response for AJAX request
        return response()->json($tshirts);
    }
}
