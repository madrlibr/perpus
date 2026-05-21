<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpusku - Digital Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #mainSidebar { transition: width 0.3s ease, transform 0.3s ease; overflow-x: hidden; }
        #mainContent { transition: margin-left 0.3s ease; }
        .nav-label { white-space: nowrap; }
        .swal2-popup { border-radius: 2.5rem !important; padding: 2rem !important; }
        .swal2-title { font-weight: 800 !important; color: #1e293b !important; }
        .swal2-confirm { border-radius: 1.2rem !important; font-weight: 700 !important; padding: 0.8rem 2rem !important; }
        .swal2-cancel { border-radius: 1.2rem !important; font-weight: 700 !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<nav class="fixed top-0 right-0 left-0 h-16 bg-white border-b border-slate-100 flex items-center justify-between px-4 z-50">
    <div class="flex items-center gap-4">
        <button id="sidebarToggle" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-600 transition-all">
            <i class="fas fa-bars text-lg" id="toggleIcon"></i>
        </button>
        <span class="font-black text-xl tracking-tighter text-blue-600 uppercase">Perpus<span class="text-slate-800">ku</span></span>
    </div>
    
    <div class="flex items-center gap-3">
        <div class="text-right mr-2">
            <p class="text-xs font-bold text-slate-800"><?= $_SESSION['username'] ?? 'Admin'; ?></p>
            <p class="text-[10px] text-slate-400 uppercase font-black"><?= $_SESSION['role'] ?? 'Petugas'; ?></p>
        </div>
    </div>
</nav>