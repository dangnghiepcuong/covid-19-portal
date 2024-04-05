<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.deactivated', ['object' => __('vaccine-lot.vaccine_lot')]) }}
        </h2>
    </x-slot>

    <!-- vaccineLot -->
    <div class="w-full h-50pc">
        <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">{{ __('vaccine.name') }}</th>
                <th class="text-center">{{ __('vaccine-lot.lot') }}</th>
                <th class="text-center">{{ __('vaccine-lot.quantity') }}</th>
                <th class="text-center">{{ __('vaccine-lot.import_date') }}</th>
                <th class="text-center">{{ __('vaccine-lot.expiry_date') }}</th>
                <th class="text-center">{{ __('object.trashed', ['object' => '']) }}</th>
                <th class="text-center">{{ __('btn.action') }}</th>
            </tr>
            @php
            $i = 0;
            @endphp
            @foreach ($vaccineLots as $vaccineLot)
            <tr>
                <td class="text-center">{{ ++$i }}</td>
                <td class="text-center">{{ $vaccineLot->vaccine->name }}</td>
                <td class="text-center">{{ $vaccineLot->lot }}</td>
                <td class="text-center">{{ $vaccineLot->quantity }}</td>
                <td class="text-center">{{ $vaccineLot->import_date }}</td>
                <td class="text-center">{{ $vaccineLot->expiry_date }}</td>
                <td class="text-center">{{ $vaccineLot->deleted_at }}</td>
                <td class="flex justify-center">
                    <form method="POST" action="{{ route('vaccine-lots.restore', $vaccineLot->id) }}">
                        @csrf
                        @method('post')
                        <input type="submit" value="{{ __('btn.restore') }}" onclick="confirm('Are you sure you want to restore?')">
                    </form>
                    <p>&nbsp/&nbsp</p>
                    <form method="POST" action="{{ route('vaccine-lots.permanently-delete', $vaccineLot->id) }}">
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
                <li>{{ __('message.success', ['action' => __('btn.delete')]) }}</li>
            </ul>
        </div>
        @endif
    </div>
</x-app-layout>
