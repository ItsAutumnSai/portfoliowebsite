<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sultan Agung Portfolio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }
        
        .portfolio-card {
            aspect-ratio: 1;
            background: #f8f9fa;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        .portfolio-card:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .portfolio-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .portfolio-preview {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20vh;
            background: linear-gradient(180deg, transparent, rgba(0,0,0,0.8));
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
            backdrop-filter: blur(10px);
        }
        
        .portfolio-preview.active {
            display: flex;
        }
        
        .portfolio-preview h3 {
            color: white;
            font-size: 2rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-1px);
        }
        
        .btn-danger {
            background: #ef4444;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 fixed w-full top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-black">Sultan Agung Portfolio</a>
                </div>
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-black font-medium">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary">Register</a>
                    @endguest
                    
                    @auth
                        <span class="text-gray-700">Welcome, {{ auth()->user()->username }}</span>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-black font-medium">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-black font-medium">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16 min-h-screen">
        @yield('content')
    </main>

    <!-- Portfolio Preview -->
    <div class="portfolio-preview" id="portfolioPreview">
        <h3 id="previewTitle"></h3>
    </div>

    <script>
        // Portfolio hover preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const portfolioCards = document.querySelectorAll('.portfolio-card');
            const preview = document.getElementById('portfolioPreview');
            const previewTitle = document.getElementById('previewTitle');
            
            portfolioCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    const title = this.dataset.title;
                    const image = this.dataset.image;
                    
                    previewTitle.textContent = title;
                    if (image) {
                        preview.style.backgroundImage = `url('${image}')`;
                        preview.style.backgroundSize = 'cover';
                        preview.style.backgroundPosition = 'center';
                    }
                    preview.classList.add('active');
                });
                
                card.addEventListener('mouseleave', function() {
                    preview.classList.remove('active');
                });
            });
        });
    </script>
</body>
</html>