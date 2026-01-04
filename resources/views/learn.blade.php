@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
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
                    rounded-[26px] p-5 shadow-md scrollbar-thin scrollbar-thumb-[#D4AF37]
                    scrollbar-track-[#E9EFF3]">
                    <p class="font-bold text-lg">{{ $totalModules }} Modul dan {{ $totalSubModules }} Materi</p>
                    <div class="flex flex-col gap-3 mt-4">
                        <a href="{{ route('learn') }}"
                            class="group p-3 flex items-center gap-3 bg-[#D4AF37] rounded-full
                        text-white hover:text-black hover:bg-[#E9EFF3] transition duration-300">
                            <p class="font-semibold">Video Trailer</p>
                        </a>
                        @forelse($modules as $module)
                            <div class="collapse collapse-arrow border-base-300 bg-[#E5E9F2] border">
                                <input type="checkbox" class="w-full" />
                                <div class="collapse-title">
                                    <p class="font-semibold">{{ $module->title }}</p>
                                </div>
                                <div class="collapse-content">
                                    @forelse ($module->subModules->sortBy('order') as $subModule)
                                        <a href="{{ route('learning', ['moduleId' => $module->id, 'subModuleId' => $subModule->id]) }}"
                                            class="group mb-4 p-[12px_16px] flex items-center gap-[10px] bg-white
                                        rounded-full hover:bg-[#D4AF37] hover:text-white transition-all duration-300">
                                            <p class="font-semibold">{{ $subModule->title }}</p>
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
                    class="md:order-1 order-2 flex flex-col overflow-y-auto scrollbar-thin scrollbar-thumb-[#D4AF37]
                scrollbar-track-[#E9EFF3]">
                    <div class="plyr__video-embed w-full aspect-video rounded-[20px] relative mb-5" id="player">
                        <iframe
                            src="https://www.youtube.com/embed/{{ $course->trailer }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                            allowfullscreen allowtransparency allow="autoplay">
                        </iframe>
                    </div>

                    <section id="Video-Resources" class="max-w-[1120px] w-full mx-auto">
                        <h1 class="font-extrabold text-[24px] md:text-[30px] leading-[35px] md:leading-[45px]">
                            {{ $course->title }}</h1>
                        <div class="mt-5">
                            <h3 class="font-bold text-xl md:text-2xl">Deskripsi Course</h3>
                            <p class="font-medium leading-[25px] md:leading-[30px]">{{ $course->description }}</p>
                        </div>
                    </section>
                </div>

            </div>
        </section>
    </div>


    {{-- @include('components.faq') --}}
@endsection


@section('script')
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
@endsection
