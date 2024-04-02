<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('business.business')]) }}
        </h2>
    </x-slot>
    <a class="btn btn-primary my-3" href="{{ route('businesses.create') }}">{{ __('btn.create', ['object' => __('account.account')]) }}</a>

    <table class="table table-hover">
        <tr>
            <th>
                #
            </th>
            <th>
                {{ __('business.tax_id') }}
            </th>
            <th>
                {{ __('business.name') }}
            </th>
            <th>
                {{ __('business.province') }}
            </th>
            <th>
                {{ __('business.district') }}
            </th>
            <th>
                {{ __('business.ward') }}
            </th>
            <th>
                {{ __('btn.action') }}
            </th>
        </tr>
        @php
        $i = 0;
        @endphp
        @if ($businesses !== null)
        @foreach ($businesses as $business)
        <tr>
            <td>
                {{ $i++; }}
            </td>
            <td>
                {{ $business->tax_id }}
            </td>
            <td>
                {{ $business->name }}
            </td>
            <td>
                {{ $business->addr_province }}
            </td>
            <td>
                {{ $business->addr_district }}
            </td>
            <td>
                {{ $business->addr_ward }}
            </td>
            <td>
                <a href="{{ route('businesses.show', $business->id) }}">{{ __('btn.view') }}</a>
                /
                <a href="{{ route('businesses.edit', $business->id) }}">{{ __('btn.edit') }}</a>
                /
                <a href="{{ route('businesses.destroy', $business->id) }}" onclick="confirm('Are you sure you want to delete?')">{{ __('btn.delete') }}</a>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
</x-app-layout>
