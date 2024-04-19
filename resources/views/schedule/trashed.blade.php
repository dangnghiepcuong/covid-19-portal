<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.trashed', ['object' => __('schedule.schedule')]) }}
        </h2>
    </x-slot>
   
    <!-- schedules -->
    <div class="w-60pc h-50pc mx-auto">
        <div class="w-full h-50pc">
            <!-- FILTER -->
            <div>
                {{ __('component.filter') . ' ' . __('schedule.schedule') }}
            </div>
            <form method="GET" action="{{ route('schedules.trashed') }}">
                <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
                    <!-- From date -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="from_date" :value="__('schedule.from_date')" />
                        <x-input id="from_date" class="block mt-1 w-full" type="date" name="from_date"
                            :value="$attributes->from_date" />
                    </div>

                    <!-- To date -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="to_date" :value="__('schedule.to_date')" />
                        <x-input id="to_date" class="block mt-1 w-full" type="date" name="to_date"
                            :value="$attributes->to_date" />
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

                    {{-- Apply --}}
                    <x-button>
                        {{ __('btn.apply') }}
                    </x-button>

                    {{-- Clear --}}
                    <a class="btn btn-secondary"
                        href="{{ route('schedules.trashed') }}">{{ __('btn.clear_filter') }}</a>
                </div>
            </form>
        
            <br>
        
            <div class="mx-auto overflow-x-scroll">
                <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center text-truncate">#</th>
                            <th class="text-center text-truncate">{{ __('schedule.on_date') }}</th>
                            <th class="text-center text-truncate">{{ __('vaccine.name') }}</th>
                            <th class="text-center text-truncate">{{ __('vaccine-lot.vaccine_lot') }}</th>
                            <th class="text-center text-truncate">{{ __('schedule.day_shift') }}</th>
                            <th class="text-center text-truncate">{{ __('schedule.noon_shift') }}</th>
                            <th class="text-center text-truncate">{{ __('schedule.night_shift') }}</th>
                            <th class="text-center text-truncate">{{ __('btn.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($schedules as $schedule)
                            <tr>
                                <td class="text-center text-truncate">{{ ++$i }}</td>
                                <td class="text-left text-truncate">{{ $schedule->on_date }}</td>
                                <td class="text-left text-truncate">{{ $schedule->vaccineLot->vaccine->name }}</td>
                                <td class="text-left text-truncate">{{ $schedule->vaccineLot->lot }}</td>
                                <td class="text-center text-truncate">{{ $schedule->day_shift }}</td>
                                <td class="text-center text-truncate">{{ $schedule->noon_shift }}</td>
                                <td class="text-center text-truncate">{{ $schedule->night_shift }}</td>
                                <td>
                                    <div class="flex justify-center flex-gap-3px">
                                        <form method="POST" action="{{ route('schedules.restore', $schedule->id) }}">
                                            @csrf
                                            @method('post')
                                            <input type="submit" class="btn btn-success color-success"
                                                value="{{ __('btn.restore') }}" 
                                                onclick="return confirm(trans('message.confirm', {'action': trans('btn.restore')}))">
                                        </form>
                                        <form method="POST" action="{{ route('schedules.permanently-delete', $schedule->id) }}">
                                            @csrf
                                            @method('delete')
                                            <input type="submit" class="btn btn-danger color-danger"
                                                value="{{ __('btn.delete') }}" 
                                                onclick="return confirm(trans('message.confirm', {'action': trans('btn.delete')}))">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $schedules->links() }}
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
