<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('object.list', ['object' => __('vaccine.vaccine')]) }}
        </h2>
    </x-slot>

    <div class="w-60pc h-50pc mx-auto">
        <div class="mx-auto my-3">
            <!-- FILTER -->
            <div>
                {{ __('component.filter') . ' ' . __('vaccine.vaccine') }}
            </div>
            <form method="GET" action="{{ route('vaccines.index') }}">
                <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
                    <!-- Vaccine name -->
                    <div class="min-w-150px max-w-30pc">
                        <x-label for="is_allow" :value="__('vaccine.is_allow')" />
                        <select name="is_allow" id="is_allow" class="block mt-1 w-full">
                            <option value=""></option>
                            <option value="1">{{ __('vaccine.allow') }}</option>
                            <option value="0">{{ __('vaccine.not_allow') }}</option>
                        </select>
                    </div>

                    {{-- Apply --}}
                    <x-button>
                        {{ __('btn.apply') }}
                    </x-button>

                    {{-- Clear --}}
                    <a class="btn btn-secondary" href="{{ route('vaccines.index') }}">{{ __('btn.clear_filter') }}</a>
            </form>
        </div>

        <!-- Vaccine -->
        <a class="btn btn-primary my-3"
            href="{{ route('vaccines.create') }}">{{ __('btn.import', ['object' => __('vaccine.vaccine')]) }}</a>
        <div class="mx-auto overflow-x-scroll">
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
                @foreach ($vaccines as $index => $vaccine)
                    <tr>
                        <td class="text-center">{{ ++$index }}</td>
                        <td class="text-left">{{ $vaccine->name }}</td>
                        <td class="text-left">{{ $vaccine->supplier }}</td>
                        <td class="text-left">{{ $vaccine->technology }}</td>
                        <td class="text-left">{{ $vaccine->country }}</td>
                        <td class="text-center">{{ $vaccine->is_allow }}</td>
                        <td>
                            <div class="flex justify-center flex-gap-3px">
                                <a class="btn btn-secondary"
                                    href="{{ route('vaccines.edit', $vaccine->id) }}">{{ __('btn.edit', ['object' => '']) }}</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{ $vaccines->links() }}
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
