<div
    class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5"
>
    @php
        $deviceMap = [
            'lampu1' => [
                'label' => 'Air Conditioner',
                'type' => 'toggle',
            ],
            'lampu2' => [
                'label' => 'Television',
                'type' => 'toggle',
            ],
            'lampu3' => [
                'label' => 'Outdoor Lighting',
                'type' => 'toggle',
            ],
            'lampu4' => [
                'label' => 'Open the Curtain',
                'type' => 'open-close',
            ],
            'lampu5' => [
                'label' => 'Open the Garage',
                'type' => 'open-close',
            ],
        ];
    @endphp

    @forelse ($devices as $device)
        @php
            $config = $deviceMap[$device->name] ?? null;
        @endphp

        <button
            type="button"
            onclick="toggleDevice({{ $device->id }})"
            id="device-{{ $device->id }}"
            class="w-full flex flex-col items-center gap-2 px-3 py-4 md:px-4 md:py-5 rounded-xl transition-all duration-300 hover:bg-white/10 active:scale-95 {{ $device->status ? 'text-green-400' : 'text-red-400' }} cursor-pointer"
        >
            <div class="flex flex-col justify-center items-center gap-2">
                {{-- ICON --}}
                <span class="w-6 h-6 flex items-center justify-center">
                    <x-device.icon :name="$device->name" />
                </span>

                {{-- LABEL --}}
                <span
                    class="text-sm md:text-base font-medium tracking-wide text-center"
                >
                    {{ $config['label'] ?? 'Unknown Device' }}
                </span>
            </div>

            {{-- STATUS --}}
            <span class="status-text text-xs md:text-sm opacity-80">
                @if ($config && $config['type'] === 'open-close')
                    {{ $device->status ? 'Open' : 'Close' }}
                @else
                    {{ $device->status ? 'ON' : 'OFF' }}
                @endif
            </span>
        </button>
    @empty
        <div class="col-span-full text-center py-10 text-gray-400">
            No devices found.
        </div>
    @endforelse
</div>
