<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('vaccine.vaccine')]) }}
        </h2>
    </x-slot>

    <!-- Vaccine -->
    <div class="w-full h-50pc">
        <a class="btn btn-primary my-3" href="{{ route('vaccines.create') }}">{{ __('btn.import', ['object' => __('vaccine.vaccine')]) }}</a>
        <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">{{ __('vaccine.name') }}</th>
                <th class="text-center">{{ __('vaccine.supplier') }}</th>
                <th class="text-center">{{ __('vaccine.technology') }}</th>
                <th class="text-center">{{ __('vaccine.country') }}</th>
                <th class="text-center">{{ __('vaccine.is_allow') }}</th>
                <th class="text-center">{{ __('btn.action') }}</th>
            </tr>
            @php
                $i = 0;
            @endphp
            @foreach ($vaccines as $vaccine)
                <tr>
                    <td class="text-center">{{ ++$i }}</td>
                    <td class="text-center">{{ $vaccine->name }}</td>
                    <td class="text-center">{{ $vaccine->supplier }}</td>
                    <td class="text-center">{{ $vaccine->technology }}</td>
                    <td class="text-center">{{ $vaccine->country }}</td>
                    <td class="text-center">{{ $vaccine->is_allow }}</td>
                    <td class="flex justify-center">
                        <a href="{{ route('vaccines.edit', $vaccine->id) }}">{{ __('btn.edit', ['object' => '']) }}</a>
                        <p>&nbsp/&nbsp</p>
                        <form method="POST" action="{{ route('vaccines.destroy', $vaccine->id) }}">
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
