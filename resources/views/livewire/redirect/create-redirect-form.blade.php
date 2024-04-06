<?php

use Livewire\Volt\Component;
use Illuminate\Validation\ValidationException;

new class extends Component {
    public string $path = '';
    public string $redirect_url = '';


    public function saveRedirect(): void
    {
        try {
            $validated = $this->validate([
                'path' => [
                    'required',
                    'string',
                    'unique:redirect_data,origin_url'
                ],
                'redirect_url' => [
                    'required',
                    'string',
                    'url:http,https'
                ]
            ]);
        } catch (ValidationException $e) {
            $this->reset('path', 'redirect_url');

            throw $e;
        }

        \App\Models\RedirectData::create([
            'origin_url' => $validated['path'],
            'destination_url' => $validated['redirect_url'],
            'user_id' => auth()->id()
        ]);

        $this->reset('path', 'redirect_url');

        $this->redirect('/profile/dashboard', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            URL kürzen
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Dies könnte eine Beschreibung sein.
        </p>
    </header>

    <form wire:submit="saveRedirect" class="mt-6 space-y-6">
        <div>
            <x-input-label for="path" :value="__('URL Path')"/>
            <x-text-input wire:model="path" id="path" name="path" type="text" class="mt-1 block w-full"/>
            <x-input-error :messages="$errors->get('path')" class="mt-2"/>
        </div>

        <div>
            <x-input-label for="redirect_url" :value="__('Redirect URL')"/>
            <x-text-input wire:model="redirect_url" id="redirect_url" name="redirect_url" type="text"
                          class="mt-1 block w-full"/>
            <x-input-error :messages="$errors->get('redirect_url')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
