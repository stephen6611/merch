<div>
    <!-- Meta title & description -->
    <x-slot:title>
        {!! __('Taxes and duties') !!}
    </x-slot:title>

    <!-- Page title & actions -->
    <div class="px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-2xl font-medium text-slate-900 dark:text-slate-100">
                {{ __('Taxes and duties') }}
            </h1>
        </div>
        @if($this->taxZones->count())
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <button
                    wire:click="$emitTo('employee.taxation.components.tax-zone-form', 'create')"
                    class="btn btn-primary block w-full order-0 sm:order-1 sm:ml-3"
                >
                    {{ __('Create tax zone') }}
                </button>
            </div>
        @endif
    </div>

    <!-- Page content -->
    <div class="p-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @unless($this->taxZones->count())
            <x-card>
                <x-slot:content>
                    <div class="max-w-lg mx-auto text-center">
                        <x-heroicon-o-scale class="mx-auto h-12 w-12 text-slate-400" />

                        <h3 class="mt-2 text-lg font-medium text-slate-900 dark:text-slate-200">
                            {{ __('No zones or rates') }}
                        </h3>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ __('Add zones to create rates for places you would like to apply taxes.') }}
                        </p>

                        <div class="mt-6">
                            <button
                                wire:click="$emitTo('employee.taxation.components.tax-zone-form', 'create')"
                                class="btn btn-primary"
                            >
                                {{ __('Create tax zone') }}
                            </button>
                        </div>
                    </div>
                </x-slot:content>
            </x-card>
        @else
            <x-card>
                <x-slot:header>
                    <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                        <div class="ml-4 mt-2">
                            <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-slate-200">
                                {{ __('Tax zones') }}
                            </h3>
                        </div>
                    </div>
                </x-slot:header>
                <x-slot:content class="-mt-5">
                    <div class="space-y-5">
                        @foreach($this->taxZones as $taxZone)
                            <div>
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-slate-900 text-sm dark:text-slate-200">
                                        {{ $taxZone->name }}
                                    </p>
                                    <div class="ml-5">
                                        <x-dropdown>
                                            <x-slot:trigger>
                                                <button class="block text-slate-500 hover:text-slate-600 dark:hover:text-slate-400">
                                                    <x-heroicon-m-ellipsis-horizontal class="w-5 h-5" />
                                                </button>
                                            </x-slot:trigger>
                                            <x-slot:content>
                                                <x-dropdown-link
                                                    wire:click="$emitTo('employee.taxation.components.tax-zone-form', 'edit', '{{ $taxZone->id }}')"
                                                    role="button"
                                                >
                                                    {{ __('Edit zone') }}
                                                </x-dropdown-link>
                                                <x-dropdown-link
                                                    wire:click.prevent="confirmTaxZoneDeletion('{{ $taxZone->id }}')"
                                                    role="button"
                                                >
                                                    <span class="text-red-600">{{ __('Delete') }}</span>
                                                </x-dropdown-link>
                                            </x-slot:content>
                                        </x-dropdown>
                                    </div>
                                </div>
                                <p class="pr-10 text-slate-500 text-sm dark:text-slate-400 line-clamp-1 hover:line-clamp-none">
                                    @foreach($taxZone->countries as $country)
                                        {{ $country->country->name }}{{ $loop->last ? '' : ',' }}
                                    @endforeach
                                </p>
                            </div>

                            @unless($taxZone->rates->count())
                                <x-alert
                                    type="warning"
                                    message="{{ __('No rates. Customers in this zone won’t be able to complete checkout.') }}"
                                    class="mt-4"
                                />
                            @else
                                <div class="flex flex-col">
                                    <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                            <table class="min-w-full divide-y divide-slate-300 dark:divide-slate-200/20">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            scope="col"
                                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6 md:pl-0 dark:text-slate-200"
                                                        >
                                                            {{ __('Rate name') }}
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="py-3.5 px-3 text-right text-sm font-semibold text-slate-900 dark:text-slate-200"
                                                        >
                                                            {{ __('Percentage') }}
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="relative py-3.5 pl-3 pr-4 text-left sm:pr-6 md:pr-0"
                                                        >
                                                            <span class="sr-only">{{ __('Edit') }}</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-200 dark:divide-slate-200/10">
                                                    @foreach($taxZone->rates as $taxRate)
                                                        <tr>
                                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-left text-sm font-medium text-slate-900 sm:pl-6 md:pl-0 dark:text-slate-200">
                                                                {{ $taxRate->name }}
                                                            </td>
                                                            <td class="whitespace-nowrap py-4 px-3 text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                                                {{ $taxRate->percentage }}%
                                                            </td>
                                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-left text-sm sm:pr-6 md:pr-0">
                                                                <div class="flex justify-end overflow-visible">
                                                                    <x-dropdown>
                                                                        <x-slot name="trigger">
                                                                            <button class="block text-gray-600 hover:text-gray-500">
                                                                                <x-heroicon-m-ellipsis-horizontal class="w-5 h-5" />
                                                                            </button>
                                                                        </x-slot>
                                                                        <x-slot name="content">
                                                                            <x-dropdown-link
                                                                                wire:click="$emitTo('employee.taxation.components.tax-rate-form', 'edit', '{{ $taxRate->id }}')"
                                                                                role="button"
                                                                            >
                                                                                {{ __('Edit rate') }}
                                                                            </x-dropdown-link>
                                                                            <x-dropdown-link
                                                                                wire:click="confirmTaxRateDeletion('{{ $taxRate->id }}')"
                                                                                role="button"
                                                                            >
                                                                                <span class="text-red-600">{{ __('Delete') }}</span>
                                                                            </x-dropdown-link>
                                                                        </x-slot>
                                                                    </x-dropdown>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endunless

                            <button
                                wire:click="$emitTo('employee.taxation.components.tax-rate-form', 'create', '{{ $taxZone->id }}')"
                                type="button"
                                class="block btn btn-outline-primary sm:text-sm"
                            >
                                {{ __('Add rate') }}
                            </button>

                            @unless($loop->last)
                                <hr class="-mx-4 sm:-mx-6 border-slate-200 dark:border-slate-200/10">
                            @endunless
                        @endforeach
                    </div>
                </x-slot:content>
            </x-card>
        @endunless
    </div>

    <x-modal-alert wire:model.defer="confirmingTaxZoneDeletion">
        <x-slot:title>
            {{ __('Delete tax zone') }}
        </x-slot:title>
        <x-slot:content>
            <p>{{ __('Are you sure you want to delete this tax zone?') }}</p>
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click="deleteTaxZone"
                wire:loading.attr="disabled"
                type="button"
                class="btn btn-danger w-full sm:ml-3 sm:w-auto"
            >
                {{ __('Delete') }}
            </button>
            <button
                wire:click.prevent="$set('confirmingTaxZoneDeletion', false)"
                type="button"
                class="btn btn-invisible w-full mt-3 sm:mt-0 sm:w-auto"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <x-modal-alert wire:model.defer="confirmingTaxRateDeletion">
        <x-slot:title>
            {{ __('Delete tax rate') }}
        </x-slot:title>
        <x-slot:content>
            <p>{{ __('Are you sure you want to delete this tax rate?') }}</p>
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click="deleteTaxRate"
                wire:loading.attr="disabled"
                type="button"
                class="btn btn-danger w-full sm:ml-3 sm:w-auto"
            >
                {{ __('Delete') }}
            </button>
            <button
                wire:click.prevent="$set('confirmingTaxRateDeletion', false)"
                type="button"
                class="btn btn-invisible w-full mt-3 sm:mt-0 sm:w-auto"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <livewire:employee.taxation.components.tax-zone-form />

    <livewire:employee.taxation.components.tax-rate-form />
</div>
