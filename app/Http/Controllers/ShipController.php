<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ship;
use App\Models\CabinCategory;
use App\Models\ShipsGallery;

class ShipController extends Controller
{
    public function index()
    {
        $ships = Ship::all();
        return view('ships.index', compact('ships'));
    }

    public function edit(Ship $ship)
    {
        $categories = CabinCategory::where('ship_id', $ship->id)->orderBy('ordering', 'ASC')->get();
        $gallery = ShipsGallery::where('ship_id', $ship->id)->orderBy('ordering', 'ASC')->get();
        return view('ships.edit', compact('ship', 'categories', 'gallery'));
    }

    public function update(Request $request, Ship $ship, CabinCategory $cabin_category)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'spec' => 'required|string',
            'description' => 'required|string',
        ]);

        $ship->update([
            'title' => $request->title,
            'spec' => json_decode($request->spec, true),
            'description' => $request->description,
        ]);

        $cabins = json_decode($request->cabins, true);

        for ($i = 0; $i < sizeof($cabins); $i++) {

            if (isset($cabins[$i]['action']) && $cabins[$i]['action'] === 'added') {
                try {
                    $cabin_category->create([
                        'ship_id' => $ship->id,
                        'title' => $cabins[$i]['title'],
                        'vendor_code' => $cabins[$i]['vendor_code'],
                        'description' => $cabins[$i]['description'],
                        'type' => $cabins[$i]['type'],
                        'photos' => $cabins[$i]['photos'],
                        'ordering' => $cabins[$i]['ordering'],
                        'state' => $cabins[$i]['state'],
                    ]);
                } catch(\Illuminate\Database\QueryException $ex) {
                    $error = $ex->getMessage();
                }
            }

            if (isset($cabins[$i]['action']) && $cabins[$i]['action'] === 'updated') {
                try {
                    $cabin_category->where('id', $cabins[$i]['id'])->update([
                        'ship_id' => $ship->id,
                        'title' => $cabins[$i]['title'],
                        'vendor_code' => $cabins[$i]['vendor_code'],
                        'description' => $cabins[$i]['description'],
                        'type' => $cabins[$i]['type'],
                        'photos' => $cabins[$i]['photos'],
                        'ordering' => $cabins[$i]['ordering'],
                        'state' => $cabins[$i]['state'],
                    ]);
                } catch(\Illuminate\Database\QueryException $ex) {
                    $error = $ex->getMessage();
                }
            }

            if (isset($cabins[$i]['action']) && $cabins[$i]['action'] === 'deleted') {
                try {
                    $cabin_category->where('id', $cabins[$i]['id'])->delete();
                } catch(\Illuminate\Database\QueryException $ex) {
                    $error = $ex->getMessage();
                }
            }
        }

        if (isset($error)) return redirect("/ships/{$ship->id}/edit")->with('error', $error);
        return redirect("/ships/{$ship->id}/edit")->with('success', 'Информация о корабле и категориях кают обновлена.');

    }

}
