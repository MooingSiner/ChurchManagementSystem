<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Members;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Members::with(['ministries'])->get();

        return response()->json([
            'success' => true,
            'data' => $members,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'member_fname' => 'required|string|max:255',
            'member_mname' => 'nullable|string|max:255',
            'member_lname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:members,email',
            'phone_number' => 'required|string|max:20|unique:members,phone_number',
            'street' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'ministry_id' => 'nullable|integer|exists:ministries,ministry_id',
        ]);

        $member = Members::create([
            'member_fname' => $validatedData['member_fname'],
            'member_mname' => $validatedData['member_mname'] ?? null,
            'member_lname' => $validatedData['member_lname'],
            'gender' => $validatedData['gender'],
            'birth_date' => $validatedData['birth_date'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'street' => $validatedData['street'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'province' => $validatedData['province'] ?? null,
        ]);

       

        if (!empty($validatedData['ministry_id'])) {
            $member->ministries()->attach($validatedData['ministry_id']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Member created successfully.',
            'data' => $member->load(['ministries']),
        ], 201);
    }

    public function show($id)
    {
        $member = Members::with(['ministries'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $member,
        ]);
    }

    public function update(Request $request, $id)
    {
        $member = Members::findOrFail($id);

        $validatedData = $request->validate([
            'member_fname' => 'required|string|max:255',
            'member_mname' => 'nullable|string|max:255',
            'member_lname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:members,email,' . $id . ',member_id',
            'phone_number' => 'required|string|max:20|unique:members,phone_number,' . $id . ',member_id',
            'street' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'ministry_id' => 'nullable|integer|exists:ministries,ministry_id',
        ]);

        $member->update([
            'member_fname' => $validatedData['member_fname'],
            'member_mname' => $validatedData['member_mname'] ?? null,
            'member_lname' => $validatedData['member_lname'],
            'gender' => $validatedData['gender'],
            'birth_date' => $validatedData['birth_date'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'street' => $validatedData['street'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'province' => $validatedData['province'] ?? null,
        ]);

    

        if (!empty($validatedData['ministry_id'])) {
            $member->ministries()->sync([$validatedData['ministry_id']]);
        } else {
            $member->ministries()->detach();
        }

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully.',
            'data' => $member->load(['ministries']),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $member = Members::findOrFail($id);

        $member->ministries()->detach();
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member deleted successfully.',
        ]);
    }
}
