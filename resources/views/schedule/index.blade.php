<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('schedule.schedule')]) }}
        </h2>
    </x-slot>

    <!-- schedules -->
    <div class="w-full h-50pc">
        <a class="btn btn-primary my-3" href="{{ route('schedules.create') }}">{{ __('btn.create', ['object' => __('schedule.schedule')]) }}</a>
        <a class="btn btn-secondary my-3" href="{{ route('schedules.trashed') }}">{{ __('btn.canceled', ['object' => __('schedule.schedule')]) }}</a>

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
                        <a href="{{ route('schedules.edit', $schedule->id) }}">{{ __('btn.edit', ['object' => '']) }}</a>
                        <p>&nbsp/&nbsp</p>
                        <form method="POST" action="{{ route('schedules.destroy', $schedule->id) }}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="{{ __('btn.delete') }}" onclick="confirm('Are you sure you want to delete?')">
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
