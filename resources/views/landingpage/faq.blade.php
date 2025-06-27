@extends('landingpage.index')
@section('content')
@php
    $faqsJson = $faqs->mapWithKeys(function($group, $type) {
        return [$type => $group->map(function($faq) {
            return [
                'question' => $faq->question,
                'answer'   => $faq->answer,
            ];
        })->toArray()];
    });
@endphp

<style>
    /* ========== Side Tab ========== */
    .sidebar-filter a {
        display: block !important;
        font-family: 'Poppins', sans-serif !important;
        background-color: #fff !important;
        color: #666 !important;
        border-radius: 50px !important;
        padding: 8px 20px !important;
        margin-bottom: 8px !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all .3s !important;
        width: 100% !important;
        text-align: left !important;
        text-decoration: none !important;
        font-weight: 550;
        cursor: pointer;
    }
    .sidebar-filter a.active {
        background-color: #e0f0ff !important;
        color: #000 !important;
    }
    .sidebar-filter a.active::after {
        content: '' !important;
        position: absolute !important;
        width: 10px !important;
        height: 10px !important;
        background-color: #0258d3 !important;
        top: 50% !important;
        right: 12px !important;
        transform: translateY(-50%) rotate(45deg) !important;
    }
    .sidebar-filter .sub-list {
        display: none;
        margin-left: 10px;
        margin-bottom: 10px;
        transition: all .3s;
        opacity: 0;
        height: 0;
        overflow: hidden;
    }
    .sidebar-filter .sub-list.show {
        display: block;
        opacity: 1;
        height: auto;
    }
    .sidebar-filter .sub-list span {
        display: block !important;
        font-family: 'Poppins', sans-serif !important;
        color: #666 !important;
        padding: 4px 12px 4px 32px !important;
        margin-bottom: 4px !important;
        transition: all .3s !important;
        width: 100% !important;
        background-color: transparent !important;
        font-size: 0.85rem !important;
        cursor: default !important;
    }
    .sidebar-filter .sub-list span:hover {
        padding-left: 40px !important;
        color: #000 !important;
    }
    .sidebar-filter .sub-list span::before {
        content: '' !important;
        position: absolute !important;
        left: 12px !important;
        top: 50% !important;
        width: 0 !important;
        height: 2px !important;
        background-color: #007bff !important;
        transition: width .4s !important;
        transform: translateY(-50%) !important;
    }
    .sidebar-filter .sub-list span:hover::before {
        width: 20px !important;
    }

    /* ========== FAQ Content ========== */
    #faq-content {
        transition: opacity .3s ease;
        opacity: 1;
    }
    .faq-item { background-color: #fff; border-radius: 10px; margin-bottom: 20px; overflow: hidden; transition: transform .3s ease, opacity .3s ease; }
    .faq-item.enter { opacity: 0; transform: translateY(10px); }
    .faq-question { font-family: 'Poppins'; font-size: 2rem; font-weight: 600; color: #333; padding: 20px; margin: 0; background-color: #f8f9fa; }
    .faq-answer { font-family: 'Poppins'; font-size: 1rem; font-weight: 400; color: #666; padding: 20px; line-height: 1.6; margin: 0; }
    .faq-answer p { margin-bottom: 15px; }
    .faq-answer p:last-child { margin-bottom: 0; }
    .no-faqs { text-align: center; padding: 40px; color: #999; font-style: italic; }
</style>

<br><br><br><br>

<div class="container-fluid px-3">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/search-modals.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Pertanyaan yang Sering</h3>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Diajukan <span style="color:#ffc74c;">(FAQ)</span></h3>
        </div>
    </div>
</div>

<div class="container-lg py-5">
    <div class="row g-5 justify-content-center">
        <!-- Sidebar Filter -->
        <div class="col-lg-4 col-md-12 text-dark p-0">
            <div class="bg-white p-4" style="border-radius: 15px;">
                <div class="sidebar-filter">
                    @foreach($types as $type)
                        @php $isOpen = $activeType === $type; @endphp
                        <a 
                          data-type="{{ $type }}" 
                          class="{{ $isOpen ? 'active' : '' }}"
                        >{{ $type }}</a>
                        <div id="type-{{ $loop->index }}" class="sub-list {{ $isOpen ? 'show' : '' }}">
                            @foreach($faqs[$type] ?? [] as $faq)
                                <span>{{ Str::limit($faq->question, 50) }}</span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-8 col-md-12">
            <div id="faq-content">
                @foreach($faqs[$activeType] ?? [] as $faq)
                    <div class="faq-item">
                        <h3 class="faq-question">{{ $faq->question }}</h3>
                        <div class="faq-answer">{!! nl2br(e($faq->answer)) !!}</div>
                    </div>
                @endforeach
                @if(($faqs[$activeType] ?? collect())->isEmpty())
                    <div class="no-faqs">
                        <h3>Belum ada pertanyaan untuk kategori ini</h3>
                        <p>Silakan pilih kategori lain atau hubungi customer service kami untuk bantuan lebih lanjut.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#fff;">Masih Bingung Cari Apa?</h3>
            <h3 class="mb-8" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#ffc74c;">Boleh Tanya Dulu!</h3>
            <a href="{{ url('/products') }}" class="btn-schedule">
                <span class="btn-text">JADWALKAN KONSULTASI</span>
                <span class="btn-arrow">
                    <i class="bi bi-arrow-right arrow-out"></i>
                    <i class="bi bi-arrow-right arrow-in"></i>
                </span>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqs = {!! $faqsJson !!};
        const tabs = document.querySelectorAll('.sidebar-filter a');
        const subLists = document.querySelectorAll('.sidebar-filter .sub-list');
        const contentDiv = document.getElementById('faq-content');

        function renderFaqs(type) {
            contentDiv.style.opacity = 0;
            setTimeout(() => {
                contentDiv.innerHTML = '';
                const list = faqs[type] || [];
                if (list.length) {
                    list.forEach(item => {
                        const wrap = document.createElement('div');
                        wrap.classList.add('faq-item','enter');

                        const q = document.createElement('h3');
                        q.classList.add('faq-question');
                        q.textContent = item.question;

                        const a = document.createElement('div');
                        a.classList.add('faq-answer');
                        a.innerHTML = item.answer
                            .split(/\r?\n/)
                            .map(p => `<p>${p}</p>`)
                            .join('');

                        wrap.appendChild(q);
                        wrap.appendChild(a);
                        contentDiv.appendChild(wrap);

                        requestAnimationFrame(() => {
                            wrap.classList.remove('enter');
                        });
                    });
                } else {
                    contentDiv.innerHTML = `
                        <div class="no-faqs">
                            <h3>Belum ada pertanyaan untuk kategori ini</h3>
                            <p>Silakan pilih kategori lain atau hubungi customer service kami untuk bantuan lebih lanjut.</p>
                        </div>`;
                }
                contentDiv.style.opacity = 1;
            }, 300);
        }

        tabs.forEach((tab, idx) => {
            tab.addEventListener('click', function() {
                const type = this.dataset.type;
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                subLists.forEach((sl, j) => {
                    if (j === idx) sl.classList.add('show');
                    else sl.classList.remove('show');
                });
                renderFaqs(type);
            });
        });
    });
</script>
@endsection
