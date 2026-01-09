<div
    class="mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 my-0.5 hover:scale-[1.02] transition-all duration-300"
>
    <div class="flex flex-row items-center space-x-2">
        <i class="bi bi-thermometer-half text-2xl text-red-400"></i>

        <p class="text-xl tracking-wider">Temperature</p>
    </div>

    <div class="flex flex-row justify-evenly mt-6">
        <div>
            <p class="text-lg tracking-wide">Minimum</p>

            <p
                id="min-temp"
                class="text-center text-xl tracking-wider text-red-400 font-bold"
            >
                --
            </p>
        </div>
        <div>
            <p class="text-lg tracking-wide">Maximum</p>

            <p
                id="max-temp"
                class="text-center text-xl tracking-wider text-red-400 font-bold"
            >
                --
            </p>
        </div>
    </div>
</div>

<div
    class="mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 my-0.5 hover:scale-[1.02] transition-all duration-300"
>
    <div class="flex md:flex-row items-center space-x-2">
        <i class="bi bi-droplet text-2xl text-sky-500"></i>

        <p class="text-xl tracking-wider">Humidity</p>
    </div>

    <div class="flex flex-row justify-evenly mt-6">
        <div>
            <p class="text-lg tracking-wide">Minimum</p>

            <p
                id="min-humi"
                class="text-center text-xl tracking-wider text-sky-500 font-bold"
            >
                --
            </p>
        </div>
        <div>
            <p class="text-lg tracking-wide">Maximum</p>

            <p
                id="max-humi"
                class="text-center text-xl tracking-wider text-sky-500 font-bold"
            >
                --
            </p>
        </div>
    </div>
</div>
