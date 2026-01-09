<div class="overflow-x-auto">
    <table id="logsTable" class="w-full text-sm text-left text-gray-300">
        <thead
            class="text-xs text-gray-400 uppercase bg-gray-900/50 border-b border-gray-700"
        >
            <tr>
                <th scope="col" class="px-4 py-3 text-center">No</th>
                <th scope="col" class="px-4 py-3">Waktu Request</th>
                <th scope="col" class="px-4 py-3">Waktu Response</th>
                <th scope="col" class="px-4 py-3 text-center">Suhu</th>
                <th scope="col" class="px-4 py-3 text-center">Humidity</th>
                <th scope="col" class="px-4 py-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody id="logTableBody">
            <!-- Data log akan diisi oleh JavaScript -->
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                    <i
                        class="bi bi-arrow-repeat animate-spin text-2xl mb-2 block"
                    ></i>
                    Memuat log...
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="flex flex-col md:flex-row items-center justify-between mx-4">
    <div
        id="paginationContainer"
        class="mt-6 flex items-center justify-center gap-2 select-none"
    ></div>

    <div class="mt-4 text-center">
        <button
            id="refreshLogsBtn"
            class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white font-semibold transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 mx-auto"
        >
            <i class="bi bi-arrow-clockwise"></i>
            Refresh Log
        </button>
    </div>
</div>
