<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::paginate(10);

        return View('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['bail', 'required', 'max:255', 'string'],
            'status' => ['required', 'boolean']
        ]);

        // store
        $department = new Department();
        $department->name = $request->name;
        $department->status = $request->status;
        $department->save();

        return redirect()->route('departments.index')->with('status', 'Department created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);

        return View('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['bail', 'required', 'max:255', 'string'],
            'status' => ['required', 'boolean']
        ]);

        // update
        $department = Department::find($id);
        $department->name = $request->name;
        $department->status = $request->status;
        $department->save();

        return redirect()->route('departments.index')->with('status', 'Department updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // destroy
        $department = Department::find($id);
        $department->delete();

        return redirect()->route('departments.index')->with('status', 'Department deleted successfully!');
    }
}
