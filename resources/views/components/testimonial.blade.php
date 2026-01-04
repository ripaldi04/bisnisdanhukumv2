<section id="testimonial"
    class="container  mx-auto flex flex-col justify-end py-[70px] px-[50px] gap-[30px] bg-[#F5F8FA] rounded-[32px]">
    <div class="flex flex-col text-center">
        <h2 class="font-bold text-4xl leading-[60px]">Apa Kata Mereka?</h2>
        <p class="text-[#6D7786] text-lg -tracking-[2%]">Mendapatkan peluang baru dan meningkatkan kemampuan kini
            lebih terjangkau bagi siapa saja</p>
    </div>
    <div class="swiper overflow-hidden max-w-full">
        <!-- Wrapper -->
        <div class="swiper-wrapper">
            @foreach ($testimonials as $testimonial)
                <div class="swiper-slide flex flex-col items-center space-y-4 p-6 bg-white rounded-lg shadow-md">
                    <img
                        src="{{ $testimonial->avatar ? Storage::url($testimonial->avatar) : asset('assets/people.png') }}" class="w-24">
                    <h3 class="font-bold text-lg mb-0">{{ $testimonial->name }}</h3>
                    <p class="text-md font-semibold">{{ $testimonial->occupation }}</p>
                    @if ($testimonial->type == 'Text')
                        <p class="text-gray-600 text-center">"{{ $testimonial->content }}"</p>
                    @else
                        <video controls class="w-full h-auto">
                            <source src="{{ Storage::url($testimonial->content) }}" type="video/mp4">
                        </video>
                    @endif
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="swiper-pagination mt-10"></div>
    </div>

</section>
