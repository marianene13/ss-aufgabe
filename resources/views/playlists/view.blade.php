<x-app-layout>
    <x-slot name="header">
        <div class="grid">
            <div>
                <img src="{{ $playlist->image_url }}" width="50%" />
            </div>
            <div class="lg:col-start-2 col-span-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $playlist->name }}
                </h2>
                <small>
                    {!! $playlist->description !!}
                </small>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12 space-y-12">
            <div class="p-12 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl sm:p-8">
                    <form method="GET" action="{{ route('playlists.show', ['id' => $playlist->id]) }}" class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="query" :value="__('Search by song name, spotify id, popularity')" />
                            <x-text-input id="query" class="block mt-1 w-full" type="text" name="query" value="{{ $searchString }}" />
                            <x-input-error :messages="$errors->get('query')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                <div class="relative overflow-x-auto sm:p-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4">
                                {{ __('Song name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Artist/s') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Duration') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Updated Date') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($songs) > 0)
                            @foreach($songs as $song)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('songs.show', ['id' => $song->id]) }}">
                                            {{ $song->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3">
                                        @foreach($song->artists()->get() as $artist)
                                            {{ $artist->name }}
                                            @if(!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ $song->durationInMinutes() }}
                                    </td>
                                    <td class="px-6 py-2">
                                        {{ $song->updated_at }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-12 py-12 font-medium whitespace-nowrap dark:text-white">
                                    <form method="POST" action="{{ route('playlists.loadSongs', ['id' => $playlist->id]) }}" class="mt-6 space-y-6">
                                        @csrf
                                        <div class="flex items-center gap-4">
                                            <x-primary-button>
                                                {{ __('Load songs') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $songs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
