<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::whereHas('members', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
        return view('classes', compact('classes'));
    }

    public function show($id)
    {
        $class = Classes::where('id', $id)
            ->with('owner:id,name')
            ->first();
        if (!$class) {
            return redirect('/classes')->with('error', 'Class not found');
        }

        $isMember = ClassMember::where('class_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            return redirect('/classes')->with('error', 'You are not a member of this class');
        }

        return view('class-preview', compact('class'));
    }

    public function findClassByCode($code)
    {

        $class = Classes::where('code', $code)
            ->with('owner:id,name')
            ->first();
        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found',
                'data' => null
                ]);
        }

        $isMember = ClassMember::where('class_id', $class->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($isMember) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found',
                'data' => null
                ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Class found',
            'data' => $class
            ]);
    }

    public function join($id)
    {
        $class = Classes::where('id', $id)
            ->first();
        if (!$class) {
            return redirect('/classes')->with('error', 'Class not found');
        }

        $isMember = ClassMember::where('class_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($isMember) {
            return redirect('/classes')->with('error', 'You are already a member of this class');
        }

        try {
            ClassMember::create([
                'class_id' => $id,
                'user_id' => auth()->id(),
            ]);

            $class->increment('number_of_member');
            $class->save();
        } catch (\Exception $e) {
            return redirect('/classes')->with('error', 'Failed to join class');
        }

        return redirect('/classes/' . $id)->with('success', 'You have joined the class');
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required|string|max:100',
            'desc' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/classes')->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $class = Classes::create([
                "created_by" => auth()->id(),
                "code" => self::generateCode(),
                'name' => $request->name,
                'desc' => $request->desc,
                'number_of_member' => 1,
            ]);
    
            ClassMember::create([
                'class_id' => $class->id,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/classes')->with('error', 'Failed to create class');
        }

        return redirect('/classes/' . $class->id)->with('success', 'Class created successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required|string|max:100',
            'desc' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/classes/' . $id . '/setting')->withErrors($validator)->withInput();
        }

        $class = Classes::where('id', $id)
            ->where('created_by', auth()->id())
            ->first();
        if (!$class) {
            return redirect('/classes')->with('error', 'Class not found');
        }

        $isMember = ClassMember::where('class_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            return redirect('/classes')->with('error', 'You are not a member of this class');
        }

        try {
            $class->update([
                'name' => $request->name,
                'desc' => $request->desc,
            ]);
        } catch (\Exception $e) {
            return redirect('/classes/' . $class->id . '/setting')->with('error', 'Failed to update class');
        }

        return redirect('/classes/' . $class->id . '/setting')->with('success', 'Class updated successfully');
    }
    
    public function destroy($id)
    {
        $class = Classes::where('id', $id)
            ->where('created_by', auth()->id())
            ->first();
        if (!$class) {
            return redirect('/classes')->with('error', 'Class not found');
        }

        $isMember = ClassMember::where('class_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            return redirect('/classes')->with('error', 'You are not a member of this class');
        }

        try {
            DB::beginTransaction();
            $class->delete();
            ClassMember::where('class_id', $id)->delete();
            // TODO delete related data
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/classes')->with('error', 'Failed to delete class');
        }

        return redirect('/classes')->with('success', 'Class deleted successfully');
    }

    public function members($id, Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:100',
        ]);
        $class = Classes::where('id', $id)
            ->with('owner:id,name')
            ->first();
        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found',
                'data' => null
                ]);
        }

        $isMember = ClassMember::where('class_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not a member of this class',
                'data' => null
                ]);
        }

        $members = ClassMember::where('class_id', $id)
            ->whereHas('user', function ($query) use ($request) {
                if ($request->search) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }
            })
            ->with('user:id,name')
            ->paginate(10);


        $members->getCollection()->transform(function ($member) {
            $data = $member->user;
            $data->is_owner = $member->user_id == $member->class->created_by;
            $data->joined_at = $member->created_at->diffForHumans();
            return $data;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Class members',
            'data' => $members
            ]);
    }

    public function member($classId, $userId) {
        $class = Classes::where('id', $classId)
            ->with('owner:id,name')
            ->first();
        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found',
                'data' => null
                ]);
        }

        $isMember = ClassMember::where('class_id', $classId)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not a member of this class',
                'data' => null
                ]);
        }

        $member = ClassMember::where('class_id', $classId)
            ->where('user_id', $userId)
            ->with('user:id,name')
            ->first();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found',
                'data' => null
                ]);
        }

        $data = $member->user;
        $data->is_owner = $member->user_id == $member->class->created_by;
        $data->joined_at = $member->created_at->diffForHumans();

        return response()->json([
            'status' => 'success',
            'message' => 'Class member',
            'data' => $data
            ]);
    }

    public function setting($id)
    {
        $class = Classes::where('id', $id)
            ->with('owner:id,name')
            ->first();
        if (!$class) {
            return redirect('/classes')->with('error', 'Class not found');
        }

        if ($class->created_by != auth()->id()) {
            return redirect('/classes')->with('error', 'You are not the owner of this class');
        }

        return view('class-setting', compact('class'));
    }

    private static function generateCode()
    {
        $code = strtoupper(Str::random(4)) . "-" . strtoupper(Str::random(4));
        if (Classes::where('code', $code)->exists()) {
            return self::generateCode();
        }
        return $code;
    }
}
