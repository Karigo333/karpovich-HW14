<?php

namespace App\Http\Controllers;


use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Rfc4122\Validator;

class AdController extends Controller
{
    public function view($id, Request $request)
    {
        $ad = Ad::find($id);
        return view('view', [
            'ad' => $ad
        ]);
    }

    public function delete($id, Request $request)
    {

        $this->authorize('delete', $ad);



        $ad->delete();

        return redirect()->to($request->server('HTTP_REFERER'));
    }

    public function update($id, Request $request)
    {
        $validator = Facades\Validator::make($request->all(), [
            'title' => 'required|max:255',
            'price' => 'required|between:0,10000',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route('adCreateForm')
                ->withErrors($validator->errors());
        }

        $ad = Ad::find($id);

        if (!$ad) {
            return redirect('/')->withErrors([
                'errorMessage' => 'Cant find ad'
            ]);
        }
        $this->authorize('update', $ad);

        $ad->title = $request->title;
        $ad->price = $request->price;
        $ad->description = $request->description;
        $ad->save();

        return redirect()->to($request->server('HTTP_REFERER'));
    }

    public function createForm()
    {
        return view('adForm');
    }

    public function updateForm($id)
    {
        $ad = Ad::find($id);

        if (!$ad) {
            return redirect('/')->withErrors([
                'errorMessage' => 'Cant find ad'
            ]);

        }
        return view('adForm', [
            'title' => $ad->title,
            'price' => $ad->price,
            'description' => $ad->description,
            'button' => 'Update',
            'route' => route('adUpdate', ['id' => $ad->id])

        ]);
        }


    public function create(Request $request)
    {

        $validator = Facades\Validator::make($request->all(), [
            'title' => 'required|max:255',
            'price' => 'required|between:0,10000',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                ->route('adCreateForm')
                ->withErrors($validator->errors());
        }



        $ad = new Ad([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $ad->save();
        return redirect()->route('home');
    }
}
