<div>
    <x-slot:title>
        {{ __('Contact us') }}
    </x-slot:title>

    <div class="bg-white max-w-7xl mx-auto py-16 px-6 sm:py-24 sm:px-8">
        <div class="gap-12 justify-between lg:flex">
            <div class="max-w-lg space-y-3">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('Let us know how we can help') }}
                </h1>
                <p>
                    {{ __('We’re here to help and answer any question you might have, We look forward to hearing from you! Please fill out the form, or use the contact information bellow.') }}
                </p>
                <div>
                    <ul class="mt-6 flex flex-wrap gap-x-10 gap-y-6 items-center">
                        @if($generalSettings->contact_email)
                            <li class="flex items-center gap-x-3">
                                <div class="flex-none text-gray-400">
                                    <x-heroicon-o-envelope class="w-6 h-6" />
                                </div>
                                <p>
                                    {{ $generalSettings->contact_email }}
                                </p>
                            </li>
                        @endif

                        @if($generalSettings->contact_phone)
                            <li class="flex items-center gap-x-3">
                                <div class="flex-none text-gray-400">
                                    <x-heroicon-o-phone class="w-6 h-6" />
                                </div>
                                <p>
                                    {{ $generalSettings->contact_phone }}
                                </p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="flex-1 sm:max-w-lg lg:max-w-md">
                <form
                    wire:submit.prevent="sendMessage"
                    class="space-y-5"
                >
                    <div>
                        <x-input-label
                            for="nameInput"
                            :value="__('Your full name')"
                        />
                        <x-input
                            wire:model.defer="state.name"
                            id="nameInput"
                            class="block mt-1 w-full sm:text-sm"
                            type="text"
                            required
                        />
                        <x-input-error
                            for="state.name"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="emailInput"
                            :value="__('Email address')"
                        />
                        <x-input
                            wire:model.defer="state.email"
                            id="emailInput"
                            class="block mt-1 w-full sm:text-sm"
                            type="email"
                            required
                        />
                        <x-input-error
                            for="state.email"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="phoneInput"
                            :value="__('Phone number')"
                        />
                        <x-input
                            wire:model.defer="state.phone"
                            id="phoneInput"
                            class="block mt-1 w-full sm:text-sm"
                            type="text"
                            required
                        />
                        <x-input-error
                            for="state.phone"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="messageInput"
                            :value="__('Message')"
                        />
                        <x-textarea
                            wire:model.defer="state.message"
                            id="messageInput"
                            class="block mt-1 w-full sm:text-sm"
                            rows="4"
                            required
                        />
                        <x-input-error
                            for="state.message"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <button class="btn btn-primary btn-lg block w-full">
                            {{ __('Send message') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
