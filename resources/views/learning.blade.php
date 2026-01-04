@extends('layout')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    @commentsStyles
@endsection

@include('components.navbar')
@section('content')
    <div>
        {{-- Layout Grid untuk Video dan Sidebar --}}
        <section id="video-content" class="w-full p-6 bg-[#F6F8FD]">
            <div class="mx-auto grid gap-5 md:grid-cols-[1fr_320px] h-auto md:h-[calc(95vh-100px)]">

                {{-- Sidebar Navigasi Materi (Di mobile tampil di atas) --}}
                <div
                    class="md:order-2 order-1 md:sticky md:top-5 h-auto md:h-[calc(95vh-100px)] overflow-y-auto bg-white 
                rounded-[26px] p-5 shadow-md scrollbar-thin scrollbar-thumb-[#4540e1] 
                scrollbar-track-[#E9EFF3]">
                    <p class="font-bold text-lg text-black">{{ $totalModules }} Modul dan {{ $totalSubModules }} Materi
                    </p>
                    <div class="flex flex-col gap-3 mt-4">
                        <a href="{{ route('learn') }}"
                            class="group p-[12px_16px] flex items-center gap-[10px] bg-[#E9EFF3] text-black rounded-full hover:bg-[#4540e1] hover:text-white  transition-all duration-300">
                            <p class="font-semibold">Video Trailer</p>
                        </a>

                        @php
                            $currentModuleId = Route::current()->parameter('moduleId');
                        @endphp
                        @forelse($modules as $module)
                            @php
                                $isModuleActive = $module->id == $currentModuleId;
                            @endphp
                            <div
                                class="collapse collapse-arrow border-base-300 bg-[#E5E9F2] border {{ $isModuleActive ? 'collapse-open' : '' }}">
                                <input type="checkbox" class="w-full" />
                                <div class="collapse-title">
                                    <p class="font-semibold">{{ $module->title }}</p>
                                </div>
                                <div class="collapse-content">
                                    @forelse ($module->subModules->sortBy('order') as $subModulee)
                                        @php
                                            $currentSubModuleId = Route::current()->parameter('subModuleId');
                                            $isSubModuleActive = $subModulee->id == $currentSubModuleId;
                                        @endphp
                                        <a href="{{ route('learning', [$module->id, 'subModuleId' => $subModulee->id]) }}"
                                            class="group p-[12px_16px] my-4 flex items-center gap-[10px] {{ $isSubModuleActive ? 'bg-[#4540e1] text-white' : 'bg-white text-black' }}  rounded-full hover:bg-[#4540e1] hover:text-white transition-all duration-300">
                                            <p class="font-semibold">{{ $subModulee->title }}</p>
                                        </a>
                                    @empty
                                        <p>Belum ada materi yang tersedia</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p>Belum ada data course</p>
                        @endforelse
                    </div>
                </div>

                {{-- Kolom Konten Kiri: Video dan Deskripsi --}}
                <div
                    class="md:order-1 order-2 flex flex-col overflow-y-auto scrollbar-thin  scrollbar-thumb-[#4540e1] scrollbar-track-[#E9EFF3]">
                    <div class="plyr__video-embed w-full aspect-video rounded-[20px] relative mb-5" id="player">
                        @if ($subModule->type == 'video')
                            <iframe
                                src="https://www.youtube.com/embed/{{ $subModule->content }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                                allowfullscreen allowtransparency allow="autoplay"></iframe>
                        @elseif($subModule->type == 'text')
                            <div class="bg-white p-8 rounded-3xl prose">
                                {!! $subModule->content !!}
                            </div>
                        @elseif($subModule->type == 'document' || 'audio')
                            <div>
                                <iframe src="{{ Storage::url($subModule->content) }}" frameborder="0" width="100%"
                                    height="600px"></iframe>
                            </div>
                        @endif
                    </div>

                    <section id="Video-Resources" class="max-w-[1120px] w-full mx-auto flex justify-between  mb-14">
                        <div class="p-2">
                            <h1 class="title font-extrabold text-xl md:text-[30px] leading-[45px]">
                                {{ $subModule->title }}</h1>
                            <p class="font-medium text-sm md:text-base leading-[30px]">
                                {{ $subModule->description }}
                            </p>
                        </div>
                        <div
                            class="flex md:flex-row flex-col-reverse space-y-6 md:space-y-0  md:items-center space-x-0 md:space-x-5">
                            <div>
                                <!-- Button to open the modal -->
                                <button
                                    class="md:px-8 md:py-3 px-6 py-1 mt-5 md:mt-0 font-semibold text-base md:text-xl bg-[#FFFFFF] ring-[#4540e1] border-[#4540e1] border hover:text-white hover:bg-[#4540e1] rounded-full text-[#4540e1]"
                                    onclick="openTodoList()">To Do List</button>

                                <!-- Modal menggunakan DaisyUI -->
                                <dialog id="todo_modal" class="modal">
                                    <div class="modal-box">
                                        <h3 class="text-lg font-bold">To Do List</h3>
                                        <div id="todo-content">
                                            <!-- Isi dari todo list akan ditampilkan di sini -->
                                        </div>
                                        <div class="modal-action">
                                            <button class="btn" onclick="closeModal()">Close</button>
                                        </div>
                                    </div>
                                </dialog>
                            </div>
                            @if (!$userProgress->is_completed)
                                <form action="{{ route('submodule.complete', $subModule->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="group md:px-8 md:py-3 px-6 py-1 bg-[#4540e1] font-semibold text-base md:text-xl text-white rounded-full hover:bg-[#2c2964] transition-all duration-300">
                                        Tandai Selesai
                                    </button>
                                </form>
                            @else
                                <button
                                    class="group md:px-8 md:py-3 px-6 py-1 font-semibold text-base md:text-xl bg-gray-400 text-white rounded-full"
                                    disabled>
                                    Sudah Selesai
                                </button>
                            @endif
                        </div>
                    </section>

                    <section class="max-w-[1100px] w-full mx-auto">
                        <div x-cloak x-data class="space-y-8">
                            <livewire:comments-list :model="$subModule" />
                            <hr class="text-gray-400" />
                            <livewire:comments-create-form :model="$subModule" />
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script>
        function openTodoList() {
            // Buka modal
            document.getElementById('todo_modal').showModal();

            // Ambil data todo list dari server
            fetch('/todos')
                .then(response => response.json())
                .then(data => {
                    const todoContent = document.getElementById('todo-content');
                    todoContent.innerHTML = ''; // Kosongkan konten sebelumnya

                    data.forEach(list => {
                        // Tambahkan title dan description dari todo_list
                        let listHTML = `
                    <div class="my-4">
                        <h4 class="text-lg font-bold">${list.title}</h4>
                        <p>${list.description || ''}</p>
                        <div class="mt-2">
                `;

                        // Tambahkan checklist items yang terkait dengan todo_list
                        list.todo_checklist_items.forEach(item => {
                            const isChecked = item.progress.length > 0 && item.progress[0].is_checked;
                            listHTML += `
                        <div class="flex items-center my-1">
                            <input 
                                type="checkbox" 
                                data-item-id="${item.id}" 
                                ${isChecked ? 'checked' : ''} 
                                onchange="updateProgress(${item.id}, this.checked)"
                            />
                            <label class="ml-2">${item.title}</label>
                        </div>
                    `;
                        });

                        listHTML += `</div></div>`;
                        todoContent.innerHTML += listHTML;
                    });
                })
                .catch(error => console.error('Error fetching todo lists:', error));
        }

        function updateProgress(itemId, isChecked) {
            // Kirim data progress ke server
            fetch('/todos/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        item_id: itemId,
                        is_checked: isChecked
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Progress updated:', data);
                })
                .catch(error => {
                    console.error('Error updating progress:', error);
                });
        }

        function closeModal() {
            // Tutup modal
            document.getElementById('todo_modal').close();
        }
    </script>
    @commentsScripts
@endsection
