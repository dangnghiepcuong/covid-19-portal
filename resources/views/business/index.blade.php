<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('business.business')]) }}
        </h2>
    </x-slot>

    <div class="my-3">
        <a class="btn btn-primary text-truncate my-1"
            href="{{ route('businesses.create') }}">{{ __('btn.create', ['object' => __('account.account')]) }}</a>
        <a class="btn btn-secondary text-truncate my-1"
            href="{{ route('businesses.trashed') }}">{{ __('object.deactivated', ['object' => __('account.account')]) }}</a>
    </div>

    <div class="h-600px overflow-x-scroll">
        <table class="table table-responsive table-hover w-full">
            <thead>
                <tr>
                    <th class="text-center text-truncate">
                        #
                    </th>
                    <th class="text-center text-truncate">
                        {{ __('account.account') }}
                    </th>
                    <th class="text-center text-truncate">
                        {{ __('business.tax_id') }}
                    </th>
                    <th class="text-center text-truncate">
                        {{ __('business.name') }}
                    </th>
                    <th class="text-center text-truncate">
                        {{ __('business.province') }}
                    </th>
                    <th class="text-center text-truncate">
                        {{ __('business.district') }}
                    </th>
                    <th class="text-center text-truncate">
                        {{ __('business.ward') }}
                    </th>
                    <th class="text-center text-truncate">
                        {{ __('btn.action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($businesses !== null)
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($businesses as $business)
                        <tr>
                            <td class="text-left text-truncate">
                                {{ ++$i }}
                            </td>
                            <th class="text-left text-truncate">
                                {{ $business->account->email }}
                            </th>
                            <td class="text-left text-truncate">
                                {{ $business->tax_id }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $business->name }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $business->addr_province }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $business->addr_district }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $business->addr_ward }}
                            </td>
                            <td class="flex justify-center flex-gap-3px">
                                <a class="btn btn-primary"
                                    href="{{ route('businesses.show', $business->id) }}">{{ __('btn.view') }}</a>
                                <a class="btn btn-secondary"
                                    href="{{ route('businesses.edit', $business->id) }}">{{ __('btn.edit', ['object' => '']) }}</a>
                                <form method="POST" action="{{ route('businesses.destroy', $business->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger color-danger" type="submit"
                                        onclick="confirm('Are you sure you want to delete?')">{{ __('btn.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @if (Session::get('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ __('message.success', ['action' => __('btn.delete')]) }}</li>
            </ul>
        </div>
    @endif
</x-app-layout>
