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
    .faq-hero-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3.2rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0;
    }
    .faq-hero-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 3.2rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0;
    }
    .faq-hero-highlight {
        color: #ffc74c;
    }

    .sidebar-filter {
        padding: 1.2rem;
    }
    .sidebar-filter a {
        display: block !important;
        font-family: 'Poppins', sans-serif !important;
        background-color: #fff !important;
        color: #666 !important;
        border-radius: 40px !important;
        padding: 6px 16px !important;
        margin-bottom: 6px !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all .3s !important;
        width: 100% !important;
        text-align: left !important;
        text-decoration: none !important;
        font-weight: 550;
        cursor: pointer;
        font-size: 0.85rem !important;
    }
    .sidebar-filter a:hover {
        padding-right: 32px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1) !important;
        color: #000 !important;
    }
    .sidebar-filter a.active {
        background-color: #e0f0ff !important;
        color: #000 !important;
    }
    .sidebar-filter a.active::after {
        content: '' !important;
        position: absolute !important;
        width: 8px !important;
        height: 8px !important;
        background-color: #0258d3 !important;
        top: 50% !important;
        right: 10px !important;
        transform: translateY(-50%) rotate(45deg) !important;
    }
    .sidebar-filter .sub-list {
        display: none;
        margin-left: 8px;
        margin-bottom: 8px;
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
        padding: 3px 10px 3px 26px !important;
        margin-bottom: 3px !important;
        transition: all .3s !important;
        width: 100% !important;
        background-color: transparent !important;
        font-size: 0.75rem !important;
        cursor: default !important;
        position: relative !important;
    }
    .sidebar-filter .sub-list span:hover {
        padding-left: 32px !important;
        color: #000 !important;
    }
    .sidebar-filter .sub-list span::before {
        content: '' !important;
        position: absolute !important;
        left: 10px !important;
        top: 50% !important;
        width: 0 !important;
        height: 2px !important;
        background-color: #007bff !important;
        transition: width .4s !important;
        transform: translateY(-50%) !important;
    }
    .sidebar-filter .sub-list span:hover::before {
        width: 16px !important;
    }

    #faq-content {
        transition: opacity .3s ease;
        opacity: 1;
    }
    .faq-item { 
        background-color: #fff; 
        border-radius: 8px; 
        margin-bottom: 16px; 
        overflow: hidden; 
        transition: transform .3s ease, opacity .3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .faq-item.enter { 
        opacity: 0; 
        transform: translateY(8px); 
    }
    .faq-question { 
        font-family: 'Poppins', sans-serif; 
        font-size: 1.4rem; 
        font-weight: 600; 
        color: #333; 
        padding: 16px; 
        margin: 0; 
        background-color: #f8f9fa;
        line-height: 1.3;
    }
    .faq-answer { 
        font-family: 'Poppins', sans-serif; 
        font-size: 0.85rem; 
        font-weight: 400; 
        color: #666; 
        padding: 16px; 
        line-height: 1.6; 
        margin: 0; 
    }
    .faq-answer p { 
        margin-bottom: 12px; 
    }
    .faq-answer p:last-child { 
        margin-bottom: 0; 
    }
    .no-faqs { 
        text-align: center; 
        padding: 32px; 
        color: #999; 
        font-style: italic;
    }
    .no-faqs h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 12px;
    }
    .no-faqs p {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        margin: 0;
    }

    .cta-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2.4rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0;
    }
    .cta-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 2.4rem;
        font-weight: 600;
        color: #ffc74c;
        margin-bottom: 1.5rem;
    }

    .sidebar-container {
        background-color: #fff;
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    /* ========== Responsive Design ========== */
    @media (max-width: 768px) {
        .faq-hero-title, .faq-hero-subtitle {
            font-size: 2.4rem;
        }
        .faq-question {
            font-size: 1.2rem;
            padding: 12px;
        }
        .faq-answer {
            font-size: 0.8rem;
            padding: 12px;
        }
        .sidebar-filter {
            padding: 1rem;
        }
        .cta-title, .cta-subtitle {
            font-size: 2rem;
        }
        .no-faqs {
            padding: 24px;
        }
        .no-faqs h3 {
            font-size: 1.1rem;
        }
        .no-faqs p {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .faq-hero-title, .faq-hero-subtitle {
            font-size: 2rem;
        }
        .faq-question {
            font-size: 1.1rem;
        }
        .faq-answer {
            font-size: 0.75rem;
        }
        .sidebar-filter a {
            font-size: 0.8rem !important;
            padding: 5px 14px !important;
        }
        .sidebar-filter .sub-list span {
            font-size: 0.7rem !important;
        }
        .cta-title, .cta-subtitle {
            font-size: 1.8rem;
        }
    }
</style>

<br><br><br><br>

<div class="container-fluid px-3">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/search-modals.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content" style="padding-left: 3rem;">
            <h3 class="faq-hero-title">Pertanyaan yang Sering</h3>
            <h3 class="faq-hero-subtitle">Diajukan <span class="faq-hero-highlight">(FAQ)</span></h3>
        </div>
    </div>
</div>

<div class="container-lg py-4">
    <div class="row g-4 justify-content-center">
        <!-- Sidebar Filter -->
        <div class="col-lg-4 col-md-12 text-dark p-0">
            <div class="sidebar-container">
                <div class="sidebar-filter">
                    @foreach($types as $type)
                        @php $isOpen = $activeType === $type; @endphp
                        <a 
                          data-type="{{ $type }}" 
                          class="{{ $isOpen ? 'active' : '' }}"
                        >{{ $type }}</a>
                        <div id="type-{{ $loop->index }}" class="sub-list {{ $isOpen ? 'show' : '' }}">
                            @foreach($faqs[$type] ?? [] as $faq)
                                <span>{{ Str::limit($faq->question, 40) }}</span>
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
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content" style="padding-left: 3rem;">
            <h3 class="cta-title">Masih Bingung Cari Apa?</h3>
            <h3 class="cta-subtitle">Boleh Tanya Dulu!</h3>
            <a href="https://wa.me/6281952764747?text=Halo%20Admin%20Sinau%20Print%21%20Saya%20ingin%20mengajukan%20pertanyaan%20terkait%20produk%20yang%20ada%20di%20sinau%20print" target="_blank" class="btn-schedule">
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