<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('registration.registration')]) }}
        </h2>
    </x-slot>

    <!-- schedules -->
    <div class="w-80pc h-50pc mx-auto mt-4">
        <div class="w-full h-50pc">
            <div>
                {{ 
                    __('schedule.schedule') . ' | ' . __('schedule.on_date') . ': ' . $schedule->on_date . '; '
                     . __('vaccine.vaccine') . ': ' . $schedule->vaccineLot->vaccine->name . '; '
                     . __('vaccine-lot.vaccine_lot') . ': ' . $schedule->vaccineLot->lot
                }}
            </div>
            <div>
                {{
                    __('schedule.day_shift') . ': ' . $schedule->day_shift . '; '
                    . __('schedule.noon_shift') . ': ' . $schedule->noon_shift . '; '
                    . __('schedule.night_shift') . ': ' . $schedule->night_shift
                }}
            </div>
            <!-- FILTER -->
            <div>
                {{ __('component.filter') . ' ' . __('schedule.schedule') }}
            </div>
            <form method="GET" action="{{ route('schedules.show', $schedule->id) }}">
                <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
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
                                    <option value="{{ $value }}">{{ __('registration.status.' . $value) }}
                                    </option>
                                @endif
                            @endforeach
                            <option value=""></option>
                            @foreach ($registrationStatuses::allCases() as $properties => $value)
                                @if ($value != $attributes->status)
                                    <option value="{{ $value }}">{{ __('registration.status.' . $value) }}
                                    </option>
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
                        href="{{ route('schedules.show', $schedule->id) }}">{{ __('btn.clear_filter') }}</a>
                </div>
            </form>
            <br>
            <div class="mx-auto overflow-x-scroll">
                <table class="table table-responsive table-hover w-full">
                    <thead>
                        <tr>
                            <th class="text-center text-truncate">
                                #
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('user.full_name') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('user.gender') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('user.pid') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('user.birthday') }}
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
                                {{ __('registration.status.status') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('btn.update', ['object' => __('registration.status.status')]) }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($registrations as $registration)
                            <td class="text-left text-truncate">
                                {{ ++$i }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $registration->full_name }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $registration->gender }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $registration->pid }}
                            </td>
                            <td class="text-left text-truncate">
                                {{ $registration->birthday }}
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
                            <td class="text-center">
                                {{ __('registration.status.' . $registration->pivot->status) }}
                            </td>
                            <td>
                                <div class="flex justify-center flex-gap-3px">
                                    @switch ($registration->pivot->status)
                                        @case ($registrationStatuses::REGISTERED)
                                            <form method="POST"
                                                action="{{ route('schedules.registrations.update', $registration->pivot->id) }}">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="status" value="{{ $registrationStatuses::CHECKED_IN }}">
                                                <input class="btn btn-success color-success" type="submit"
                                                    value="{{ __('registration.status.' . $registrationStatuses::CHECKED_IN) }}"
                                                    onclick="return confirm(trans('message.confirm', {'action': trans('btn.update', {'object': ''})}))" />
                                            </form>
                                            <form method="POST"
                                                action="{{ route('schedules.registrations.update', $registration->pivot->id) }}">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="status" value="{{ $registrationStatuses::CANCELED }}">
                                                <input class="btn btn-danger color-danger" type="submit"
                                                    value="{{ __('registration.status.' . $registrationStatuses::CANCELED) }}"
                                                    onclick="return confirm(trans('message.confirm', {'action': trans('btn.update', {'object': ''})}))" />
                                            </form>
                                        @break

                                        @case ($registrationStatuses::CHECKED_IN)
                                            <form method="POST"
                                                action="{{ route('schedules.registrations.update', $registration->pivot->id) }}">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="status" value="{{ $registrationStatuses::SHOT }}">
                                                <input class="btn btn-success color-success" type="submit"
                                                    value="{{ __('registration.status.' . $registrationStatuses::SHOT) }}"
                                                    onclick="return confirm(trans('message.confirm', {'action': trans('btn.update', {'object': ''})}))" />
                                            </form>
                                            <form method="POST"
                                                action="{{ route('schedules.registrations.update', $registration->pivot->id) }}">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="status" value="{{ $registrationStatuses::CANCELED }}">
                                                <input class="btn btn-danger color-danger" type="submit"
                                                    value="{{ __('registration.status.' . $registrationStatuses::CANCELED) }}"
                                                    onclick="return confirm(trans('message.confirm', {'action': trans('btn.update', {'object': ''})}))" />
                                            </form>
                                        @break

                                        @default
                                    @endswitch
                                </div>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $registrations->links() }}
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
