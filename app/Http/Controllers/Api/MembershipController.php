<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\Membership;
use App\Http\Controllers\Controller;
use App\Models\MembershipType;
use App\Http\Controllers\MembershipTypeController;
class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::all();
        return response()->json($memberships);
    }
    public function show($id)
    {
        $membership = Membership::find($id);
        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }
        return response()->json($membership);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required|exists:users,id', // Ensure the user exists in the users table
            'typeId' => 'required|exists:membership_types,id', // Ensure the type exists in the membership_types table
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'status' => 'required|in:Active,Expired',
        ]);
         $membership = Membership::create($validated);

        // Return the created membership as a JSON response
        return response()->json($membership, 201);
    }
    public function update(Request $request, $id)
    {
        $membership = Membership::find($id);
        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }
        $membership->update($request->all());
        return response()->json($membership);
    }
    public function destroy($id)
    {
        $membership = Membership::find($id);
        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }
        $membership->delete();
        return response()->json(['message' => 'Membership deleted successfully']);
    }
    public function getMembershipsByUserId($userId)
    {
        $memberships = Membership::where('userid', $userId)->get();
        return response()->json($memberships);
    }
}
