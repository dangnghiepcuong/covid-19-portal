<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('business.business')]) }}
        </h2>
    </x-slot>
    <a class="btn btn-primary my-3" href="{{ route('businesses.create') }}">{{ __('btn.create', ['object' => __('account.account')]) }}</a>

    <table class="table table-hover">
        <tr>
            <th class="text-center">
                #
            </th>
            <th class="text-center">
                {{ __('business.tax_id') }}
            </th>
            <th class="text-center">
                {{ __('business.name') }}
            </th>
            <th class="text-center">
                {{ __('business.province') }}
            </th>
            <th class="text-center">
                {{ __('business.district') }}
            </th>
            <th class="text-center">
                {{ __('business.ward') }}
            </th>
            <th class="text-center">
                {{ __('btn.action') }}
            </th>
        </tr>
        @php
        $i = 0;
        @endphp
        @if ($businesses !== null)
        @foreach ($businesses as $business)
        <tr>
            <td class="text-center">
                {{ $i++; }}
            </td>
            <td class="text-center">
                {{ $business->tax_id }}
            </td>
            <td class="text-center">
                {{ $business->name }}
            </td>
            <td class="text-center">
                {{ $business->addr_province }}
            </td>
            <td class="text-center">
                {{ $business->addr_district }}
            </td>
            <td class="text-center">
                {{ $business->addr_ward }}
            </td>
            <td class="flex justify-center">
                <a href="{{ route('businesses.show', $business->id) }}">{{ __('btn.view') }}</a>
                <p>&nbsp/&nbsp</p>
                <a href="{{ route('businesses.edit', $business->id) }}">{{ __('btn.edit') }}</a>
                <p>&nbsp/&nbsp</p>
                <form method="POST" action="{{ route('businesses.destroy', $business->id) }}">
                    @csrf
                    @method('delete')
                    <input type="submit" value="{{ __('btn.delete') }}" onclick="confirm('Are you sure you want to delete?')">
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
</x-app-layout>