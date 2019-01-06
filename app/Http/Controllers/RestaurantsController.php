<?php

namespace App\Http\Controllers;

use App\Restaurants;
use Illuminate\Http\Request;


class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurants::all();

        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rest_name'=>'required',
            'rest_address'=> 'required',
            'tel_num' => 'required|integer'
        ]);

        $formattedAddr = str_replace(' ','+',$request->get('rest_address'));

        $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyCd1ROM9OflA9ao8n1c1ctFcVD6SGafOrM');
        $output= json_decode($geocode);


        $lat = $output->results[0]->geometry->location->lat;
        $lng = $output->results[0]->geometry->location->lng;


        $restaurants = new Restaurants([
            'rest_name' => $request->get('rest_name'),
            'rest_address'=> $request->get('rest_address'),
            'tel_num'=> $request->get('tel_num'),
            'lat'=> $lat,
            'lng' =>$lng
        ]);
        $restaurants->save();
        return redirect('/restaurants')->with('success', 'Restaurant has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurants = Restaurants::all();

        return $restaurants;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurants = Restaurants::find($id);

        return view('restaurants.edit', compact('restaurants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rest_name'=>'required',
            'rest_address'=> 'required',
            'tel_num' => 'required|integer'
        ]);

        $formattedAddr = str_replace(' ','+',$request->get('rest_address'));

        $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyCd1ROM9OflA9ao8n1c1ctFcVD6SGafOrM');
        $output= json_decode($geocode);


        $lat = $output->results[0]->geometry->location->lat;
        $lng = $output->results[0]->geometry->location->lng;

        $restaurants = Restaurants::find($id);
        $restaurants->rest_name = $request->get('rest_name');
        $restaurants->rest_address = $request->get('rest_address');
        $restaurants->tel_num = $request->get('tel_num');
        $restaurants->lat = $lat;
        $restaurants->lng = $lng;
        $restaurants->save();

        return redirect('/restaurants')->with('success', 'Restaurant detail has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurants = Restaurants::find($id);
        $restaurants->delete();

        return redirect('/restaurants')->with('success', 'Restaurant has been deleted Successfully');
    }
}
