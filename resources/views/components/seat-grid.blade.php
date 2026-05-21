<div class="grid grid-cols-5 gap-2" x-data="{ selected: null }">
    @foreach($layout as $seat)
    <div @click="selected = {{ $seat['student_id'] ? $seat['student_id'] : 'null' }}" class="w-12 h-12 border rounded {{ $seat['student_id'] ? 'bg-blue-500 text-white' : 'bg-gray-200' }} flex items-center justify-center cursor-pointer text-xs">
        {{ $seat['label'] }}
    </div>
    @endforeach
    <div x-show="selected" x-transition class="mt-4 p-4 bg-gray-100 rounded">
        <p>Siswa: <span x-text="selected ? 'ID ' + selected : 'Kosong'"></span></p>
    </div>
</div>