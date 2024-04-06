<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Eingetragene Redirects
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Hier werden deine eingetragenen Redirects angezeigt.
        </p>
    </header>

    <div>
        <table class="w-full">
            <thead>
            <tr>
                <th>Path</th>
                <th>Destination</th>
                <th>Created At</th>
                <th>Anzahl Aufrufe</th>
                <th>Letzter Aufruf</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $entry)
                <tr>
                    <td>
                        <a href="/{{ $entry->origin_url }}">
                            {{ $entry->origin_url }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ $entry->destination_url }}">
                            {{ $entry->destination_url }}
                        </a>
                    </td>
                    <td>{{ $entry->created_at }}</td>
                    <td>{{ $entry->count }}</td>
                    <td>{{ $entry->max_created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</section>
