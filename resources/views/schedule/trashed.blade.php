<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.canceled', ['object' => __('schedule.schedule')]) }}
        </h2>
    </x-slot>

    <!-- schedules -->
    <div class="w-full h-50pc">
        <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">{{ __('schedule.on_date') }}</th>
                <th class="text-center">{{ __('vaccine.name') }}</th>
                <th class="text-center">{{ __('vaccine-lot.vaccine_lot') }}</th>
                <th class="text-center">{{ __('schedule.day_shift') }}</th>
                <th class="text-center">{{ __('schedule.noon_shift') }}</th>
                <th class="text-center">{{ __('schedule.night_shift') }}</th>
                <th class="text-center">{{ __('btn.action') }}</th>
            </tr>
            @php
            $i = 0;
            @endphp
            @foreach ($schedules as $schedule)
            <tr>
                <td class="text-center">{{ ++$i }}</td>
                <td class="text-center">{{ $schedule->on_date }}</td>
                <td class="text-center">{{ $schedule->vaccineLot->vaccine->name }}</td>
                <td class="text-center">{{ $schedule->vaccineLot->lot }}</td>
                <td class="text-center">{{ $schedule->day_shift }}</td>
                <td class="text-center">{{ $schedule->noon_shift }}</td>
                <td class="text-center">{{ $schedule->night_shift }}</td>
                <td class="flex justify-center">
                    <form method="POST" action="{{ route('schedules.restore', $schedule->id) }}">
                        @csrf
                        @method('post')
                        <input type="submit" value="{{ __('btn.restore') }}" onclick="confirm('Are you sure you want to restore?')">
                    </form>
                    <p>&nbsp/&nbsp</p>
                    <form method="POST" action="{{ route('schedules.permanently-delete', $schedule->id) }}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="{{ __('btn.delete') }}" onclick="confirm('Are you sure you want to permanently delete?')">
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        @if (Session::get('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ __('message.success', ['action' => __('btn.' . Session::get('action'))]) }}</li>
            </ul>
        </div>
        @endif
    </div>
</x-app-layout>