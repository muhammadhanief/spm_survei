<!-- Cari, Hapus, Edit Dimensi -->
<h4 class="mb-4 mt-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
    Cari, Hapus, Target Responden
</h4>
<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800  ">
    <div id="search-box" class="flex flex-col items-start px-2 my-4 justify-center">
        <!-- Search input -->
        <div id="kolom-pencarian" class="flex">
            <div class="relative w-full max-w-xl  focus-within:text-purple-500 ">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d=" M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd">
                        </path>
                    </svg>
                </div>
                <input
                    class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    wire:model.live.debounce.500ms="search" type="text" placeholder="Cari Akar Dimensi.." />
            </div>
        </div>
        <div>
            @if (session('gagalSearch'))
                <div class="text-red-500 text-xs pt-2">{{ session('gagalSearch') }}</div>
            @endif
            @if (session('successHapus'))
                <div class="text-green-500 text-xs pt-2">{{ session('successHapus') }}</div>
            @else
                <div class="text-red-500 text-xs pt-2">{{ session('errorHapus') }}</div>
            @endif
        </div>
    </div>
    <div class="container grid mx-auto">
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Grup</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($targetRespondens as $targetResponden)
                            <tr wire:key='{{ $targetResponden->id }}' class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{ $targetResponden->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $targetResponden->email }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $targetResponden->role->name }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        {{-- <button wire:click='edit({{ $dimension->id }})'
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </button> --}}
                                        <button
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Delete" wire:click='delete({{ $targetResponden->id }})'
                                            {{-- wire:confirm.prompt='Apakah Anda yakin ingin menghapus dimensi "{{ $dimension->name }}"?\n\nKetik DELETE untuk konfirmasi|DELETE' --}}>
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        {{-- <div>
                                            <button @click="openModal('modal')"
                                                wire:click='showSubdimensionModal({{ $dimension->id }})'
                                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                Lihat Subdimensi
                                            </button>
                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-2 flex justify-start">
                    {{ $targetRespondens->links() }}
                </div>
            </div>
        </div>
    </div>
    {{-- @include('livewire.includes.subdimensions-modal') --}}
</div>
