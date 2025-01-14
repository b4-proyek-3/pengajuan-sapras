<div id="timeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Waktu Tersedia</h3>
            <div id="scheduleBody" class="mt-2">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="mt-4 flex justify-between">
                <button id="prevDay" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Sebelumnya
                </button>
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Tutup
                </button>
                <button id="nextDay" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>
