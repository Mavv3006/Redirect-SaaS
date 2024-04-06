<?php

namespace App\Livewire\Redirect;

use App\Models\Statistic;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ListRedirects extends Component
{

    public function render()
    {
//        $data = RedirectData::select(['origin_url', 'destination_url', 'created_at'])
//            ->where('user_id', Auth::id())
//            ->get();

        $query = DB::table('redirect_data')
            ->where('user_id', Auth::id())
            ->leftJoinSub(
                Statistic::groupBy('redirect_data_id')
                    ->select([
                        DB::raw('count(*) as count'),
                        'redirect_data_id',
                        DB::raw('max(created_at) as max_created_at')
                    ]),
                's',
                function (JoinClause $join) {
                    $join->on('redirect_data.id', '=', 's.redirect_data_id');
                })
            ->select(['redirect_data.origin_url', 'redirect_data.destination_url', 'redirect_data.created_at', 's.count', 's.max_created_at']);

//        $query->ddRawSql();

        $data = $query->get()->toArray();

        Log::debug('data', $data);

        return view('livewire.redirect.list-redirects', ['data' => $data]);
    }
}
