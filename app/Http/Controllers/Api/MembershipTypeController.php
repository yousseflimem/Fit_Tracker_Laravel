<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Http\Controllers\Controller;
class MembershipTypeController extends Controller
{
    public function index()
    {
        $membershipTypes = MembershipType::all();
        return response()->json($membershipTypes);
    }

    public function show($id)
    {
        $membershipType = MembershipType::find($id);
        if (!$membershipType) {
            return response()->json(['message' => 'Membership Type not found'], 404);
        }

        return response()->json($membershipType);
    }  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'durationInDays' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        // Create the membership type using the validated data
        $membershipType = MembershipType::create($request->all());

        // Check if creation was successful
        if ($membershipType) {
            return response()->json([
                'message' => 'Membership Type created successfully!',
                'data' => $membershipType
            ], 201);  // 201 Created response
        }

        // Return an error if creation fails
        return response()->json(['message' => 'Failed to create Membership Type'], 500);
    }

    
    public function update(Request $request, $id)
    {
        $membershipType = MembershipType::find($id);
        if (!$membershipType) {
            return response()->json(['message' => 'Membership Type not found'], 404);
        }
        
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
        ]);

        $membershipType->update($request->all());
        return response()->json($membershipType);
    }
    public function destroy($id)
    {
        $membershipType = MembershipType::find($id);
        if (!$membershipType) {
            return response()->json(['message' => 'Membership Type not found'], 404);
        }

        $membershipType->delete();
        return response()->json(['message' => 'Membership Type deleted successfully']);
    }
    public function getMembershipTypesByGym($gymId)
    {
        $membershipTypes = MembershipType::where('gym_id', $gymId)->get();
        return response()->json($membershipTypes);
    } 
}
