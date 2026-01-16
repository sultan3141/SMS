<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Profile Form --}}
        <div>
            <form wire:submit="updateProfile">
                {{ $this->form }}
                
                <div class="mt-6">
                    <x-filament::button type="submit">
                        Update Profile
                    </x-filament::button>
                </div>
            </form>
        </div>

        {{-- Password Form --}}
        <div>
            <x-filament::section>
                <x-slot name="heading">
                    Change Password
                </x-slot>
                <x-slot name="description">
                    Update your login credentials
                </x-slot>

                <form wire:submit="updatePassword">
                    <div class="space-y-4">
                        <x-filament::input.wrapper>
                            <x-filament::input
                                type="password"
                                wire:model="passwordData.current_password"
                                placeholder="Current Password"
                            />
                        </x-filament::input.wrapper>

                        <x-filament::input.wrapper>
                            <x-filament::input
                                type="password"
                                wire:model="passwordData.new_password"
                                placeholder="New Password"
                            />
                        </x-filament::input.wrapper>

                        <x-filament::input.wrapper>
                            <x-filament::input
                                type="password"
                                wire:model="passwordData.new_password_confirmation"
                                placeholder="Confirm New Password"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div class="mt-6">
                        <x-filament::button type="submit" color="warning">
                            Change Password
                        </x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
