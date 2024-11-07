<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Audio features') }}
</h2>
<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <tbody>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Danceability') }}
        </th>
        <td class="px-6 py-6">
            {{ $audioFeatures->danceability }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Energy') }}
        </th>
        <td class="px-6 py-6">
            {{ $audioFeatures->energy }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Loudness') }}
        </th>
        <td class="px-6 py-6">
            {{ $audioFeatures->loudness }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Speechiness') }}
        </th>
        <td class="px-6 py-6">
            {{ $audioFeatures->speechiness }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Acousticness') }}
        </th>
        <td class="px-6 py-6">
            {{ rtrim(number_format($audioFeatures->acousticness, 10), "0") }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Instrumentalness') }}
        </th>
        <td class="px-6 py-6">
            {{ rtrim(number_format($audioFeatures->instrumentalness, 10), "0") }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Liveness') }}
        </th>
        <td class="px-6 py-6">
            {{ $audioFeatures->liveness }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Valence') }}
        </th>
        <td class="px-6 py-6">
            {{ $audioFeatures->valence }}
        </td>
    </tr>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ __('Tempo') }}
        </th>
        <td class="px-6 py-6">
            {{ $audioFeatures->tempo }}
        </td>
    </tr>
    </tbody>
</table>
