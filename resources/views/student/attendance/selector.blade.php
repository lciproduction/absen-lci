<div class="mt-4 mb-4">
    <x-input.input-label for="status" :value="__('Status')" class="text-white" />
    <x-input.select-input id="status" class="mt-1 w-full bg-[#1A1A19] text-white border-yellow-500 " type="text" name="status" required autofocus autocomplete="status">
        <option value="" disabled selected>Pilih Status Kehadiran</option>
        <option value="HadirWFO">Hadir WFO</option>
        <option value="HadirWFH">Hadir WFH</option>
        <option value="PulangWFO">Pulang WFO</option>
        <option value="PulangWFH">Pulang WFH</option>
        <option value="Izin">Izin</option>
        <option value="Sakit">Sakit</option>
    </x-input.select-input>
</div>

<!-- Input untuk Izin -->
<div class="hidden" id="permit">
    <x-input.input-label for="izin" :value="__('Keterangan')" />
    <x-input.text-input id="izin" name="permit" class="mt-1 w-full" type="text" maxlength="50" placeholder="Acara Keluarga" required />
</div>

<!-- Input untuk Sakit -->
<div class="hidden" id="fileUpload">
    <x-input.input-label for="sickFile" :value="__('Surat Keterangan')" class="text-white" />
    <x-input.text-input id="sickFile" name="sickFile" class="mt-1 w-full" type="file" maxlength="50" required />
</div>
