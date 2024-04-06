<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedirectStoreRequest;
use App\Models\RedirectData;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RedirectController extends Controller
{
    public function create()
    {
        return view('redirect-form');
    }

    public function store(RedirectStoreRequest $request)
    {

    }

    public function redirect(string $path)
    {
        try {
            $redirect = RedirectData::where('origin_url', $path)->firstOrFail();

            Statistic::create([
                'redirect_data_id' => $redirect->id,
            ]);

            return response()->redirectTo($redirect->destination_url, 307);
        } catch (ModelNotFoundException) {
            throw new NotFoundHttpException();
        }
    }
}
