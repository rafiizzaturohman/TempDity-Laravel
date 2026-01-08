<div>
    @switch($name)
        @case('lampu1')
            {{-- Air Conditioner --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 md:w-6 md:h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 6h18M3 10h18M6 14h12M9 18h6"
                />
            </svg>

            @break
        @case('lampu2')
            {{-- Television --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 md:w-6 md:h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <rect x="3" y="5" width="18" height="12" rx="2" />
                <path d="M8 21h8" />
            </svg>

            @break
        @case('lampu3')
            {{-- Outdoor Lighting --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 md:w-6 md:h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    d="M12 3v6M5.6 5.6l4.2 4.2M18.4 5.6l-4.2 4.2M4 12h6M14 12h6"
                />
                <circle cx="12" cy="12" r="3" />
            </svg>

            @break
        @case('lampu4')
            {{-- Curtain --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 md:w-6 md:h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path d="M4 3v18M20 3v18M8 3v18M16 3v18" />
            </svg>

            @break
        @case('lampu5')
            {{-- Garage --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 md:w-6 md:h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path d="M3 11l9-7 9 7" />
                <path d="M5 10v10h14V10" />
                <path d="M9 20v-6h6v6" />
            </svg>

            @break
        @default
            {{-- Default Icon --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 md:w-6 md:h-6 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
            >
                <circle cx="12" cy="12" r="9" />
                <path d="M12 8v4M12 16h.01" />
            </svg>
    @endswitch
</div>
