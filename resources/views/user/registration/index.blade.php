<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('registration.log') }}
        </h2>
    </x-slot>

    <div class="w-80pc mx-auto my-3">
        <!-- FILTER -->
        <div>
            {{ __('component.filter') . ' ' . __('registration.registration') }}
        </div>
        <form method="GET" action="{{ route('registrations.index') }}">
            <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
                <!-- From date -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="from_date" :value="__('schedule.from_date')" />
                    <x-input id="from_date" class="block mt-1 w-full" type="date" name="from_date" :value="$attributes->from_date" />
                </div>

                <!-- To date -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="to_date" :value="__('schedule.to_date')" />
                    <x-input id="to_date" class="block mt-1 w-full" type="date" name="to_date" :value="$attributes->to_date" />
                </div>

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

                <!-- shift -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="shift" :value="__('registration.shift')" />
                    <select name="shift" id="shift" class="w-full">
                        @foreach ($shifts::allCases() as $properties => $value)
                            @if ($value == $attributes->shift)
                                <option value="{{ $value }}">{{ __('schedule.' . $value) }}</option>
                            @endif
                        @endforeach

                        <option value=""></option>

                        @foreach ($shifts::allCases() as $properties => $value)
                            @if ($value != $attributes->shift)
                                <option value="{{ $value }}">{{ __('schedule.' . $value) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- status -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="status" :value="__('registration.status.status')" />
                    <select name="status" id="status" class="w-full">
                        @foreach ($registrationStatuses::allCases() as $properties => $value)
                            @if ($value == $attributes->status)
                                <option value="{{ $value }}">{{ __('registration.status.' . $value) }}</option>
                            @endif
                        @endforeach
                        <option value=""></option>
                        @foreach ($registrationStatuses::allCases() as $properties => $value)
                            @if ($value != $attributes->status)
                                <option value="{{ $value }}">{{ __('registration.status.' . $value) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {{-- Apply --}}
                <x-button>
                    {{ __('btn.apply') }}
                </x-button>

                {{-- Clear --}}
                <a class="btn btn-secondary"
                    href="{{ route('registrations.index') }}">{{ __('btn.clear_filter') }}</a>
            </div>
        </form>


        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="mx-auto my-3">
            <a class="btn btn-primary text-truncate my-1"
                href="{{ route('vaccination.index') }}">{{ __('btn.register') }}</a>
        </div>

        <div class="h-600px mx-auto overflow-x-scroll">
            <table class="table table-responsive table-hover w-full">
                <thead>
                    <tr>
                        <th class="text-center text-truncate">
                            #
                        </th>
                        <th class="text-center text-truncate min-w-300px">
                            {{ __('business.business') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('schedule.on_date') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('vaccine.vaccine') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('vaccine-lot.lot') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('registration.shift') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('registration.number_order') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('registration.status.status') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('btn.updated_at') }}
                        </th>
                        <th class="text-center text-truncate">
                            {{ __('btn.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($registrations as $registration)
                        <tr>
                            <td class="text-left text-truncate">
                                {{ ++$i }}
                            </td>
                            <th class="text-left">
                                {{ $registration->business->name .
                                    ' (' .
                                    $registration->business->addr_province .
                                    ', ' .
                                    $registration->business->addr_district .
                                    ', ' .
                                    $registration->business->addr_ward .
                                    ')' }}
                            </th>
                            <td class="text-left text-truncate">
                                {{ $registration->on_date }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $registration->vaccineLot->vaccine->name }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $registration->vaccineLot->lot }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ __('schedule.' . $registration->pivot->shift) }}
                            </td>
                            <td class="text-center text-truncate">
                                {{ $registration->pivot->number_order }}
                            </td>
                            <td class="text-center">
                                {{ __('registration.status.' . $registration->pivot->status) }}
                            </td>
                            <td class="text-center">
                                {{ $registration->updated_at }}
                            </td>
                            <td>
                                <div class="flex justify-center">
                                    @if ($registration->pivot->status == $registrationStatuses::REGISTERED)
                                        <form method="POST"
                                            action="{{ route('registrations.update', $registration->pivot->id) }}">
                                            @csrf
                                            @method('patch')
                                            <input class="btn btn-danger color-danger" type="submit"
                                                value="{{ __('btn.cancel') }}"
                                                onclick="return confirm(trans('message.confirm', {'action': trans('btn.cancel')}))" />
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $registrations->links() }}
        </div>
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
    window.lang = {!! '"' . $lang . '"' !!}
    window.translations = {!! $translation !!}
</script>
