<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Unit;

class   UnitsController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            // If "Super Admin," retrieve all units
            $units = Unit::all();
        } else {
            // If not "Super Admin," filter units by user_id
            $units = Unit::where('user_id', $user->id)->orWhere('user_id', 1)->get();
        }

        return view('setting::units.index', [
            'units' => $units
        ]);
    }


    public function create()
    {
        return view('setting::units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'short_name' => 'required|string|max:255'
        ]);

        Unit::create([
            'name'            => $request->name,
            'short_name'      => $request->short_name,
            'operator'        => $request->operator,
            'operation_value' => $request->operation_value,
            'user_id' => auth()->user()->id,
        ]);

        toast('Unit Created!', 'success');

        return redirect()->route('units.index');
    }

    public function edit(Unit $unit)
    {
        return view('setting::units.edit', [
            'unit' => $unit
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'short_name' => 'required|string|max:255'
        ]);

        $unit->update([
            'name'            => $request->name,
            'short_name'      => $request->short_name,
            'operator'        => $request->operator,
            'operation_value' => $request->operation_value,
        ]);

        toast('Unit Updated!', 'info');

        return redirect()->route('units.index');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        toast('Unit Deleted!', 'warning');

        return redirect()->route('units.index');
    }
}
