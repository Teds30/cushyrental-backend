<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function create(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required|integer',
            'unit_id' => 'required|integer',
        ]);

        $isBookmark = Bookmark::where('user_id', $fields['user_id'])
            ->where('unit_id', $fields['unit_id'])
            ->first();

        if ($isBookmark) {
            $isBookmark->delete();
            return response()->json(['Unit rmove from bookmark'], 200);
        }

        $res = Bookmark::create($fields);
        return response()->json($res, 201);
    }
}
