<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinksController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $user = Auth::user();
        if (!empty($keyword)) {
            $links = $user->links()->where('link', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $links = $user->links()->latest()->paginate($perPage);
        }

        return view('links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        $requestData['user_id'] = Auth::id();
        $requestData['short_link'] = $this->generateRandomString();

        Link::create($requestData);

        return redirect('links')->with('flash_message', 'Link added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $link = Link::findOrFail($id);

        return view('links.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $link = Link::findOrFail($id);

        return view('links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $link = Link::findOrFail($id);
        if ($link['user_id'] != Auth::id()) return redirect(404);

        $link->update($requestData);

        return redirect('links')->with('flash_message', 'Link updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Link::destroy($id);

        return redirect('links')->with('flash_message', 'Link deleted!');
    }


    /**
     * Generate Random String
     *
     * @param int $length
     *
     * @return string
     */
    private function generateRandomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     * Redirect To Link
     *
     * @param $short_link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToLink($short_link)
    {
        $link = Link::where('short_link', $short_link)->where(function ($query) {
            $query->whereNull('available_to')->orWhere('available_to', '>', Carbon::now());
        })->firstOrFail();

        return redirect($link['link']);
    }
}
