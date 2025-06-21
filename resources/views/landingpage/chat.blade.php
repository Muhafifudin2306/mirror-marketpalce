@extends('landingpage.index')
@section('content')
    <style>
        .form-control {
            border-radius: 50px !important;
            height: 55px;
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .form-control::placeholder {
            padding: 0 10px;
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
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            color: #444;
        }

        .edit-btn {
            border-radius: 0.25rem !important;
        }

        #editPasswordFields .eye-btn {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
        }

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
            cursor: pointer !important;
        }

        .sidebar-filter a:hover {
            padding-right: 40px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            color: #000 !important;
        }

        .sidebar-filter a.active {
            background-color: #f1f7ff !important;
            color: #000 !important;
        }

        .sidebar-filter a.active::after {
            content: '' !important;
            position: absolute !important;
            width: 10px !important;
            height: 10px !important;
            background-color: #0439a0 !important;
            top: 50% !important;
            right: 12px !important;
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
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 1.6rem;
            margin-bottom: 16px;
        }

        .is-invalid {
            border-color: #fc2865 !important;
        }

        .invalid-feedback {
            display: block;
            color: #fc2865;
            font-size: 0.8rem;
            font-weight: 200;
        }

        .btn-edit-text {
            display: inline-block;
            padding: 6px 12px;
            font-size: 16px;
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
            padding: 13px 14px;
            font-size: 18px;
            margin-top: 24px;
            border: none;
            border-radius: 50px;
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
            font-size: 13px;
            margin-top: 18px;
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
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
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
            margin-bottom: 4px;
            display: inline-block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input.form-control {
            padding-right: 45px !important;
        }

        .eye-btn {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #999;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .notification-badge {
            font-size: 0.9rem;
            padding: 4px 12px;
            border-radius: 4px;
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
            gap: 0.5rem;
        }

        .pagination .page-link {
            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            padding: 0;
            line-height: 38px;
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
            padding: 12px 65px;
            background-color: transparent;
            color: white;
            border-radius: 50px;
            border: 2px solid white;
            font-size: 1.1rem;
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
            height: 700px;
            display: flex;
        }

        .chat-sidebar {
            width: 200px;
            background: white;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px 20px;
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
            padding: 15px 20px;
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
            border-right: 3px solid #2196f3;
        }

        .chat-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .chat-info {
            flex: 1;
            min-width: 0;
        }

        .chat-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .chat-preview {
            color: #6c757d;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-meta {
            text-align: right;
            flex-shrink: 0;
            margin-left: 10px;
        }

        .chat-time {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .chat-badge {
            background: #28a745;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .chat-main-header {
            padding: 15px 20px;
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
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message-bubble {
            font-family: 'Barlow', sans-serif;
            font-size: 1.2rem !important;
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }

        .message.received .message-bubble {
            background: white;
            border: 1px solid #e9ecef;
            min-width: 15rem;
            /* margin-left: 45px; */
        }

        .message.sent .message-bubble {
            background: #cfe0ee;
            color: rgb(22, 20, 20);
            margin-right: 10px;
            min-width: 15rem;
        }

        .message-time {
            font-size: 11px;
            margin-top: 5px;
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
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
            position: absolute;
            /* left: 20px; */
        }

        .chat-input {
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            background: white;
        }

        .input-group {
            position: relative;
        }


        .send-btn {
            /* position: absolute; */
            right: 8px;
            background: #2196f3;
            border: none;
            border-radius: 50%;
            width: 65px;
            color: white;
            cursor: pointer;
            padding-top: 0.7rem;
            padding-right: 1rem;
            padding-bottom: 0.7rem;
            padding-left: 1rem;
            transition: background-color 0.2s;
        }

        .send-btn:hover {
            background: #1976d2;
        }

        .file-attachment {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 8px 12px;
            margin: 5px 0;
            display: inline-flex;
            align-items: center;
            font-size: 13px;
            color: #1976d2;
        }

        .date-divider {
            text-align: center;
            margin: 20px 0;
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
            padding: 0 15px;
            color: #6c757d;
            font-size: 12px;
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
    </style>

    <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="position-relative mb-0">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
            <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%; width: 90%;">
                <!-- WRAPPER BARU untuk greeting + logout -->
                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                    <h3 class="mb-0" style="font-family:'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">
                        Halo, <span style="color:#ffc74c">{{ Auth::user()->name }}</span>
                    </h3>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="logout-button">LOGOUT</button>
                    </form>
                </div>

                <!-- Breadcrumb tetap di bawah -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-family:'Poppins'; font-size:1rem; font-weight:400;">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">BERANDA</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PROFIL</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    <main>
        <div class="container-fluid px-4">
            <div class="container product-card" style="margin-top:-180px;">
                <div class="row g-5" style="margin-top:40px;">

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
                                                    <div class="message-time">{{ $msg->created_at->format('d M Y H:i') }}
                                                    </div>
                                                </div>
                                                <div class="chat-avatar">SP</div>
                                            </div>
                                            @if ($msg->file_url)
                                                <div class="message sent my-2">
                                                    <div class="message-bubble">
                                                        <a href="{{ $msg->file_url }}" target="_blank"
                                                            class="text-primary">📎Download File</a>
                                                        <div class="message-time">
                                                            {{ $msg->created_at->format('d M Y H:i') }}</div>
                                                    </div>
                                                    <div class="chat-avatar">SP</div>
                                                </div>
                                            @endif
                                        @elseif($msg->channel == 'reply')
                                            <div class="message received my-2">
                                                <div class="chat-avatar">CS</div>
                                                <div class="message-bubble">
                                                    @if ($msg->message)
                                                        {{ $msg->message }}<br>
                                                    @endif
                                                    <div class="message-time">{{ $msg->created_at->format('d M Y H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($msg->file_url)
                                                <div class="message received my-2">
                                                    <div class="chat-avatar">CS</div>
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
                                            <input type="text" class="form-control" placeholder="Tulis pesan di sini.."
                                                id="messageInput">

                                            <!-- Tombol kirim -->
                                            <button class="send-btn" onclick="sendMessage()">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    
                                </script>

                            </div>
                        </div>

                        <script src="https://cdn.ably.io/lib/ably.min-1.js"></script>
                        <script>
                            const ably = new Ably.Realtime('trEo7g.-zYUQA:WIqSAWOjhrr9DVtl-c0ERm-5o2ZoalsQEAWajS291JU');
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
                                            img.style.maxWidth = '150px';
                                            img.style.borderRadius = '8px';
                                            img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';
                                            previewContainer.appendChild(img);
                                        } else {
                                            const fileInfo = document.createElement('div');
                                            fileInfo.textContent = `📎 ${file.name}`;
                                            previewContainer.appendChild(fileInfo);
                                        }
                                    });

                            const chatBox = document.getElementById('chatMessages');
                            // const input = document.getElementById('messageInput');

                            channel.subscribe('message', function(message) {
                                const msg = message.data;
                                const div = document.createElement('div');
                                div.classList.add('message', msg.user === 'admin' ? 'received' : 'sent');

                                let content = `<div class="message-bubble">${msg.message || ''}`;
                                if (msg.file_url) {
                                    const fileName = msg.file_url.split('/').pop();
                                    content += `<br><a href="${msg.file_url}" target="_blank" class="text-primary">📎Download File</a>`;
                                }

                                const originalDate = new Date(msg.timestamp);
                                const hours = originalDate.getHours().toString().padStart(2, '0');
                                const minutes = originalDate.getMinutes().toString().padStart(2, '0');
                                const timeWIB = `${hours}:${minutes}`;

                                content += `<div class="message-time">${timeWIB}</div></div><div class="chat-avatar">SP</div>`;


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
                                formData.append('user', {{ Auth::id() }}); // pastikan Auth tersedia
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

                </div>
            </div>
        </div>
    </main>
@endsection
