<div class="mt-4 mb-4">
    <x-input.input-label for="status" :value="__('Status')" class="text-white" />
    <x-input.select-input id="status" class="mt-1 w-full bg-[#ffffff] text-red-primary border-yellow-500 "
        type="text" name="status" required autofocus autocomplete="status">
        <option value="" disabled selected>Pilih Status Kehadiran</option>
        <option value="hadir">Hadir </option>
        <option value="pulang">Pulang </option>
        <option value="izin">Izin</option>
        <option value="sakit">Sakit</option>
    </x-input.select-input>
</div>

<!-- Input untuk Izin -->
<div class="hidden" id="permit">
    <x-input.input-label for="izin" :value="__('Keterangan')" />
    <x-input.text-input id="izin" name="permit" class="mt-1 w-full" type="text" maxlength="50"
        placeholder="Acara Keluarga" required />
</div>

<!-- Input untuk Sakit -->
<div class="hidden" id="fileUpload">
    <x-input.input-label for="sickFile" :value="__('Surat Keterangan')" class="text-white" />
    {{-- <x-input.text-input id="sickFile" name="sickFile" class="mt-1 w-full" type="file" maxlength="50" required /> --}}
    <input type="file" class="file-input file-input-info mt-1 w-full " id="sickFile" name="sickFile"maxlength="50"
        required />

</div>
