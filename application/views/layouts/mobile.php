<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? $title : 'Alvinto POS'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (buat icon di bottom nav) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f1f5f9;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .app-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
        }

        .app-shell {
            background: #ffffff;
            width: 100%;
            max-width: 480px; /* biar kerasa kayak aplikasi HP */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(15, 23, 42, 0.15);
            transition: max-width 0.2s ease-in-out;
        }

        .app-header {
            padding: 12px 16px;
            background: #0f172a;
            color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-header-title {
            font-size: 16px;
            font-weight: 600;
        }

        .app-header-subtitle {
            font-size: 11px;
            color: #9ca3af;
        }

        .app-content {
            flex: 1;
            padding: 12px;
            overflow-y: auto;
            background: #e5e7eb;
            padding-bottom: 80px; /* Space for fixed bottom nav */
        }

        .app-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            border-top: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 4px 0;
            z-index: 1050;
            padding-bottom: env(safe-area-inset-bottom); /* Support for iPhone X+ home indicator */
            transition: max-width 0.2s ease-in-out;
        }

        .bottom-nav-inner {
            display: flex;
            justify-content: space-around;
            width: 100%;
            transition: max-width 0.2s ease-in-out;
        }

        .app-scrollable-table {
            max-height: 400px; /* fallback */
            max-height: 60vh;
            overflow-y: auto;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Breakpoints responsif untuk tablet & laptop */
        @media (min-width: 576px) {
            .app-shell, .app-bottom-nav {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .app-shell, .app-bottom-nav {
                max-width: 720px;
            }
            .bottom-nav-inner {
                max-width: 600px;
                margin: 0 auto;
            }
        }

        @media (min-width: 992px) {
            .app-shell, .app-bottom-nav {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .app-shell, .app-bottom-nav {
                max-width: 1140px;
            }
        }

        .bottom-nav-item {
            text-align: center;
            flex: 1;
            padding: 4px;
            font-size: 11px;
            color: #6b7280;
            text-decoration: none;
        }

        .bottom-nav-item i {
            display: block;
            font-size: 18px;
        }

        .bottom-nav-item.active {
            color: #0f172a;
            font-weight: 600;
        }

        .card-app {
            border-radius: 16px;
            border: none;
        }

        .btn-app {
            border-radius: 999px;
        }
        .user-dropdown {
    position: relative;
    display: inline-block;
}

.user-name {
    font-size: 11px;
    cursor: pointer;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 20px;
    background: #fff;
    border: 1px solid #ddd;
    min-width: 120px;
    box-shadow: 0 2px 6px rgba(0,0,0,.15);
    z-index: 1000;
}

.dropdown-menu a {
    display: block;
    padding: 8px 12px;
    font-size: 12px;
    text-decoration: none;
    color: #333;
}

.dropdown-menu a:hover {
    background: #f5f5f5;
}
        
    </style>
</head>
<body>

<div class="app-wrapper">
    <div class="app-shell">
        <!-- HEADER -->
        <div class="app-header">
            <div>
                <div class="app-header-title">
                    <?= isset($app_title) ? $app_title : 'Alvinto Barbershop'; ?>
                </div>
                <div class="app-header-subtitle">
                    <?= isset($app_subtitle) ? $app_subtitle : 'Point of Sale'; ?>
                </div>
            </div>
            <div class="user-dropdown">
    <?php if (!empty($this->session->userdata('nama'))): ?>
        <span class="user-name" onclick="toggleDropdown()">
            👤 <?= $this->session->userdata('nama'); ?>
        </span>

        <div id="dropdownMenu" class="dropdown-menu">
            <a href="<?= base_url('profil/ganti_password'); ?>">Ganti Password</a>
            <a href="<?= base_url('auth/logout'); ?>">Logout</a>
        </div>
    <?php
endif; ?>
</div>

        </div>

        <!-- CONTENT -->
        <div class="app-content">
            <?php
// konten utama
if (isset($page)) {
    $this->load->view($page, isset($page_data) ? $page_data : []);
}
else {
    echo "<p class='text-center text-muted'>Tidak ada konten.</p>";
}
?>
        </div>

        <!-- BOTTOM NAV: nanti kita isi beda untuk admin & kasir -->
        <?php if (isset($bottom_nav) && $bottom_nav): ?>
            <div class="app-bottom-nav">
                <div class="bottom-nav-inner">
                    <?php foreach ($bottom_nav as $item): ?>
                        <a href="<?= site_url($item['url']); ?>"
                           class="bottom-nav-item <?=!empty($item['active']) ? 'active' : ''; ?>">
                            <i class="<?= $item['icon']; ?>"></i>
                            <span><?= $item['label']; ?></span>
                        </a>
                    <?php
    endforeach; ?>
                </div>
            </div>
        <?php
endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

// tutup dropdown kalau klik di luar
document.addEventListener("click", function(e) {
    const dropdown = document.querySelector(".user-dropdown");
    if (!dropdown.contains(e.target)) {
        document.getElementById("dropdownMenu").style.display = "none";
    }
});
</script>


</body>
</html>
