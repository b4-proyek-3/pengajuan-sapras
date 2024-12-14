<div id="editPengajuanModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center overflow-y-auto">
  <div class="relative w-full h-auto max-h-screen p-4 rounded-lg z-100">
    <div class="fixed inset-0 bg-gray-800 opacity-50"></div>
    <!-- Modal Content -->
    <div class="relative p-2 w-full max-w-lg mx-auto z-100">
      <div class="relative bg-white text-gray-900 rounded-lg">
        <!-- Header Modal -->
        <div class="flex items-center justify-between p-3 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900">Edit Pengajuan</h3>
        </div>
        <!-- Modal body -->
        <div class="p-3 -mt-2">
          <form class="space-y-2" action="{{ route('pengajuan.update', $pengajuans->id_pengajuan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
              <label for="nama-pengaju" class="block text-sm font-medium text-gray-900">Nama Pengaju</label>
              <input id="nama-pengaju" value="{{ $pengajuans->pengaju->user->name }}" 
                class="bg-gray-50 px-3 py-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full" 
                readonly />
            </div>
            <div class="flex flex-col">
              <label for="ormawa" class="block text-sm font-medium text-gray-900">Ormawa</label>
              <input id="ormawa" value="{{ $pengajuans->pengaju->ormawa->nama_ormawa }}" 
                class="bg-gray-50 px-3 py-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full" 
                readonly />
            </div>
            <div class="flex flex-col">
                <label for="nama-kegiatan" class="block text-sm font-medium text-gray-900">Nama Kegiatan</label>
                <input type="text" id="nama-kegiatan" name="nama_kegiatan" value="{{ $pengajuans->nama_kegiatan }}" 
                class="bg-gray-50 px-3 py-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"/>
            </div>
            <div class="flex flex-col">
                <label for="tanggal-kegiatan" class="block text-sm font-medium text-gray-900">Tanggal Kegiatan</label>
                <input type="date" id="tanggal-kegiatan" name ="tanggal_pinjam" value="{{ $pengajuans->tanggal_pinjam }}" 
                class="bg-gray-50 px-3 py-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"/>
            </div>
            <div class="flex flex-col">
                <label for="tanggal-kegiatan" class="block text-sm font-medium text-gray-900">Tanggal Berakhir</label>
                <input type="date" id="tanggal-akhir" name ="tanggal_akhir" value="{{ $pengajuans->tanggal_akhir }}" 
                class="bg-gray-50 px-3 py-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"/>
            </div>
            <div class="flex flex-col">
                <label for="tanggal-kegiatan" class="block text-sm font-medium text-gray-900">Waktu Kegiatan</label>
                <input type="time" id="waktu-kegiatan" name ="waktu_pengajuan" value="{{ $pengajuans->waktu_pinjam }}" 
                class="bg-gray-50 px-3 py-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"/>
            </div>
            <div class="flex flex-col">
                <label for="tempat-kegiatan" class="block text-sm font-medium text-gray-900">Tempat Kegiatan</label>
                <select name="id_tempat" 
                class="bg-gray-50 px-3 py-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"/>
                    @foreach ($tempatList as $tempat)
                        <option value="{{ $tempat->id_tempat }}" {{ $tempat->id_tempat == $pengajuans->id_tempat ? 'selected' : '' }}>
                            {{ $tempat->nama_gedung }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-tl from-blue-600 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none">
                    update
                </button>
                <button type="button" class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none ml-2" onclick="closePengajuanModal()">
                    batal
                </button>
            </div>
          </form>
        </div>  
      </div>
    </div>
  </div>
</div>

<script>
    function openPengajuanModal() {
        document.getElementById('editPengajuanModal').classList.remove('hidden');
    }

    function closePengajuanModal() {
        document.getElementById('editPengajuanModal').classList.add('hidden');
    }
</script>