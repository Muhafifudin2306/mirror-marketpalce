@extends('landingpage.index')
@section('content')
    <style>
        .form-control {
            border-radius: 40px !important;
            height: 44px;
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .form-control::placeholder {
            padding: 0 8px;
            color: #c3c3c3;
            opacity: 1;
        }

        .form-control:disabled {
            background-color: #fff !important;
            color: #c3c3c3;
            opacity: 1 !important;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.64rem;
            font-family: 'Poppins', sans-serif;
            color: #444;
        }

        .edit-btn {
            border-radius: 0.2rem !important;
        }

        #editPasswordFields .eye-btn {
            position: absolute;
            top: 50%;
            right: 0.8rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 0.88rem;
            cursor: pointer;
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
            cursor: pointer !important;
        }

        .sidebar-filter a:hover {
            padding-right: 32px !important;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1) !important;
            color: #000 !important;
        }

        .sidebar-filter a.active {
            background-color: #f1f7ff !important;
            color: #000 !important;
        }

        .sidebar-filter a.active::after {
            content: '' !important;
            position: absolute !important;
            width: 8px !important;
            height: 8px !important;
            background-color: #0439a0 !important;
            top: 50% !important;
            right: 10px !important;
            transform: translateY(-50%) rotate(45deg) !important;
        }

        .sidebar-filter .nav-link::before {
            display: none !important;
        }

        .section-pill {
            display: block;
            width: 100%;
            text-align: left;
            font-family: 'Poppins', sans-serif !important;
            background-color: #f1f7ff;
            color: #0439a0;
            border-radius: 40px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 1.28rem;
            margin-bottom: 13px;
        }

        .is-invalid {
            border-color: #fc2865 !important;
        }

        .invalid-feedback {
            display: block;
            color: #fc2865;
            font-size: 0.64rem;
            font-weight: 200;
        }

        .btn-edit-text {
            display: inline-block;
            padding: 5px 10px;
            font-size: 13px;
            font-weight: 550;
            color: #444444;
            background-color: #fff;
            font-family: 'Poppins', sans-serif !important;
            border: none;
            text-decoration: none !important;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-edit-text:hover {
            color: #0439a0;
        }

        .btn-save {
            background-color: #0258d3;
            color: white;
            padding: 10px 11px;
            font-size: 14px;
            margin-top: 19px;
            border: none;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-save:hover {
            background-color: #0258d3;
            color: white;
        }

        .btn-cancel {
            background: none;
            border: none;
            color: #888;
            font-size: 10px;
            margin-top: 14px;
            text-decoration: underline;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            padding: 0;
            display: inline;
            width: auto;
            cursor: pointer;
        }

        .btn-cancel:hover {
            color: #444;
            text-decoration: underline;
        }

        .input-edit {
            border: 1px solid #ced4da;
            border-radius: 3px;
            padding: 5px 8px;
            font-size: 11px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .input-edit:focus {
            border-color: #80bdff;
            outline: none;
        }

        .field-label {
            font-weight: bold;
            margin-bottom: 3px;
            display: inline-block;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input.form-control {
            padding-right: 36px !important;
        }

        .eye-btn {
            position: absolute;
            top: 50%;
            right: 0.8rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 0.96rem;
            color: #999;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .notification-badge {
            font-size: 0.72rem;
            padding: 3px 10px;
            border-radius: 3px;
            font-weight: 500;
            display: inline-block;
            text-transform: uppercase;
        }

        .badge-purchase {
            background-color: #03a7a7;
            color: #fff;
        }

        .badge-promo {
            background-color: #fc2965;
            color: #fff;
        }

        .badge-profil {
            background-color: #0258d3;
            color: #fff;
        }

        .notification-unread {
            background-color: #f1f7ff !important;
            border: none;
            cursor: pointer;
            transition: background-color 0.4s ease;
            font-family: 'Poppins', sans-serif;
        }

        .notification-read {
            background-color: #fff !important;
            border: none;
            cursor: pointer;
            transition: background-color 0.4s ease;
            font-family: 'Poppins', sans-serif;
        }

        .pagination {
            margin: 0;
            gap: 0.4rem;
        }

        .pagination .page-link {
            border-radius: 50% !important;
            width: 32px;
            height: 32px;
            padding: 0;
            line-height: 30px;
            text-align: center;
            font-weight: 500;
            color: #0258d3;
            border: 1px solid #ccc;
        }

        .pagination .page-item.active .page-link {
            background-color: #0258d3;
            color: white;
            border-color: #0258d3;
        }

        .pagination .page-item.disabled,
        .pagination .page-item:first-child,
        .pagination .page-item:last-child {
            display: none;
        }

        .logout-button {
            border: none;
            padding: 10px 52px;
            background-color: transparent;
            color: white;
            border-radius: 40px;
            border: 2px solid white;
            font-size: 0.88rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.2s ease;
        }

        .logout-button:hover {
            background-color: white;
            border: 2px solid white;
            color: black;
        }
    </style>

    <style>
        .chat-container {
            height: 560px;
            display: flex;
        }

        .chat-sidebar {
            width: 160px;
            background: white;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 12px 16px;
            border-bottom: 1px solid #dee2e6;
            background: #f8f9fa;
        }

        .chat-header h5 {
            margin: 0;
            font-weight: 600;
            color: #495057;
        }

        .chat-list {
            flex: 1;
            overflow-y: auto;
        }

        .chat-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f3f4;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
        }

        .chat-item:hover {
            background-color: #f8f9fa;
        }

        .chat-item.active {
            background-color: #e3f2fd;
            border-right: 2px solid #2196f3;
        }

        .chat-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .chat-info {
            flex: 1;
            min-width: 0;
        }

        .chat-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .chat-preview {
            color: #6c757d;
            font-size: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-meta {
            text-align: right;
            flex-shrink: 0;
            margin-left: 8px;
        }

        .chat-time {
            font-size: 10px;
            color: #6c757d;
            margin-bottom: 3px;
        }

        .chat-badge {
            background: #28a745;
            color: white;
            font-size: 9px;
            padding: 2px 5px;
            border-radius: 8px;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .chat-main-header {
            padding: 12px 16px;
            border-bottom: 1px solid #dee2e6;
            background: #f8f9fa;
            display: flex;
            align-items: center;
        }

        .chat-main-header h5 {
            margin: 0;
            font-weight: 600;
            color: #495057;
        }

        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message-bubble {
            font-family: 'Barlow', sans-serif;
            font-size: 0.96rem !important;
            max-width: 70%;
            padding: 10px 13px;
            border-radius: 14px;
            position: relative;
            word-wrap: break-word;
        }

        .message.received .message-bubble {
            background: white;
            border: 1px solid #e9ecef;
            min-width: 12rem;
            /* margin-left: 36px; */
        }

        .message.sent .message-bubble {
            background: #cfe0ee;
            color: rgb(22, 20, 20);
            margin-right: 8px;
            min-width: 12rem;
        }

        .message-time {
            font-size: 9px;
            margin-top: 4px;
            opacity: 0.7;
        }

        .message.received .message-time {
            color: #6c757d;
        }

        .message.sent .message-time {
            color: rgb(39, 39, 39);
            text-align: right;
        }

        .message-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 10px;
            position: absolute;
            /* left: 16px; */
        }

        .chat-input {
            padding: 12px 16px;
            border-top: 1px solid #dee2e6;
            background: white;
        }

        .input-group {
            position: relative;
        }


        .send-btn {
            /* position: absolute; */
            right: 6px;
            background: #2196f3;
            border: none;
            border-radius: 50%;
            width: 52px;
            color: white;
            cursor: pointer;
            padding-top: 0.56rem;
            padding-right: 0.8rem;
            padding-bottom: 0.56rem;
            padding-left: 0.8rem;
            transition: background-color 0.2s;
        }

        .send-btn:hover {
            background: #1976d2;
        }

        .file-attachment {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 6px;
            padding: 6px 10px;
            margin: 4px 0;
            display: inline-flex;
            align-items: center;
            font-size: 10px;
            color: #1976d2;
        }

        .date-divider {
            text-align: center;
            margin: 16px 0;
            position: relative;
        }

        .date-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
        }

        .date-divider span {
            background: #f8f9fa;
            padding: 0 12px;
            color: #6c757d;
            font-size: 10px;
        }

        @media (max-width: 768px) {
            .chat-sidebar {
                width: 100%;
                position: absolute;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .chat-sidebar.show {
                transform: translateX(0);
            }

            .chat-main {
                width: 100%;
            }
        }
        /* Mobile */
        @media (max-width: 991.98px) {
            .cta-overlay {
                left: 2% !important;
                width: 96% !important;
            }
            
            .cta-overlay h3 {
                font-size: 1.8rem !important;
            }
            
            .logout-button {
                padding: 6px 20px !important;
                font-size: 0.75rem !important;
            }
        }

        @media (max-width: 768px) {
            main {
                padding-top: 2rem !important;
            }
            
            .product-card {
                margin-top: 0 !important;
            }
            
            .container-fluid.px-4 {
                padding-top: 1rem !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .cta-overlay .d-flex {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 1rem;
            }
            
            .cta-overlay h3 {
                font-size: 1.6rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            .logout-button {
                align-self: flex-end;
                padding: 8px 24px !important;
            }
            
            .sidebar-filter {
                margin-bottom: 2rem !important;
            }
            
            .sidebar-filter a {
                font-size: 0.8rem !important;
                padding: 8px 16px !important;
                margin-bottom: 4px !important;
            }
            
            .chat-container {
                height: 450px !important;
            }
            
            .chat-sidebar {
                width: 140px !important;
            }
            
            .chat-name {
                font-size: 0.65rem !important;
            }
            
            .chat-preview {
                font-size: 0.6rem !important;
            }
            
            .chat-time {
                font-size: 0.6rem !important;
            }
            
            .message-bubble {
                font-size: 0.8rem !important;
                padding: 8px 10px !important;
                max-width: 85% !important;
            }
            
            .message-time {
                font-size: 0.55rem !important;
            }
            
            .chat-avatar {
                width: 24px !important;
                height: 24px !important;
                font-size: 0.6rem !important;
            }
            
            .send-btn {
                width: 44px !important;
                padding: 0.4rem 0.6rem !important;
            }
            
            .form-control {
                height: 40px !important;
                font-size: 0.8rem !important;
                padding: 0.4rem 0.8rem !important;
            }
        }

        @media (max-width: 576px) {
            main {
                padding-top: 1rem !important;
            }
            
            .container-fluid.px-4 {
                padding-top: 0.5rem !important;
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            
            .cta-overlay h3 {
                font-size: 1.4rem !important;
            }
            
            .logout-button {
                padding: 6px 16px !important;
                font-size: 0.7rem !important;
            }
            
            .chat-container {
                height: 400px !important;
            }
            
            .chat-sidebar {
                width: 120px !important;
            }
            
            .sidebar-filter a {
                font-size: 0.75rem !important;
                padding: 6px 12px !important;
            }
            
            .message-bubble {
                font-size: 0.75rem !important;
                padding: 6px 8px !important;
                max-width: 90% !important;
            }
            
            .chat-avatar {
                width: 20px !important;
                height: 20px !important;
                font-size: 0.55rem !important;
            }
            
            .send-btn {
                width: 40px !important;
                padding: 0.3rem 0.5rem !important;
            }
            
            .form-control {
                height: 36px !important;
                font-size: 0.75rem !important;
            }
        }
    </style>

    <div class="container-fluid footer mt-5 pt-5 wow fadeIn d-none d-md-block" data-wow-delay="0.1s">
        <div class="position-relative mb-0">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
            <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%; width: 90%;">
                <!-- WRAPPER BARU untuk greeting + logout -->
                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                    <h3 class="mb-0" style="font-family:'Poppins'; font-size:2.64rem; font-weight:550; color:#fff;">
                        Halo, <span style="color:#ffc74c">{{ Auth::user()->name }}</span>
                    </h3>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="logout-button">LOGOUT</button>
                    </form>
                </div>

                <!-- Breadcrumb tetap di bawah -->
                <nav aria-label="breadcrumb" class="d-none d-md-block">
                    <ol class="breadcrumb mb-0" style="font-family:'Poppins'; font-size:0.8rem; font-weight:400;">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">BERANDA</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PROFIL</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    <main>
        <div class="container-fluid px-3">
            <div class="container product-card" style="margin-top:-144px;">
                <div class="row g-5" style="margin-top:32px;">

                    {{-- Sidebar Tabs --}}
                    <div class="col-lg-3">
                        <div class="sidebar-filter nav flex-column nav-pills me-3" id="sidebarTabs" role="tablist"
                            style="font-weight: 200 !important;">
                            <a class="nav-link" href="{{ route('profile.index') }}">Pesanan
                                Saya</a>
                            <a class="nav-link" href="{{ route('profile.index') }}">Profil
                                Saya</a>
                            <a class="nav-link active" id="tab-chat">Chat
                                Saya</a>
                            <a class="nav-link" href="{{ route('profile.index') }}">Notifikasi</a>
                        </div>
                    </div>

                    {{-- Content Panes --}}
                    @if (Auth::user()->role == 'Admin')
                        <div class="col-lg-8">
                            <div class="chat-container">
                                <div class="chat-sidebar" id="chatSidebar">
                                    <div class="chat-list" id="chatList">
                                        {{-- Iterasi user yang punya chat --}}
                                        @foreach ($usersWithChats as $user)
                                            <div class="chat-item {{ $initialChatUser && $initialChatUser->id == $user->id ? 'active' : '' }}"
                                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                <div class="chat-avatar">
                                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                </div>
                                                <div class="chat-info">
                                                    <div class="chat-name">{{ $user->name }}</div>
                                                    {{-- Tampilkan pesan terakhir jika ada --}}
                                                    @if ($user->chats->isNotEmpty())
                                                        @php
                                                            $latestChat = $user->chats->last(); // Ambil pesan terakhir
                                                        @endphp
                                                        <div class="chat-last-message">
                                                            {{ Str::limit($latestChat->message, 30) }}
                                                            @if ($latestChat->file_url)
                                                                📎 File
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="chat-main">
                                    <div class="chat-main-header">
                                        <button class="btn btn-link d-md-none me-2" onclick="toggleSidebar()">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <h5 id="chatTitle">
                                            {{ $initialChatUser ? $initialChatUser->name : 'Pilih percakapan' }}</h5>
                                    </div>

                                    {{-- <h1>{{ $initialMessages }}</h1> --}}
                                    <div class="chat-messages" id="chatMessages">
                                        {{-- Pesan akan dimuat di sini oleh JavaScript --}}
                                        @if ($initialMessages->isNotEmpty())
                                            @foreach ($initialMessages as $msg)
                                                {{-- <h1>{{ $msg }}</h1> --}}
                                                {{-- Cek apakah pesan dikirim oleh user yang sedang login (admin) atau penerima (customer) --}}
                                                {{-- Asumsi: Admin mengirim pesan dengan channel 'reply', customer mengirim dengan 'chat' --}}
                                                <div
                                                    class="message {{ $msg->user_id == $currentAuthId ? 'sent' : 'received' }} my-2">
                                                    @if ($msg->user_id == $currentAuthId)
                                                        {{-- Pesan dari admin (sent) - bubble + avatar kanan --}}
                                                        <div class="message-bubble">
                                                            @if ($msg->message)
                                                                {{ $msg->message }}<br>
                                                            @endif
                                                            @if ($msg->file_url)
                                                                <a href="{{ $msg->file_url }}" target="_blank"
                                                                    class="text-primary">📎Download File</a>
                                                            @endif
                                                            <div class="message-time">
                                                                {{ \Carbon\Carbon::parse($msg->sent_at)->format('d M Y H:i') }}
                                                            </div>
                                                        </div>
                                                        <div class="chat-avatar">AD</div>
                                                    @else
                                                        {{-- Pesan dari customer (received) - avatar kiri + bubble --}}
                                                        <div class="chat-avatar">CS</div>
                                                        <div class="message-bubble">
                                                            @if ($msg->message)
                                                                {{ $msg->message }}<br>
                                                            @endif
                                                            @if ($msg->file_url)
                                                                <a href="{{ $msg->file_url }}" target="_blank"
                                                                    class="text-primary">📎Download File</a>
                                                            @endif
                                                            <div class="message-time">
                                                                {{ \Carbon\Carbon::parse($msg->sent_at)->format('d M Y H:i') }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="text-center text-muted mt-5" id="noMessagesText">Tidak ada pesan
                                            untuk percakapan ini.</div>
                                    </div>

                                    <div id="previewAttachment" class="mb-2 ps-2"></div>

                                    <div class="chat-input">
                                        <div class="input-group">
                                            <div class="d-flex gap-2 w-100 align-items-center">
                                                <label for="fileInput" class="btn btn-link m-0 p-0">
                                                    <i class="fas fa-paperclip fa-lg"></i>
                                                </label>
                                                <input type="file" id="fileInput" style="display: none;"
                                                    accept="image/*,application/pdf">

                                                <input type="text" class="form-control"
                                                    placeholder="Tulis pesan di sini.." id="messageInput">

                                                <button class="send-btn" onclick="sendMessage()">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden input to store currently selected recipient ID --}}
                        <input type="hidden" id="currentRecipientId"
                            value="{{ $initialChatUser ? $initialChatUser->id : '' }}">
                        <script src="https://cdn.ably.io/lib/ably.min-1.js"></script>
                        <script>
                            // Initialize Ably
                            const ably = new Ably.Realtime('trEo7g.-zYUQA:WIqSAWOjhrr9DVtl-c0ERm-5o2ZoalsQEAWajS291JU');
                            let currentChatChannel = null;

                            const chatBox = document.getElementById('chatMessages');
                            const messageInput = document.getElementById('messageInput');
                            const fileInput = document.getElementById('fileInput');
                            const previewContainer = document.getElementById('previewAttachment');
                            const chatTitle = document.getElementById('chatTitle');
                            const chatList = document.getElementById('chatList');
                            const currentRecipientIdInput = document.getElementById('currentRecipientId');
                            const noMessagesText = document.getElementById('noMessagesText');

                            // PERBAIKAN: Simpan data chat di memori JavaScript yang bisa diupdate
                            let allUsersChats = @json($usersWithChats->keyBy('id'));

                            // Function to scroll chat to bottom
                            function scrollToBottom() {
                                chatBox.scrollTop = chatBox.scrollHeight;
                            }

                            // Function to render messages
                            function renderMessages(messages, currentUserId) {
                                chatBox.innerHTML = '';
                                if (messages.length === 0) {
                                    noMessagesText.style.display = 'block';
                                    return;
                                } else {
                                    noMessagesText.style.display = 'none';
                                }

                                messages.forEach(msg => {
                                    const div = document.createElement('div');
                                    const channel = msg.channel;
                                    div.classList.add('message', msg.channel === 'reply' ? 'sent' : 'received', 'my-2');

                                    let content = '';
                                    
                                    if (msg.channel === 'reply') {
                                        // Pesan dari admin (sent) - bubble + avatar kanan
                                        content = `<div class="message-bubble">`;
                                    } else {
                                        // Pesan dari customer (received) - avatar kiri + bubble
                                        content = `<div class="chat-avatar">CS</div><div class="message-bubble">`;
                                    }

                                    if (msg.message) {
                                        content += `${msg.message}<br>`;
                                    }
                                    if (msg.file_url) {
                                        content += `<a href="${msg.file_url}" target="_blank" class="text-primary">📎Download File</a>`;
                                    }

                                    const sentAt = new Date(msg.sent_at);
                                    const hours = sentAt.getHours().toString().padStart(2, '0');
                                    const minutes = sentAt.getMinutes().toString().padStart(2, '0');
                                    const timeFormatted = `${hours}:${minutes}`;

                                    content += `<div class="message-time">${timeFormatted}</div></div>`;
                                    
                                    if (msg.channel === 'reply') {
                                        // Tambahkan avatar di kanan untuk pesan dari admin
                                        content += `<div class="chat-avatar">AD</div>`;
                                    }

                                    div.innerHTML = content;
                                    chatBox.appendChild(div);
                                });
                                scrollToBottom();
                            }

                            // PERBAIKAN: Fungsi untuk menambah pesan ke data lokal
                            function addMessageToLocalData(userId, newMessage) {
                                if (!allUsersChats[userId]) {
                                    allUsersChats[userId] = {
                                        chats: []
                                    };
                                }
                                if (!allUsersChats[userId].chats) {
                                    allUsersChats[userId].chats = [];
                                }
                                allUsersChats[userId].chats.push(newMessage);
                            }

                            // PERBAIKAN: Fungsi untuk update last message di sidebar
                            function updateLastMessageInSidebar(userId, message, hasFile = false) {
                                const chatItem = document.querySelector(`.chat-item[data-user-id="${userId}"]`);
                                if (chatItem) {
                                    let lastMessageDiv = chatItem.querySelector('.chat-last-message');
                                    if (!lastMessageDiv) {
                                        lastMessageDiv = document.createElement('div');
                                        lastMessageDiv.className = 'chat-last-message';
                                        chatItem.querySelector('.chat-info').appendChild(lastMessageDiv);
                                    }

                                    let displayMessage = message ? message.substring(0, 30) : '';
                                    if (message && message.length > 30) displayMessage += '...';
                                    if (hasFile) displayMessage += ' 📎 File';

                                    lastMessageDiv.textContent = displayMessage;
                                }
                            }

                            // Handle file input change for preview
                            fileInput.addEventListener('change', function() {
                                const file = this.files[0];
                                previewContainer.innerHTML = '';

                                if (!file) return;

                                if (file.type.startsWith('image/')) {
                                    const img = document.createElement('img');
                                    img.src = URL.createObjectURL(file);
                                    img.style.maxWidth = '120px';
                                    img.style.borderRadius = '6px';
                                    img.style.boxShadow = '0 0 4px rgba(0,0,0,0.2)';
                                    previewContainer.appendChild(img);
                                } else {
                                    const fileInfo = document.createElement('div');
                                    fileInfo.textContent = `📎 ${file.name}`;
                                    previewContainer.appendChild(fileInfo);
                                }
                            });

                            function toggleSidebar() {
                                document.getElementById('chatSidebar').classList.toggle('active');
                            }

                            // Chat List Click Handler
                            chatList.addEventListener('click', function(event) {
                                let chatItem = event.target.closest('.chat-item');
                                if (chatItem) {
                                    document.querySelectorAll('.chat-item.active').forEach(item => item.classList.remove('active'));
                                    chatItem.classList.add('active');

                                    const userId = chatItem.dataset.userId;
                                    const userName = chatItem.dataset.userName;

                                    chatTitle.textContent = userName;
                                    currentRecipientIdInput.value = userId;

                                    // PERBAIKAN: Gunakan data lokal yang sudah diupdate
                                    const selectedUser = allUsersChats[userId];

                                    if (selectedUser && selectedUser.chats) {
                                        renderMessages(selectedUser.chats, {{ $currentAuthId }});
                                    } else {
                                        renderMessages([], {{ $currentAuthId }});
                                    }

                                    // Setup Ably channel
                                    if (currentChatChannel) {
                                        currentChatChannel.unsubscribe();
                                    }

                                    currentChatChannel = ably.channels.get(`chat`);
                                    // PERBAIKAN KHUSUS UNTUK SISI ADMIN

                                    // 1. PERBAIKAN untuk Ably subscriber di sisi admin
                                    currentChatChannel.subscribe('message', function(message) {
                                        const msg = message.data;
                                        const recipientIdOfMessage = msg.recipient_user_id || msg.user_id;
                                        const currentActiveRecipient = currentRecipientIdInput.value;

                                        if (recipientIdOfMessage == currentActiveRecipient || msg.user ==
                                            currentActiveRecipient) {
                                            // Tambahkan ke data lokal
                                            const newMessage = {
                                                message: msg.message,
                                                file_url: msg.file_url,
                                                sent_at: msg.sent_at,
                                                channel: msg.channel, // Pastikan channel dari backend
                                                user_id: msg.user_id
                                            };

                                            addMessageToLocalData(currentActiveRecipient, newMessage);

                                            const div = document.createElement('div');

                                            // PERBAIKAN UTAMA: 
                                            // Jika channel = 'reply' maka pesan dari admin (SENT di sisi admin)
                                            // Jika channel = 'chat' maka pesan dari customer (RECEIVED di sisi admin)
                                            const isSent = msg.channel === 'reply';

                                            div.classList.add('message', isSent ? 'sent' : 'received', 'my-2');

                                            // PERBAIKAN struktur HTML - avatar position sesuai dengan sent/received
                                            let content = '';

                                            if (isSent) {
                                                // Pesan SENT (dari admin) - struktur: bubble + avatar kanan
                                                content = `<div class="message-bubble">`;
                                            } else {
                                                // Pesan RECEIVED (dari customer) - struktur: avatar kiri + bubble  
                                                content = `<div class="chat-avatar">CS</div><div class="message-bubble">`;
                                            }

                                            if (msg.message) {
                                                content += `${msg.message}<br>`;
                                            }
                                            if (msg.file_url) {
                                                content +=
                                                    `<a href="${msg.file_url}" target="_blank" class="text-primary">📎Download File</a>`;
                                            }

                                            const sentAt = new Date(msg.sent_at);

                                            // Ambil jam dan menit seperti sebelumnya
                                            const hours = sentAt.getHours().toString().padStart(2, '0');
                                            const minutes = sentAt.getMinutes().toString().padStart(2, '0');
                                            const timeFormatted = `${hours}:${minutes}`;

                                            // --- Bagian baru untuk menambahkan tanggal ---

                                            // Ambil hari dalam format dua digit (misal: '01' atau '22')
                                            const day = sentAt.getDate().toString().padStart(2, '0');

                                            // Array nama bulan singkat
                                            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",
                                                "Oct", "Nov", "Dec"
                                            ];
                                            // Ambil nama bulan dari array berdasarkan indeks bulan
                                            const month = monthNames[sentAt.getMonth()];

                                            // Ambil tahun lengkap (misal: 2025)
                                            const year = sentAt.getFullYear();

                                            // Gabungkan semua komponen untuk mendapatkan format "DD Mon YYYY HH:MM"
                                            const dateTimeFormatted = `${day} ${month} ${year} ${timeFormatted}`;

                                            // --- Akhir bagian baru ---

                                            content += `<div class="message-time">${dateTimeFormatted}</div></div>`;

                                            if (isSent) {
                                                // Tambahkan avatar di kanan untuk pesan SENT
                                                content += `<div class="chat-avatar">AD</div>`;
                                            }

                                            div.innerHTML = content;
                                            chatBox.appendChild(div);
                                            scrollToBottom();

                                            // Update sidebar
                                            updateLastMessageInSidebar(currentActiveRecipient, msg.message, !!msg.file_url);
                                        }
                                    });

                                    if (window.innerWidth < 768) {
                                        toggleSidebar();
                                    }
                                }
                            });

                            // PERBAIKAN: Send message function yang diperbarui
                            function sendMessage() {
                                const message = messageInput.value.trim();
                                const file = fileInput.files[0];
                                const recipientUserId = currentRecipientIdInput.value;
                                const sendButton = document.querySelector('.send-btn');

                                if (!recipientUserId) {
                                    alert('Pilih percakapan terlebih dahulu.');
                                    return;
                                }

                                if (!message && !file) {
                                    alert('Pesan atau file harus diisi.');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('message', message);
                                if (file) {
                                    formData.append('file', file);
                                }
                                formData.append('user', recipientUserId);

                                sendButton.disabled = true;

                                fetch('/api/send-message-admin', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.status === 'Message sent') {
                                            messageInput.value = '';
                                            fileInput.value = '';
                                            previewContainer.innerHTML = '';

                                            const chatObject = res.chat;
                                            if (chatObject && chatObject.recipient_user_id == recipientUserId) {
                                                // PERBAIKAN: Tambahkan ke data lokal terlebih dahulu
                                                const newMessage = {
                                                    message: chatObject.message,
                                                    file_url: chatObject.file_url,
                                                    sent_at: chatObject.sent_at,
                                                    channel: 'reply', // Pesan dari admin
                                                    user_id: chatObject.user_id,
                                                    recipient_user_id: chatObject.recipient_user_id
                                                };

                                                addMessageToLocalData(recipientUserId, newMessage);

                                                // Baru tampilkan di UI
                                                const div = document.createElement('div');
                                                const isSent = chatObject.user_id == {{ $currentAuthId }};
                                                div.classList.add('message', isSent ? 'received' : 'sent', 'my-2');

                                                let content = `<div class="message-bubble">`;
                                                if (chatObject.message) {
                                                    content += `${chatObject.message}<br>`;
                                                }
                                                if (chatObject.file_url) {
                                                    content +=
                                                        `<a href="${chatObject.file_url}" target="_blank" class="text-primary">📎Download File</a>`;
                                                }

                                                const sentAt = new Date(chatObject.sent_at);
                                                const hours = sentAt.getHours().toString().padStart(2, '0');
                                                const minutes = sentAt.getMinutes().toString().padStart(2, '0');
                                                const timeFormatted = `${hours}:${minutes}`;

                                                content += `<div class="message-time">${timeFormatted}</div></div>`;
                                                content += `<div class="chat-avatar">AD</div>`;

                                                div.innerHTML = content;
                                                chatBox.appendChild(div);
                                                scrollToBottom();

                                                // PERBAIKAN: Update last message di sidebar
                                                updateLastMessageInSidebar(recipientUserId, chatObject.message, !!chatObject.file_url);
                                            }
                                        } else {
                                            console.error('Gagal mengirim pesan:', res);
                                            alert('Gagal mengirim pesan.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Terjadi kesalahan saat mengirim pesan.');
                                    })
                                    .finally(() => {
                                        sendButton.disabled = false;
                                    });
                            }

                            // Enter key support
                            messageInput.addEventListener('keypress', function(e) {
                                if (e.key === 'Enter' && !e.shiftKey) {
                                    e.preventDefault();
                                    sendMessage();
                                }
                            });

                            // Initialize
                            document.addEventListener('DOMContentLoaded', () => {
                                const initialRecipientId = currentRecipientIdInput.value;
                                if (initialRecipientId) {
                                    const firstChatItem = document.querySelector(`.chat-item[data-user-id="${initialRecipientId}"]`);
                                    if (firstChatItem) {
                                        firstChatItem.click();
                                    }
                                } else {
                                    noMessagesText.style.display = 'block';
                                }
                                scrollToBottom();
                            });
                        </script>
                    @elseif(Auth::user()->role == 'Customer')
                        <div class="col-lg-8">
                            <div class="chat-container">
                                <!-- Sidebar -->
                                <div class="chat-sidebar" id="chatSidebar">
                                    <div class="chat-list" id="chatList">
                                        <div class="chat-item active" data-chat="sinau-admin">
                                            <div class="chat-avatar">CS</div>
                                            <div class="chat-info">
                                                <div class="chat-name">SINAU ADMIN</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Chat Area -->
                                <div class="chat-main">
                                    <div class="chat-main-header">
                                        <button class="btn btn-link d-md-none me-2" onclick="toggleSidebar()">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <h5 id="chatTitle">SINAU ADMIN</h5>
                                    </div>

                                    <div class="chat-messages" id="chatMessages">
                                        {{-- <div class="date-divider">
                                        <span>Rabu, 25 Februari 2025</span>
                                    </div> --}}

                                        @foreach ($messages as $msg)
                                            @if ($msg->channel == 'chat')
                                                <div class="message sent my-2">
                                                    <div class="message-bubble">
                                                        @if ($msg->message)
                                                            {{ $msg->message }}<br>
                                                        @endif
                                                        <div class="message-time">
                                                            {{ $msg->created_at->format('d M Y H:i') }}
                                                        </div>
                                                    </div>
                                                    <div class="chat-avatar">CS</div>
                                                </div>
                                                @if ($msg->file_url)
                                                    <div class="message sent my-2">
                                                        <div class="message-bubble">
                                                            <a href="{{ $msg->file_url }}" target="_blank"
                                                                class="text-primary">📎Download File</a>
                                                            <div class="message-time">
                                                                {{ $msg->created_at->format('d M Y H:i') }}</div>
                                                        </div>
                                                        <div class="chat-avatar">CS</div>
                                                    </div>
                                                @endif
                                            @elseif($msg->channel == 'reply')
                                                <div class="message received my-2">
                                                    <div class="chat-avatar">AD</div>
                                                    <div class="message-bubble">
                                                        @if ($msg->message)
                                                            {{ $msg->message }}<br>
                                                        @endif
                                                        <div class="message-time">
                                                            {{ $msg->created_at->format('d M Y H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($msg->file_url)
                                                    <div class="message received my-2">
                                                        <div class="chat-avatar">AD</div>
                                                        <div class="message-bubble">
                                                            <a href="{{ $msg->file_url }}" target="_blank"
                                                                class="text-primary">📎Download File</a>
                                                            <div class="message-time">
                                                                {{ $msg->created_at->format('d M Y H:i') }}</div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Preview attachment -->
                                    <div id="previewAttachment" class="mb-2 ps-2"></div>

                                    <!-- Chat input -->
                                    <div class="chat-input">
                                        <div class="input-group">
                                            <div class="d-flex gap-2 w-100 align-items-center">
                                                <!-- Icon file input -->
                                                <label for="fileInput" class="btn btn-link m-0 p-0">
                                                    <i class="fas fa-paperclip fa-lg"></i>
                                                </label>
                                                <input type="file" id="fileInput" style="display: none;"
                                                    accept="image/*,application/pdf">

                                                <!-- Input pesan -->
                                                <input type="text" class="form-control"
                                                    placeholder="Tulis pesan di sini.." id="messageInput">

                                                <!-- Tombol kirim -->
                                                <button class="send-btn" onclick="sendMessage()">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <script src="https://cdn.ably.io/lib/ably.min-1.js"></script>
                            <script>
                                const ably = new Ably.Realtime('trEo7g.oAzxrg:Uzou0kYLpa6RT72V-8XRk04XOyagRpn8AOl0nbCUUkw');
                                const channel = ably.channels.get('chat');

                                const input = document.getElementById('messageInput');
                                const fileInput = document.getElementById('fileInput');
                                const previewContainer = document.getElementById('previewAttachment');

                                // Preview file saat dipilih
                                fileInput.addEventListener('change', function() {
                                    const file = this.files[0];
                                    previewContainer.innerHTML = '';

                                    if (!file) return;

                                    if (file.type.startsWith('image/')) {
                                        const img = document.createElement('img');
                                        img.src = URL.createObjectURL(file);
                                        img.style.maxWidth = '120px';
                                        img.style.borderRadius = '6px';
                                        img.style.boxShadow = '0 0 4px rgba(0,0,0,0.2)';
                                        previewContainer.appendChild(img);
                                    } else {
                                        const fileInfo = document.createElement('div');
                                        fileInfo.textContent = `📎 ${file.name}`;
                                        previewContainer.appendChild(fileInfo);
                                    }
                                });

                                const chatBox = document.getElementById('chatMessages');

                                // PERBAIKAN UNTUK SISI CUSTOMER
                                channel.subscribe('message', function(message) {
                                    const msg = message.data;
                                    const div = document.createElement('div');

                                    // PERBAIKAN UTAMA: Logika berdasarkan channel
                                    // channel 'chat' = pesan dari customer = SENT di sisi customer
                                    // channel 'reply' = pesan dari admin = RECEIVED di sisi customer
                                    const isSent = msg.channel === 'chat';

                                    div.classList.add('message', isSent ? 'sent' : 'received', 'my-2');

                                    let content = '';

                                    if (isSent) {
                                        // Pesan dari customer (sent) - avatar di kanan
                                        content = `<div class="message-bubble">`;
                                    } else {
                                        // Pesan dari admin (received) - avatar di kiri  
                                        content = `<div class="chat-avatar">AD</div><div class="message-bubble">`;
                                    }

                                    if (msg.message) {
                                        content += `${msg.message}`;
                                    }

                                    if (msg.file_url) {
                                        content += `<br><a href="${msg.file_url}" target="_blank" class="text-primary">📎Download File</a>`;
                                    }

                                    const originalDate = new Date(msg.sent_at || msg.timestamp);

                                    const hours = originalDate.getHours().toString().padStart(2, '0');
                                    const minutes = originalDate.getMinutes().toString().padStart(2, '0');
                                    const timeWIB = `${hours}:${minutes}`;

                                    // --- New part for adding the date ---
                                    const day = originalDate.getDate().toString().padStart(2, '0');
                                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                    const month = monthNames[originalDate.getMonth()];
                                    const year = originalDate.getFullYear();
                                    const dateTimeFormatted = `${day} ${month} ${year} ${timeWIB}`;

                                    content += `<div class="message-time">${dateTimeFormatted}</div></div>`;

                                    if (isSent) {
                                        // Tambahkan avatar di kanan untuk pesan sent
                                        content += `<div class="chat-avatar">CS</div>`;
                                    }

                                    div.innerHTML = content;
                                    chatBox.appendChild(div);
                                    chatBox.scrollTop = chatBox.scrollHeight;
                                });

                                function sendMessage() {
                                    const input = document.getElementById('messageInput');
                                    const fileInput = document.getElementById('fileInput');
                                    const previewContainer = document.getElementById('previewAttachment');
                                    const sendButton = document.querySelector('.send-btn');

                                    const message = input.value.trim();
                                    const file = fileInput.files[0];

                                    if (!message && !file) {
                                        alert('Pesan atau file harus diisi.');
                                        return;
                                    }

                                    const formData = new FormData();
                                    formData.append('user', {{ Auth::id() }});
                                    formData.append('message', message);
                                    if (file) {
                                        formData.append('file', file);
                                    }

                                    // Disable tombol kirim saat proses
                                    sendButton.disabled = true;

                                    fetch('/api/send-message', {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(res => res.json())
                                        .then(res => {
                                            if (res.status === 'Message sent') {
                                                input.value = '';
                                                fileInput.value = '';
                                                previewContainer.innerHTML = '';
                                            } else {
                                                console.error('Gagal mengirim pesan:', res);
                                                alert('Gagal mengirim pesan.');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            alert('Terjadi kesalahan saat mengirim pesan.');
                                        })
                                        .finally(() => {
                                            sendButton.disabled = false;
                                        });
                                }
                            </script>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>
@endsection