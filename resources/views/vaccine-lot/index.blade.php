<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('vaccine-lot.vaccine_lot')]) }}
        </h2>
    </x-slot>

    <!-- vaccineLot -->
    <div class="w-60pc h-50pc mx-auto">
        <div class="mx-auto my-3">
            <!-- FILTER -->
            <div>
                {{ __('component.filter') . ' ' . __('vaccine-lot.vaccine_lot') }}
            </div>
            <form method="GET" action="{{ route('vaccine-lots.index') }}">
                <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
                    <!-- Vaccine name -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="vaccine_id" :value="__('vaccine.vaccine')" />
                        <select name="vaccine_id" id="vaccine_id" class="block mt-1 w-full">
                            @foreach ($vaccines as $vaccine)
                                @if ($vaccine->id == $attributes->vaccine_id)
                                    <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                                @endif
                            @endforeach

                            <option value=""></option>

                            @foreach ($vaccines as $vaccine)
                                @if ($vaccine->id != $attributes->vaccine_id)
                                    <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- quantity -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="quantity" :value="__('vaccine-lot.quantity')" />
                        <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity"
                            :value="$attributes->quantity" />
                    </div>

                    <!-- From date -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="import_date" :value="__('vaccine-lot.import_date')" />
                        <x-input id="import_date" class="block mt-1 w-full" type="date" name="import_date"
                            :value="$attributes->import_date" />
                    </div>

                    <!-- To date -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="expiry_date" :value="__('vaccine-lot.expiry_date')" />
                        <x-input id="expiry_date" class="block mt-1 w-full" type="date" name="expiry_date"
                            :value="$attributes->expiry_date" />
                    </div>

                    {{-- Apply --}}
                    <x-button>
                        {{ __('btn.apply') }}
                    </x-button>

                    {{-- Clear --}}
                    <a class="btn btn-secondary"
                        href="{{ route('vaccine-lots.index') }}">{{ __('btn.clear_filter') }}</a>
            </form>
        </div>

        <a class="btn btn-primary my-3"
            href="{{ route('vaccine-lots.create') }}">{{ __('btn.import', ['object' => __('vaccine-lot.vaccine_lot')]) }}</a>
        <a class="btn btn-secondary my-3"
            href="{{ route('vaccine-lots.trashed') }}">{{ __('object.deactivated', ['object' => __('vaccine-lot.vaccine_lot')]) }}</a>
        <div class="mx-auto overflow-x-scroll">
            <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
                <thead>
                    <tr>
                        <th class="text-center text-truncate">#</th>
                        <th class="text-center text-truncate">{{ __('vaccine.name') }}</th>
                        <th class="text-center text-truncate">{{ __('vaccine-lot.lot') }}</th>
                        <th class="text-center text-truncate">{{ __('vaccine-lot.quantity') }}</th>
                        <th class="text-center text-truncate">{{ __('vaccine-lot.import_date') }}</th>
                        <th class="text-center text-truncate">{{ __('vaccine-lot.expiry_date') }}</th>
                        <th class="text-center text-truncate">{{ __('btn.action') }}</th>
                    </tr>
                </thead>
                @foreach ($vaccineLots as $index => $vaccineLot)
                    <tbody>
                        <tr>
                            <td class="text-center text-truncate">{{ ++$index }}</td>
                            <td class="text-left text-truncate">{{ $vaccineLot->vaccine->name }}</td>
                            <td class="text-left text-truncate">{{ $vaccineLot->lot }}</td>
                            <td class="text-right text-truncate">{{ $vaccineLot->quantity }}</td>
                            <td class="text-center text-truncate">{{ $vaccineLot->import_date }}</td>
                            <td class="text-center text-truncate">{{ $vaccineLot->expiry_date }}</td>
                            <td>
                                <div class="flex justify-center flex-gap-3px">
                                    <a class="btn btn-secondary"
                                        href="{{ route('vaccine-lots.edit', $vaccineLot->id) }}">{{ __('btn.edit', ['object' => '']) }}</a>
                                    <form method="POST" action="{{ route('vaccine-lots.destroy', $vaccineLot->id) }}">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" class="btn btn-danger color-danger"
                                            value="{{ __('btn.delete') }}"
                                            onclick="return confirm(trans('message.confirm', {'action': trans('btn.delete')}))" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $vaccineLots->links() }}
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
</x-app-layout>
<script>
    window.translations = {!! $translation !!}
</script>
