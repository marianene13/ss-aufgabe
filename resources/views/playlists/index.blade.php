<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Playlists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="py-6 sm:p-8">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Add new Playlist') }}
                    </h2>
                    <form method="POST" action="{{ route('playlists.add') }}" class="mt-6 space-y-6">
                        @csrf

                        <!-- API Playlist ID -->
                        <div>
                            <x-input-label for="api_playlist_id" :value="__('API Playlist ID')" />
                            <x-text-input id="api_playlist_id" class="block mt-1 w-full" type="text" name="api_playlist_id" required autofocus />
                            <x-input-error :messages="$errors->get('api_playlist_id')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Add Playlist') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                <div class="py-6 sm:p-8">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Search Playlist') }}
                    </h2>
                    <form method="GET" action="{{ route('playlists.index') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="query" :value="__('Playlist name')" />
                            <x-text-input id="query" class="block mt-1 w-full" type="text" name="query" value="{{ $searchString }}" autofocus />
                            <x-input-error :messages="$errors->get('query')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Search Playlist') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="relative overflow-x-auto sm:p-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-2">
                                #
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Track(s)
                            </th>
                            <th scope="col" class="px-6 py-2">
                                Updated
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($playlists) > 0)
                            @foreach($playlists as $playlist)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('playlists.show', ['id' => $playlist->id]) }}" target="_blank">
                                            {{ $playlist->name }}
                                        </a>
                                    </td>
                                    <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $playlist->songs()->get()->count() }}
                                    </th>
                                    <td class="px-6 py-6">
                                        {{ date('F j, Y', strtotime($playlist->updated_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-12 py-12 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    No playlists available
                                </th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $playlists->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
