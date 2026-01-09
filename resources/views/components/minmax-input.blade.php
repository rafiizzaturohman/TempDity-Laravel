<div class="grid grid-cols-none md:grid-cols-2 gap-8">
    <form action="update-nmin" method="POST" class="space-y-4">
        @csrf
        <div class="flex flex-col gap-4">
            <div class="relative flex-1">
                <label
                    for="jenis_nilai"
                    class="text-gray-300 text-base mb-1 block"
                >
                    Nilai Minimum
                </label>
                <select
                    name="jenis_nilai"
                    id="jenis_nilai"
                    class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                    <option value="" disabled selected>Pilih Nilai</option>
                    <option value="min_temperature">Min Temperature</option>
                    <option value="min_humidity">Min Humidity</option>
                </select>
            </div>

            <div class="flex-1">
                <label for="nilai" class="text-gray-300 text-base mb-1 block">
                    Nilai
                </label>
                <input
                    type="number"
                    name="nilai"
                    id="nilai"
                    step="0.1"
                    class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400"
                    required
                />
            </div>
        </div>

        <div class="text-center">
            <button
                type="submit"
                class="mt-2 px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200 cursor-pointer"
            >
                Simpan Nilai
            </button>
        </div>
    </form>

    <form action="update-nmax" method="POST" class="space-y-4">
        @csrf
        <div class="flex flex-col gap-4">
            <div class="relative flex-1">
                <label
                    for="jenis_nilai"
                    class="text-gray-300 text-base mb-1 block"
                >
                    Nilai Maksimum
                </label>
                <select
                    name="jenis_nilai"
                    id="jenis_nilai"
                    class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                    <option value="" disabled selected>Pilih Nilai</option>
                    <option value="max_temperature">Max Temperature</option>
                    <option value="max_humidity">Max Humidity</option>
                </select>
            </div>

            <div class="flex-1">
                <label for="nilai" class="text-gray-300 text-base mb-1 block">
                    Nilai
                </label>
                <input
                    type="number"
                    name="nilai"
                    id="nilai"
                    step="0.1"
                    class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400"
                    required
                />
            </div>
        </div>

        <div class="text-center">
            <button
                type="submit"
                class="mt-2 px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200 cursor-pointer"
            >
                Simpan Nilai
            </button>
        </div>
    </form>
</div>
