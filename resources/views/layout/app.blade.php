<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>This is my article</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
       /* =========================================
           1. 保留：原本的 +1 彈出動畫
           ========================================= */
        .like-popup {
            position: absolute;
            top: -15px; /* 浮在按鈕右上角 */
            right: -10px;
            background: #ef4444; /* 紅色背景 */
            color: white;
            font-weight: bold;
            border-radius: 9999px;
            padding: 2px 6px;
            font-size: 12px;
            opacity: 0; /* 預設隱藏 */
            pointer-events: none;
            z-index: 100;
        }
        .like-popup.show {
            opacity: 1 !important;
            animation: popup-fly 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
        }
        @keyframes popup-fly {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); opacity: 0; }
        }

        /* =========================================
           2. 保留：Like 按鈕本身的特效
           ========================================= */
        .like-btn {
            transition: transform 0.15s ease;
        }
        .like-icon {
            transition: transform 0.2s ease;
        }
        .like-btn.pop {
            animation: heart-pop 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        .like-btn.pop .like-icon {
            position: relative;
        }
        .like-btn:hover {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25) !important;
        }
        .btn { 
            transition: all 0.15s ease !important; 
        }

        /* =========================================
           3. 全新：乾淨的愛心起飛動畫 💖
           ========================================= */
        .pure-floating-heart {
            position: fixed;
            font-size: 24px;
            z-index: 9999;
            pointer-events: none; /* 讓滑鼠可以穿透它，不會阻擋點擊 */
            animation: pureHeartFly 1.5s cubic-bezier(0.25, 1, 0.5, 1) forwards; 
        }

        @keyframes pureHeartFly {
            0% { transform: translate(0, 0) scale(0.5); opacity: 0; }
            15% { transform: translate(-10px, -25px) scale(1.3); opacity: 1; }
            100% { transform: translate(-20px, -90px) scale(0.8); opacity: 0; }
        }
    </style>


</head>
<body>
 <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Blog</h1>
        <div>
@auth
            <span class="me-3 text-muted">Welcome, {{ Auth::user()->name }}!</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary me-2">Logout</button>
            </form>
@else
            <a href="/login" class="btn btn-outline-primary me-2">Login</a>
            <a href="/register" class="btn btn-outline-success">Register</a>
@endauth
        </div>
    </div>

    @yield('content')
 </div>

<script src="{{ asset('js/posts.js') }}"></script>
  
</body>
</html>
