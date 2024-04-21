<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('business.business')]) }}
        </h2>
    </x-slot>

    <div class="w-80pc h-50pc mx-auto">
        <div class="w-full h-50pc">
            <!-- FILTER -->
            <div>
                {{ __('component.filter') . ' ' . __('business.business') }}
            </div>
            <form method="GET" action="{{ route('businesses.index') }}">
                <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
                    <!-- Province Name -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="addr_province" :value="__('user.province')" />
                        <select name="addr_province" id="addr_province" class="block mt-1 w-full"
                            value="{{ $attributes->addr_province }}">
                        </select>
                    </div>

                    <!-- District Name -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="addr_district" :value="__('user.district')" />
                        <select name="addr_district" id="addr_district" class="block mt-1 w-full"
                            value="{{ $attributes->addr_district }}">
                        </select>
                    </div>

                    <!-- Ward Name -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="addr_ward" :value="__('user.ward')" />
                        <select name="addr_ward" id="addr_ward" class="block mt-1 w-full"
                            value="{{ $attributes->addr_ward }}">
                        </select>
                    </div>

                    {{-- Apply --}}
                    <div>
                        <button id="btn_apply_business_filter" class="btn btn-secondary">
                            {{ __('btn.apply') }}
                        </button>
                    </div>

                    {{-- Clear --}}
                    <a class="btn btn-secondary" href="{{ route('businesses.index') }}">{{ __('btn.clear_filter') }}</a>
                </div>
            </form>

            <a class="btn btn-primary text-truncate my-3"
                href="{{ route('businesses.create') }}">{{ __('btn.create', ['object' => __('account.account')]) }}</a>
            <a class="btn btn-secondary text-truncate my-3"
                href="{{ route('businesses.trashed') }}">{{ __('object.deactivated', ['object' => __('account.account')]) }}</a>

            <div class="overflow-x-scroll">
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
                                                onclick="confirm(trans('message.confirm', {'action': trans('btn.delete')}))">{{ __('btn.delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $businesses->links() }}
            <br>
            @switch (Session::get('status'))
                @case ($actionStatuses::WARNING)
                    <div class="alert alert-warning">
                        <ul>
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @break

                @case ($actionStatuses::ERROR)
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @break

                @case ($actionStatuses::SUCCESS)
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @break
            @endswitch
        </div>
    </div>
</x-app-layout>
<script>
    window.translations = {!! $translation !!}
</script>
<script src="{{ asset('js/getLocalRegion.js') }}" defer></script>
