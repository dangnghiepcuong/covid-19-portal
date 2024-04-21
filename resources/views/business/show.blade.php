<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('btn.view') . ' ' . __('business.business') }}
        </h2>
    </x-slot>
    <div class="w-80pc min-w-600px mx-auto">
        <div class="mt-4 flex justify-between overflow-hidden flex-h-full">
            <!-- Profile -->
            <div class="w-full mx-2 min-w-400px max-w-30pc">
                <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('business.business') }}
                </h3>
                <div class="flex justify-between overflow-hidden flex-warp">
                    <div class="w-full mr-2">
                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('account.email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="$account->email" required />
                        </div>
                        @include('business.profile')
                    </div>
                </div>
            </div>

            <div class="w-full mx-2 min-w-600px max-w-65pc overflow-x-scroll">

                <!-- Vaccine Table -->
                <div class="w-full">
                    <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('vaccine.vaccine') }}
                    </h3>
                    <table class="w-full min-w-500px mt-2 table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center text-truncate">#</th>
                                <th class="text-center text-truncate">{{ __('vaccine.name') }}</th>
                                <th class="text-center text-truncate">{{ __('vaccine.lot') }}</th>
                                <th class="text-center text-truncate">{{ __('vaccine.quantity') }}</th>
                                <th class="text-center text-truncate">{{ __('vaccine.import_date') }}</th>
                                <th class="text-center text-truncate">{{ __('vaccine.expiry_date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($vaccineLots as $vaccineLot)
                                <tr>
                                    <td class="text-left text-truncate">{{ ++$i }}</td>
                                    <td class="text-left text-truncate">{{ $vaccineLot->vaccine->name }}</td>
                                    <td class="text-left text-truncate">{{ $vaccineLot->lot }}</td>
                                    <td class="text-left text-truncate">{{ $vaccineLot->quantity }}</td>
                                    <td class="text-left text-truncate">{{ $vaccineLot->import_date }}</td>
                                    <td class="text-left text-truncate">{{ $vaccineLot->expiry_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $vaccineLots->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/getLocalRegion.js') }}" defer></script>
