<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('vaccine-lot.vaccine_lot')]) }}
        </h2>
    </x-slot>

    <!-- vaccineLot -->
    <div class="w-full h-50pc">
        <a class="btn btn-primary my-3" href="{{ route('vaccine-lots.create') }}">{{ __('btn.import', ['object' => __('vaccine-lot.vaccine_lot')]) }}</a>
        <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">{{ __('vaccine-lot.id') }}</th>
                <th class="text-center">{{ __('vaccine-lot.lot') }}</th>
                <th class="text-center">{{ __('vaccine-lot.quantity') }}</th>
                <th class="text-center">{{ __('vaccine-lot.import_date') }}</th>
                <th class="text-center">{{ __('vaccine-lot.expiry_date') }}</th>
                <th class="text-center">{{ __('btn.action') }}</th>
            </tr>
            @php
            $i = 0;
            @endphp
            @foreach ($vaccineLots as $vaccineLot)
            <tr>
                <td class="text-center">{{ ++$i }}</td>
                <td class="text-center">{{ $vaccineLot->name }}</td>
                <td class="text-center">{{ $vaccineLot->lot }}</td>
                <td class="text-center">{{ $vaccineLot->quantity }}</td>
                <td class="text-center">{{ $vaccineLot->import_date }}</td>
                <td class="text-center">{{ $vaccineLot->expiry_date }}</td>
                <td class="flex justify-center">
                    <a href="{{ route('vaccine-lots.edit', $vaccineLot->id) }}">{{ __('btn.edit') }}</a>
                    <p>&nbsp/&nbsp</p>
                    <form method="POST" action="{{ route('vaccine-lots.destroy', $vaccineLot->id) }}">
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
                <li>{{ __('message.success', ['action' => __('btn.delete')]) }}</li>
            </ul>
        </div>
        @endif
    </div>
</x-app-layout>