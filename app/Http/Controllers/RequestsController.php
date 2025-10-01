<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    public function index(Request $request){
        $query = Requests::with(['offer', 'country', 'user']);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            $query->where(function ($query) use ($searchTerm) {
                $query->whereHas('offer', function ($offerQuery) use ($searchTerm) {
                    $offerQuery->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('country', function ($countryQuery) use ($searchTerm) {
                    $countryQuery->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        $requests = $query->paginate(10);
        
        // dd($requests);
        return view('backend.request.index', compact('requests'));
    }

    public function confirm(Request $request)
    {
        $requestProduct = Requests::where('id', $request->id)->first();
        $update = $requestProduct->update([
            'is_active' => 1
        ]);
        if ($update) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['failed' => true]);
        }
    }

    public function inactive(Request $request)
    {
        $requestProduct = Requests::where('id', $request->id)->first();
        $update = $requestProduct->update([
            'is_active' => 0
        ]);
        if ($update) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['failed' => true]);
        }
    }

}
