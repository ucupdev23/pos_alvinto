<?php
defined('BASEPATH') or exit('No direct script access allowed');
$base = base_url();
$logo_url = base_url('assets/logo.png');
$wa_number = '6285691489851';
$wa_link = 'https://wa.me/' . $wa_number . '?text=' . urlencode('Halo Alvinto Haircut, saya ingin tanya layanan dan lokasi barbershop.');
$tiktok_url = 'https://www.tiktok.com/@alvinto_barberian';
$instagram_url = 'https://instagram.com/alvinto_haircut';

// Mapping deskripsi unik per jenis layanan (keyword matching)
$desc_map = [
    'anak'      => 'Buat si kecil (0–10 tahun). Ada kursi mobil-mobilan biar anteng & happy pas dicukur.',
    'remaja'    => 'Buat kamu yang masih sekolah (SMP–SMA). Gaya kekinian, harga kantong pelajar.',
    'tanggung'  => 'Udah bukan bocil, belum om-om juga. Potongan fresh buat yang lagi tumbuh gede.',
    'dewasa'    => 'Buat abang 17 tahun ke atas. Konsultasi model, potong rapi, finishing styling.',
    'cuci'      => 'Keramas seger + pijat kepala ringan + styling pomade.',
    'kumis'     => 'Rapihin kumis & jenggot pakai razor steril + foam lembut.',
    'jenggot'   => 'Rapihin kumis & jenggot pakai razor steril + foam lembut.',
    'cukur'     => 'Rapihin kumis & jenggot pakai razor steril + foam lembut.',
    'semir'     => 'Warna hitam natural atau warna kekinian sesuai request kamu.',
    'pewarnaan' => 'Warna hitam natural atau warna kekinian sesuai request kamu.',
    'paket'     => 'Pangkas + cuci + shaving + pijat + pomade. All-in-one, tinggal duduk.',
    'komplit'   => 'Pangkas + cuci + shaving + pijat + pomade. All-in-one, tinggal duduk.',
];

function get_service_desc($nama, $map) {
    $lower = strtolower($nama);
    foreach ($map as $key => $desc) {
        if (strpos($lower, $key) !== false) {
            return $desc;
        }
    }
    return 'Layanan pangkas rambut dengan kapster berpengalaman.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Alvinto Haircut - Barbershop Specialist Pria & Anak di Kota Bogor | Est. 2015'; ?></title>

    <!-- SEO Primary Meta Tags -->
    <meta name="title" content="Alvinto Haircut - Barbershop Specialist Pria & Anak di Kota Bogor">
    <meta name="description" content="Alvinto Haircut adalah barbershop specialist pria dan anak di Kota Bogor sejak 2015. 3 cabang strategis: Mekar Sari, Gunung Batu, dan Kebon Kelapa. Tempat nyaman ber-AC & kapster berpengalaman.">
    <meta name="keywords" content="barbershop bogor, pangkas rambut bogor, potong rambut pria bogor, barbershop anak bogor, alvinto haircut, pangkas rambut mekar sari, pangkas rambut gunung batu, pangkas rambut kebon kelapa, barbershop terbaik di bogor">
    <meta name="author" content="Alvinto Haircut">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= base_url(); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url(); ?>">
    <meta property="og:title" content="Alvinto Haircut - Barbershop Specialist Pria & Anak di Kota Bogor">
    <meta property="og:description" content="Potongan rapi, gaya maksimal! Barbershop terpercaya di Kota Bogor sejak 2015 dengan 3 cabang: Mekar Sari, Gunung Batu, dan Kebon Kelapa.">
    <meta property="og:image" content="<?= base_url('assets/img/5.webp'); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= base_url(); ?>">
    <meta property="twitter:title" content="Alvinto Haircut - Barbershop Specialist Pria & Anak di Kota Bogor">
    <meta property="twitter:description" content="Potongan rapi, gaya maksimal! Barbershop terpercaya di Kota Bogor sejak 2015 dengan 3 cabang.">
    <meta property="twitter:image" content="<?= base_url('assets/img/5.webp'); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $logo_url; ?>">

    <!-- Google Fonts: Space Grotesk (heading) + Inter (body) — only 2 fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Prevent flash of wrong theme -->
    <script>
        (function(){
            var t = localStorage.getItem('alvinto-theme');
            if (t === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
        })();
    </script>

    <!-- Schema.org JSON-LD Structured Data for Local SEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BarberShop",
      "name": "Alvinto Haircut",
      "image": "<?= base_url('assets/img/5.webp'); ?>",
      "logo": "<?= $logo_url; ?>",
      "@id": "<?= base_url(); ?>",
      "url": "<?= base_url(); ?>",
      "telephone": "+6285691489851",
      "priceRange": "$$",
      "description": "Barbershop spesialis potong rambut pria dan anak-anak di Kota Bogor sejak 2015.",
      "foundingDate": "2015",
      "slogan": "Karena ganteng itu butuh proses!",
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Saturday","Sunday"],
          "opens": "10:00",
          "closes": "21:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Friday",
          "opens": "13:00",
          "closes": "21:00"
        }
      ],
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Blok Mekar Sari Jalan Ledeng Blok Mekar Sari No.26, RT.01/RW.07, Kb. Klp., Kecamatan Bogor Tengah",
        "addressLocality": "Kota Bogor",
        "addressRegion": "Jawa Barat",
        "postalCode": "16125",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.595,
        "longitude": 106.790
      },
      "department": [
        {
          "@type": "BarberShop",
          "name": "Alvinto Haircut - Cabang Mekar Sari (Pusat)",
          "address": "Blok Mekar Sari Jalan Ledeng Blok Mekar Sari No.26, RT.01/RW.07, Kb. Klp., Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16125",
          "hasMap": "https://maps.app.goo.gl/7u2TKqKLU15zgUmGA"
        },
        {
          "@type": "BarberShop",
          "name": "Alvinto Haircut - Cabang Gunung Batu",
          "address": "Gunung Batu, Kota Bogor, Jawa Barat",
          "hasMap": "https://maps.app.goo.gl/bDwRTvBbMSpia8YEA"
        },
        {
          "@type": "BarberShop",
          "name": "Alvinto Haircut - Cabang Kebon Kelapa",
          "address": "Kebon Kelapa, Kota Bogor, Jawa Barat",
          "hasMap": "https://maps.app.goo.gl/FXwmaaArc85Xwtfe9"
        }
      ]
    }
    </script>

    <style>
        /* ===========================================
           DESIGN TOKENS — LIGHT (default) + DARK
           2 Fonts: Space Grotesk + Inter
           3 Colors: Black + White + Blue
        =========================================== */
        :root {
            --bg: #FFFFFF;
            --bg-nav: rgba(255, 255, 255, 0.92);
            --surface: #F5F5F6;
            --surface-2: #EAEAEB;
            --blue: #2563FF;
            --blue-hover: #1D4FD7;
            --blue-bg: rgba(37, 99, 255, 0.06);
            --text: #111111;
            --text-2: #555555;
            --text-3: #888888;
            --text-4: #BBBBBB;
            --border: rgba(0, 0, 0, 0.09);
            --border-2: rgba(0, 0, 0, 0.16);
            --wa: #25D366;
            --shadow: rgba(0, 0, 0, 0.06);
            --shadow-2: rgba(0, 0, 0, 0.10);
            --font-h: 'Space Grotesk', sans-serif;
            --font-b: 'Inter', sans-serif;
        }

        html[data-theme="dark"] {
            --bg: #0A0A0A;
            --bg-nav: rgba(10, 10, 10, 0.92);
            --surface: #141414;
            --surface-2: #1C1C1C;
            --blue-hover: #3B7AFF;
            --blue-bg: rgba(37, 99, 255, 0.12);
            --text: #FFFFFF;
            --text-2: #A0A0A0;
            --text-3: #666666;
            --text-4: #444444;
            --border: rgba(255, 255, 255, 0.08);
            --border-2: rgba(255, 255, 255, 0.15);
            --shadow: rgba(0, 0, 0, 0.3);
            --shadow-2: rgba(0, 0, 0, 0.5);
        }

        /* ===========================================
           RESET & BASE
        =========================================== */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: var(--font-b);
            background: var(--bg);
            color: var(--text-2);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        ul { list-style: none; }

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===========================================
           SCROLL REVEAL
        =========================================== */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===========================================
           NAVBAR
        =========================================== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 90;
            background: var(--bg-nav);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo img {
            height: 40px;
            width: auto;
        }

        .nav-logo-text {
            font-family: var(--font-h);
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.3px;
            line-height: 1.1;
        }

        .nav-logo-sub {
            font-family: var(--font-b);
            font-size: 11px;
            font-weight: 500;
            color: var(--text-3);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-3);
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--text);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .theme-toggle {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
        }

        .theme-toggle:hover {
            border-color: var(--border-2);
            color: var(--text);
        }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: var(--font-b);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .nav-btn-primary {
            background: var(--blue);
            color: #FFFFFF;
        }

        .nav-btn-primary:hover {
            background: var(--blue-hover);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text);
            font-size: 24px;
            cursor: pointer;
            padding: 4px;
        }

        /* ===========================================
           HERO
        =========================================== */
        .hero {
            padding: 72px 0 56px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 48px;
            align-items: center;
        }

        .hero-logo {
            margin-bottom: 28px;
        }

        .hero-logo img {
            height: 80px;
            width: auto;
        }

        .hero h1 {
            font-family: var(--font-h);
            font-size: clamp(36px, 5vw, 54px);
            font-weight: 700;
            color: var(--text);
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 18px;
        }

        .hero h1 .accent {
            color: var(--blue);
        }

        .hero-sub {
            font-size: 16px;
            color: var(--text-2);
            max-width: 480px;
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 44px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 10px;
            font-family: var(--font-b);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-blue {
            background: var(--blue);
            color: #FFFFFF;
        }

        .btn-blue:hover {
            background: var(--blue-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border-2);
        }

        .btn-outline:hover {
            border-color: var(--text);
            transform: translateY(-1px);
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .hero-stat-num {
            font-family: var(--font-h);
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 4px;
        }

        .hero-photo img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid var(--border);
        }

        /* ===========================================
           MARQUEE
        =========================================== */
        .marquee {
            background: var(--blue);
            padding: 13px 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .marquee-track {
            display: flex;
            animation: scroll-marquee 20s linear infinite;
            width: max-content;
        }

        .marquee-text {
            font-family: var(--font-h);
            font-size: 13px;
            font-weight: 600;
            color: #FFFFFF;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding-right: 56px;
        }

        @keyframes scroll-marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* ===========================================
           SECTION COMMON
        =========================================== */
        .section {
            padding: 76px 0;
        }

        .section-label {
            font-family: var(--font-h);
            font-size: 12px;
            font-weight: 600;
            color: var(--blue);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .section h2 {
            font-family: var(--font-h);
            font-size: clamp(26px, 3.5vw, 38px);
            font-weight: 700;
            color: var(--text);
            line-height: 1.15;
            letter-spacing: -0.8px;
            margin-bottom: 14px;
        }

        .section-desc {
            font-size: 15px;
            color: var(--text-2);
            max-width: 540px;
            line-height: 1.65;
        }

        .section-header-center {
            text-align: center;
            margin-bottom: 44px;
        }

        .section-header-center .section-desc {
            margin: 0 auto;
        }

        /* ===========================================
           HARGA — price list (menu-style)
        =========================================== */
        .price-list {
            max-width: 700px;
            margin: 0 auto;
        }

        .price-item {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 16px;
            padding: 22px 0;
            border-bottom: 1px solid var(--border);
        }

        .price-item:last-child {
            border-bottom: none;
        }

        .price-info { flex: 1; }

        .price-name {
            font-family: var(--font-h);
            font-size: 17px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 3px;
        }

        .price-desc {
            font-size: 13px;
            color: var(--text-3);
            line-height: 1.5;
        }

        .price-amount {
            font-family: var(--font-h);
            font-size: 19px;
            font-weight: 700;
            color: var(--blue);
            white-space: nowrap;
        }

        /* ===========================================
           GALLERY
        =========================================== */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            border-radius: 16px;
            overflow: hidden;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0);
            transition: background 0.3s;
        }

        .gallery-item:hover::after {
            background: rgba(0, 0, 0, 0.15);
        }

        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 14px;
            background: linear-gradient(transparent, rgba(0,0,0,0.65));
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 2;
        }

        .gallery-item:hover .gallery-caption {
            opacity: 1;
        }

        .gallery-caption-title {
            font-family: var(--font-h);
            font-size: 13px;
            font-weight: 600;
            color: #FFFFFF;
        }

        /* ===========================================
           ABOUT
        =========================================== */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }

        .about-text p {
            margin-bottom: 18px;
            line-height: 1.75;
        }

        .about-features {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 28px;
        }

        .about-feature {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .about-feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: var(--blue-bg);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .about-feature h4 {
            font-family: var(--font-h);
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 2px;
        }

        .about-feature p {
            font-size: 13px;
            color: var(--text-3);
            margin-bottom: 0;
        }

        .about-photo img {
            width: 100%;
            height: 460px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid var(--border);
        }

        /* ===========================================
           BRANCHES
        =========================================== */
        .branches-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .branch-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 26px 22px;
            transition: border-color 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .branch-card:hover {
            border-color: var(--border-2);
            box-shadow: 0 4px 20px var(--shadow);
        }

        .branch-card.pusat {
            border-color: rgba(37, 99, 255, 0.25);
        }

        .branch-badge {
            font-family: var(--font-h);
            font-size: 11px;
            font-weight: 600;
            color: var(--blue);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .branch-name {
            font-family: var(--font-h);
            font-size: 19px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .branch-address {
            font-size: 13px;
            color: var(--text-3);
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .branch-info {
            display: flex;
            flex-direction: column;
            gap: 7px;
            padding: 14px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            margin-bottom: 18px;
            font-size: 13px;
            color: var(--text-2);
        }

        .branch-info span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .branch-info i {
            color: var(--blue);
            font-size: 14px;
            width: 16px;
            text-align: center;
        }

        .btn-maps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-2);
            font-family: var(--font-b);
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-maps:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        /* ===========================================
           REVIEWS
        =========================================== */
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .review-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 26px 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .review-quote {
            font-size: 15px;
            color: var(--text);
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .review-quote::before {
            content: '\201C';
            font-size: 28px;
            font-family: var(--font-h);
            color: var(--blue);
            line-height: 0;
            vertical-align: -8px;
            margin-right: 4px;
        }

        .review-author {
            font-family: var(--font-h);
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .review-branch {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 2px;
        }

        /* ===========================================
           FAQ
        =========================================== */
        .faq-list {
            max-width: 700px;
            margin: 0 auto;
        }

        .faq-item {
            border-bottom: 1px solid var(--border);
        }

        .faq-question {
            padding: 18px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            gap: 16px;
        }

        .faq-question span {
            font-family: var(--font-h);
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }

        .faq-question i {
            color: var(--text-3);
            font-size: 14px;
            transition: transform 0.3s;
            flex-shrink: 0;
        }

        .faq-item.open .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-answer-inner {
            padding: 0 0 18px 0;
            font-size: 14px;
            color: var(--text-2);
            line-height: 1.7;
        }

        /* ===========================================
           CTA BANNER
        =========================================== */
        .cta-banner {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 52px 40px;
            text-align: center;
        }

        .cta-banner h2 {
            font-family: var(--font-h);
            font-size: clamp(24px, 3vw, 34px);
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .cta-banner p {
            font-size: 15px;
            color: var(--text-2);
            max-width: 480px;
            margin: 0 auto 28px;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        /* ===========================================
           FOOTER
        =========================================== */
        .footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 52px 0 24px;
            margin-top: 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 36px;
            margin-bottom: 44px;
        }

        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .footer-brand-logo img {
            height: 36px;
            width: auto;
        }

        .footer-brand-name {
            font-family: var(--font-h);
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        .footer-desc {
            font-size: 13px;
            color: var(--text-3);
            line-height: 1.6;
            max-width: 280px;
            margin-bottom: 18px;
        }

        .footer-social {
            display: flex;
            gap: 8px;
        }

        .social-link {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-3);
            font-size: 15px;
            transition: all 0.2s;
        }

        .social-link:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .footer-col h4 {
            font-family: var(--font-h);
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 14px;
        }

        .footer-col a {
            display: block;
            font-size: 13px;
            color: var(--text-3);
            padding: 3px 0;
            transition: color 0.2s;
        }

        .footer-col a:hover {
            color: var(--text);
        }

        .footer-contact-item {
            display: flex;
            gap: 10px;
            font-size: 13px;
            color: var(--text-3);
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .footer-contact-item i {
            color: var(--blue);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .footer-bottom {
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: var(--text-4);
        }

        /* ===========================================
           FLOATING WHATSAPP
        =========================================== */
        .floating-wa {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--wa);
            color: #FFFFFF;
            padding: 14px 22px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.35);
            transition: all 0.2s;
        }

        .floating-wa:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(37, 211, 102, 0.5);
            color: #FFFFFF;
        }

        .floating-wa i { font-size: 20px; }

        /* ===========================================
           LIGHTBOX
        =========================================== */
        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .lightbox.open { display: flex; }

        .lightbox-inner {
            max-width: 860px;
            max-height: 90vh;
            position: relative;
        }

        .lightbox-inner img {
            width: 100%;
            max-height: 82vh;
            object-fit: contain;
            border-radius: 8px;
        }

        .lightbox-close {
            position: absolute;
            top: -44px;
            right: 0;
            background: none;
            border: none;
            color: #FFFFFF;
            font-size: 28px;
            cursor: pointer;
            padding: 8px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .lightbox-close:hover { opacity: 1; }

        .lightbox-caption {
            text-align: center;
            padding: 10px 0 0;
            font-size: 14px;
            font-weight: 500;
            color: #999;
        }

        /* ===========================================
           RESPONSIVE
        =========================================== */
        @media (max-width: 992px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 36px;
            }
            .hero-photo img { height: 300px; }
            .about-grid {
                grid-template-columns: 1fr;
                gap: 36px;
            }
            .about-photo { order: -1; }
            .about-photo img { height: 320px; }
            .branches-grid,
            .reviews-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .section { padding: 56px 0; }

            .mobile-toggle { display: block; }

            .nav-links {
                position: fixed;
                top: 68px;
                left: 0;
                right: 0;
                background: var(--bg);
                flex-direction: column;
                padding: 20px 24px;
                gap: 14px;
                border-bottom: 1px solid var(--border);
                display: none;
                z-index: 89;
            }
            .nav-links.show { display: flex; }
            .nav-links a { font-size: 16px; }

            .nav-btn-primary { display: none; }

            .hero { padding: 44px 0 36px; }
            .hero-logo img { height: 60px; }
            .hero-stats { gap: 24px; }
            .hero-stat-num { font-size: 22px; }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 4px;
            }

            .branches-grid,
            .reviews-grid { grid-template-columns: 1fr; }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .cta-banner { padding: 36px 20px; }

            .floating-wa span { display: none; }
            .floating-wa {
                padding: 14px;
                border-radius: 50%;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 30px;
                letter-spacing: -0.8px;
            }
            .hero-cta .btn {
                width: 100%;
                justify-content: center;
            }
            .price-name { font-size: 15px; }
            .price-amount { font-size: 16px; }
        }
    </style>
</head>
<body>

    <!-- ==========================================
         NAVBAR
    ========================================== -->
    <header class="navbar">
        <div class="container">
            <div class="nav-inner">
                <a href="<?= base_url(); ?>" class="nav-logo">
                    <img src="<?= $logo_url; ?>" alt="Alvinto Haircut Logo" width="40" height="40">
                    <div>
                        <div class="nav-logo-text">Alvinto Haircut</div>
                        <div class="nav-logo-sub">Est. 2015 &bull; Bogor</div>
                    </div>
                </a>

                <nav class="nav-links" id="navMenu">
                    <a href="#beranda">Beranda</a>
                    <a href="#harga">Harga</a>
                    <a href="#suasana">Suasana</a>
                    <a href="#cabang">Cabang</a>
                    <a href="#faq">FAQ</a>
                </nav>

                <div class="nav-right">
                    <button class="theme-toggle" id="themeToggle" aria-label="Ganti tema gelap/terang">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                    <a href="<?= $wa_link; ?>" target="_blank" rel="noopener noreferrer" class="nav-btn nav-btn-primary">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                    <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- ==========================================
             HERO
        ========================================== -->
        <section class="hero" id="beranda">
            <div class="container">
                <div class="hero-grid">
                    <div class="hero-content">
                        <h1>Ganteng itu<br>butuh <span class="accent">proses.</span></h1>
                        <p class="hero-sub">
                            Barbershop langganan anak Bogor sejak 2015. Tiga cabang, kapster yang ngerti gaya kekinian, harga yang nggak bikin nangis.
                        </p>
                        <div class="hero-cta">
                            <a href="<?= $wa_link; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-blue">
                                <i class="bi bi-whatsapp"></i> Chat Sekarang
                            </a>
                            <a href="#harga" class="btn btn-outline">
                                <i class="bi bi-scissors"></i> Cek Harga
                            </a>
                        </div>
                        <div class="hero-stats">
                            <div>
                                <div class="hero-stat-num">10+</div>
                                <div class="hero-stat-label">Tahun</div>
                            </div>
                            <div>
                                <div class="hero-stat-num">3</div>
                                <div class="hero-stat-label">Cabang</div>
                            </div>
                            <div>
                                <div class="hero-stat-num">Men & Kids</div>
                                <div class="hero-stat-label">Spesialis</div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-photo">
                        <img src="<?= base_url('assets/img/2.webp'); ?>" alt="Suasana barbershop Alvinto Haircut Bogor" width="600" height="420" loading="eager">
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             MARQUEE
        ========================================== -->
        <div class="marquee" aria-hidden="true">
            <div class="marquee-track">
                <?php for ($i = 0; $i < 2; $i++): ?>
                <span class="marquee-text">Specialist Men & Kids</span>
                <span class="marquee-text">Est. 2015</span>
                <span class="marquee-text">3 Cabang di Bogor</span>
                <span class="marquee-text">Ganteng Itu Butuh Proses</span>
                <span class="marquee-text">Walk-in Welcome</span>
                <span class="marquee-text">Buka 10.00 &mdash; 21.00</span>
                <?php endfor; ?>
            </div>
        </div>

        <!-- ==========================================
             HARGA
        ========================================== -->
        <section class="section" id="harga">
            <div class="container">
                <div class="section-header-center reveal">
                    <div class="section-label">Harga</div>
                    <h2>Harga bersahabat,<br>hasil nggak murahan.</h2>
                    <p class="section-desc">
                        Tinggal dateng, pilih gaya, biar kapster yang kerjain. Nggak perlu booking.
                    </p>
                </div>

                <div class="price-list reveal">
                    <?php if (!empty($layanan)): ?>
                        <?php foreach ($layanan as $item): ?>
                            <div class="price-item">
                                <div class="price-info">
                                    <div class="price-name"><?= htmlspecialchars($item->nama); ?></div>
                                    <div class="price-desc"><?= get_service_desc($item->nama, $desc_map); ?></div>
                                </div>
                                <div class="price-amount">Rp <?= number_format($item->harga, 0, ',', '.'); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="price-item">
                            <div class="price-info">
                                <div class="price-name">Pangkas Anak-anak</div>
                                <div class="price-desc">Buat si kecil (0–10 tahun). Ada kursi mobil-mobilan biar anteng & happy pas dicukur.</div>
                            </div>
                            <div class="price-amount">Rp 15.000</div>
                        </div>
                        <div class="price-item">
                            <div class="price-info">
                                <div class="price-name">Pangkas Remaja</div>
                                <div class="price-desc">Buat kamu yang masih sekolah (SMP–SMA). Gaya kekinian, harga kantong pelajar.</div>
                            </div>
                            <div class="price-amount">Rp 17.000</div>
                        </div>
                        <div class="price-item">
                            <div class="price-info">
                                <div class="price-name">Pangkas Tanggung</div>
                                <div class="price-desc">Udah bukan bocil, belum om-om juga. Potongan fresh buat yang lagi tumbuh gede.</div>
                            </div>
                            <div class="price-amount">Rp 20.000</div>
                        </div>
                        <div class="price-item">
                            <div class="price-info">
                                <div class="price-name">Pangkas Dewasa</div>
                                <div class="price-desc">Buat abang 17 tahun ke atas. Konsultasi model, potong rapi, finishing styling.</div>
                            </div>
                            <div class="price-amount">Rp 25.000</div>
                        </div>
                        <div class="price-item">
                            <div class="price-info">
                                <div class="price-name">Cuci Rambut & Styling</div>
                                <div class="price-desc">Keramas seger + pijat kepala ringan + styling pomade.</div>
                            </div>
                            <div class="price-amount">Rp 10.000</div>
                        </div>
                        <div class="price-item">
                            <div class="price-info">
                                <div class="price-name">Cukur Kumis & Jenggot</div>
                                <div class="price-desc">Rapihin kumis & jenggot pakai razor steril + foam lembut.</div>
                            </div>
                            <div class="price-amount">Rp 10.000</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- ==========================================
             SUASANA
        ========================================== -->
        <section class="section" id="suasana" style="padding-bottom: 0;">
            <div class="container">
                <div class="section-header-center reveal">
                    <div class="section-label">Suasana</div>
                    <h2>Bukan cuma potong rambut,<br>tapi nongkrong juga.</h2>
                    <p class="section-desc">Klik foto buat lihat lebih gede.</p>
                </div>
            </div>

            <div class="container">
                <div class="gallery-grid reveal">
                    <?php
                    $galleries = [
                        ['img' => '1.webp', 'title' => 'Tampak depan barbershop'],
                        ['img' => '2.webp', 'title' => 'Interior & kursi barber'],
                        ['img' => '3.webp', 'title' => 'Aksi cukur presisi'],
                        ['img' => '4.webp', 'title' => 'Pelayanan higienis'],
                        ['img' => '5.webp', 'title' => 'Tim kapster Alvinto'],
                        ['img' => '6.webp', 'title' => 'Pangkas segala usia'],
                        ['img' => '7.webp', 'title' => 'Suasana ramai'],
                        ['img' => '8.webp', 'title' => 'Buka sampai malam'],
                        ['img' => '9.webp', 'title' => 'Hasil rapi maksimal'],
                    ];
                    foreach ($galleries as $g):
                    ?>
                        <div class="gallery-item" onclick="openLightbox('<?= base_url('assets/img/' . $g['img']); ?>', '<?= $g['title']; ?>')">
                            <img src="<?= base_url('assets/img/' . $g['img']); ?>" alt="<?= $g['title']; ?> - Alvinto Haircut Bogor" loading="lazy">
                            <div class="gallery-caption">
                                <div class="gallery-caption-title"><?= $g['title']; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ==========================================
             CERITA KITA
        ========================================== -->
        <section class="section" id="tentang">
            <div class="container">
                <div class="about-grid">
                    <div class="about-text reveal">
                        <div class="section-label">Cerita Kita</div>
                        <h2>Dari satu kursi barber,<br>sekarang tiga cabang.</h2>
                        <p>
                            Alvinto Haircut mulai dari tahun 2015 di Mekar Sari, Bogor. Awalnya cuma satu kursi, satu kapster. Sekarang udah tiga cabang dengan tim yang solid dan pelanggan setia dari berbagai usia.
                        </p>
                        <p>
                            Kita spesialis potong rambut pria dan anak. Kapster-kapster kita ngerti model kekinian &mdash; Fade, Undercut, Taper, Mullet, Comma Hair, sampai gaya klasik. Buat anak-anak, ada kursi mobil-mobilan biar nggak rewel.
                        </p>

                        <div class="about-features">
                            <div class="about-feature">
                                <div class="about-feature-icon"><i class="bi bi-person-check-fill"></i></div>
                                <div>
                                    <h4>Kapster yang Ngerti</h4>
                                    <p>Dengerin maunya kamu, kasih saran yang cocok sama bentuk muka.</p>
                                </div>
                            </div>
                            <div class="about-feature">
                                <div class="about-feature-icon"><i class="bi bi-emoji-smile-fill"></i></div>
                                <div>
                                    <h4>Kids Friendly</h4>
                                    <p>Kursi mobil-mobilan buat anak biar anteng dan happy.</p>
                                </div>
                            </div>
                            <div class="about-feature">
                                <div class="about-feature-icon"><i class="bi bi-snow"></i></div>
                                <div>
                                    <h4>Tempat Adem</h4>
                                    <p>Full AC, bersih, dan peralatan selalu disterilkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="about-photo reveal">
                        <img src="<?= base_url('assets/img/5.webp'); ?>" alt="Tim Kapster Alvinto Haircut Bogor" loading="lazy">
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             CABANG
        ========================================== -->
        <section class="section" id="cabang">
            <div class="container">
                <div class="section-header-center reveal">
                    <div class="section-label">Cabang</div>
                    <h2>Tiga lokasi strategis di Bogor.</h2>
                    <p class="section-desc">Pilih cabang terdekat, langsung dateng aja. Nggak perlu booking.</p>
                </div>

                <div class="branches-grid reveal">
                    <div class="branch-card pusat">
                        <div>
                            <div class="branch-badge">Kantor Pusat</div>
                            <h3 class="branch-name">Mekar Sari</h3>
                            <p class="branch-address">Blok Mekar Sari Jl. Ledeng No.26, RT.01/RW.07, Kebon Kelapa, Bogor Tengah, 16125</p>
                            <div class="branch-info">
                                <span><i class="bi bi-clock"></i> Setiap Hari: 10.00 - 21.00</span>
                                <span><i class="bi bi-calendar-event"></i> Jumat: 13.00 - 21.00</span>
                                <span><i class="bi bi-whatsapp"></i> 0856-9148-9851</span>
                            </div>
                        </div>
                        <a href="https://maps.app.goo.gl/7u2TKqKLU15zgUmGA" target="_blank" rel="noopener noreferrer" class="btn-maps">
                            <i class="bi bi-geo-alt"></i> Buka Maps
                        </a>
                    </div>

                    <div class="branch-card">
                        <div>
                            <div class="branch-badge">Cabang</div>
                            <h3 class="branch-name">Gunung Batu</h3>
                            <p class="branch-address">Kawasan Gunung Batu, Kota Bogor, Jawa Barat. Akses mudah & parkir nyaman.</p>
                            <div class="branch-info">
                                <span><i class="bi bi-clock"></i> Setiap Hari: 10.00 - 21.00</span>
                                <span><i class="bi bi-calendar-event"></i> Jumat: 13.00 - 21.00</span>
                                <span><i class="bi bi-check-circle"></i> Full AC & Kapster Handal</span>
                            </div>
                        </div>
                        <a href="https://maps.app.goo.gl/bDwRTvBbMSpia8YEA" target="_blank" rel="noopener noreferrer" class="btn-maps">
                            <i class="bi bi-geo-alt"></i> Buka Maps
                        </a>
                    </div>

                    <div class="branch-card">
                        <div>
                            <div class="branch-badge">Cabang</div>
                            <h3 class="branch-name">Kebon Kelapa</h3>
                            <p class="branch-address">Kawasan Kebon Kelapa, Bogor Tengah, Kota Bogor, Jawa Barat.</p>
                            <div class="branch-info">
                                <span><i class="bi bi-clock"></i> Setiap Hari: 10.00 - 21.00</span>
                                <span><i class="bi bi-calendar-event"></i> Jumat: 13.00 - 21.00</span>
                                <span><i class="bi bi-check-circle"></i> Kursi Anak & Fasilitas Lengkap</span>
                            </div>
                        </div>
                        <a href="https://maps.app.goo.gl/FXwmaaArc85Xwtfe9" target="_blank" rel="noopener noreferrer" class="btn-maps">
                            <i class="bi bi-geo-alt"></i> Buka Maps
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             KATA MEREKA
        ========================================== -->
        <section class="section">
            <div class="container">
                <div class="section-header-center reveal">
                    <div class="section-label">Kata Mereka</div>
                    <h2>Jangan percaya kita,<br>percaya mereka aja.</h2>
                </div>

                <div class="reviews-grid reveal">
                    <div class="review-card">
                        <p class="review-quote">Udah langganan dari jaman bujang sampe sekarang bawa anak potong di sini. Kapsternya ramah banget, anak saya ga pernah nangis karena ada kursi mobilannya. Mantap Alvinto!</p>
                        <div>
                            <div class="review-author">Rian Pratama</div>
                            <div class="review-branch">Cabang Mekar Sari</div>
                        </div>
                    </div>
                    <div class="review-card">
                        <p class="review-quote">Potongan fadernya sangat rapi dan gradasinya halus. Kapsternya ngerti model rambut jaman sekarang. Tempatnya adem ber-AC, harga juga sangat terjangkau di kantong.</p>
                        <div>
                            <div class="review-author">Dimas Nugraha</div>
                            <div class="review-branch">Cabang Gunung Batu</div>
                        </div>
                    </div>
                    <div class="review-card">
                        <p class="review-quote">Pelayanan cepat tapi hasilnya tetap detail dan rapi. Buka sampai jam 9 malam jadi enak pulang kerja bisa mampir dulu. Barbershop rekomendasi banget di Bogor!</p>
                        <div>
                            <div class="review-author">Andi Saputra</div>
                            <div class="review-branch">Cabang Kebon Kelapa</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             FAQ
        ========================================== -->
        <section class="section" id="faq">
            <div class="container">
                <div class="section-header-center reveal">
                    <div class="section-label">FAQ</div>
                    <h2>Sering ditanya.</h2>
                </div>

                <div class="faq-list reveal">
                    <div class="faq-item open">
                        <div class="faq-question">
                            <span>Harus booking dulu atau bisa langsung dateng?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">Langsung dateng aja (walk-in) ke cabang mana pun. Kalau mau tanya antrean atau info cabang, bisa chat WhatsApp kita di 0856-9148-9851.</div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Jam berapa buka dan tutup?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">Buka setiap hari <strong>10.00 - 21.00 WIB</strong>. Khusus <strong>Jumat</strong>, buka setelah Jumatan (13.00 - 21.00 WIB).</div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Bisa potong rambut anak kecil / balita?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">Bisa banget! Kita spesialis Men & Kids. Ada kursi mobil-mobilan khusus biar anak anteng dan seneng pas dicukur. Kapsternya sabar dan telaten.</div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Di mana aja cabang Alvinto di Bogor?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">Ada 3 cabang: <strong>Mekar Sari</strong> (pusat), <strong>Gunung Batu</strong>, dan <strong>Kebon Kelapa</strong>. Scroll ke bagian Cabang buat lihat peta Google Maps masing-masing.</div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Bayarnya bisa pakai apa aja?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">Cash dan non-tunai (QRIS / Transfer Bank). Semua tercatat otomatis lewat sistem kasir Alvinto.</div>
                        </div>
                    </div>
                </div>

                <div class="cta-banner reveal" style="margin-top: 52px;">
                    <h2>Mau ganteng hari ini?</h2>
                    <p>Langsung chat WhatsApp atau dateng ke cabang terdekat. Nggak perlu appointment.</p>
                    <div class="cta-buttons">
                        <a href="<?= $wa_link; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-blue">
                            <i class="bi bi-whatsapp"></i> Chat WhatsApp
                        </a>
                        <a href="#cabang" class="btn btn-outline">
                            <i class="bi bi-geo-alt"></i> Lihat Cabang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ==========================================
         FOOTER (no staff login — internal only)
    ========================================== -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand-logo">
                        <img src="<?= $logo_url; ?>" alt="Alvinto Haircut" width="36" height="36">
                        <span class="footer-brand-name">Alvinto Haircut</span>
                    </div>
                    <p class="footer-desc">
                        Barbershop Specialist Men & Kids di Kota Bogor sejak 2015. &ldquo;...karena ganteng itu butuh proses!&rdquo;
                    </p>
                    <div class="footer-social">
                        <a href="<?= $instagram_url; ?>" target="_blank" rel="noopener noreferrer" class="social-link" title="Instagram" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="<?= $tiktok_url; ?>" target="_blank" rel="noopener noreferrer" class="social-link" title="TikTok" aria-label="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="<?= $wa_link; ?>" target="_blank" rel="noopener noreferrer" class="social-link" title="WhatsApp" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <a href="#beranda">Beranda</a>
                    <a href="#harga">Harga</a>
                    <a href="#suasana">Suasana</a>
                    <a href="#cabang">Cabang</a>
                    <a href="#faq">FAQ</a>
                </div>

                <div class="footer-col">
                    <h4>Cabang</h4>
                    <a href="https://maps.app.goo.gl/7u2TKqKLU15zgUmGA" target="_blank" rel="noopener noreferrer">Mekar Sari (Pusat)</a>
                    <a href="https://maps.app.goo.gl/bDwRTvBbMSpia8YEA" target="_blank" rel="noopener noreferrer">Gunung Batu</a>
                    <a href="https://maps.app.goo.gl/FXwmaaArc85Xwtfe9" target="_blank" rel="noopener noreferrer">Kebon Kelapa</a>
                </div>

                <div class="footer-col">
                    <h4>Kontak</h4>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Blok Mekar Sari Jl. Ledeng No.26, Kebon Kelapa, Bogor Tengah 16125</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-whatsapp"></i>
                        <span>0856-9148-9851</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-clock"></i>
                        <span>Setiap Hari 10.00 - 21.00 (Jumat: 13.00 - 21.00)</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; <?= date('Y'); ?> Alvinto Haircut. Barbershop Specialist Men & Kids Bogor.</span>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp -->
    <a href="<?= $wa_link; ?>" target="_blank" rel="noopener noreferrer" class="floating-wa" title="Chat WhatsApp" aria-label="Chat WhatsApp">
        <i class="bi bi-whatsapp"></i>
        <span>Chat</span>
    </a>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
        <div class="lightbox-inner" onclick="event.stopPropagation()">
            <button class="lightbox-close" onclick="closeLightbox(event)" aria-label="Tutup">&times;</button>
            <img id="lightboxImg" src="" alt="Foto Alvinto Haircut">
            <div class="lightbox-caption" id="lightboxCaption"></div>
        </div>
    </div>

    <!-- ==========================================
         SCRIPTS
    ========================================== -->
    <script>
        // ---- Dark Mode Toggle ----
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('i');

        function applyThemeIcon() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            themeIcon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        }

        themeToggle.addEventListener('click', function() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('alvinto-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('alvinto-theme', 'dark');
            }
            applyThemeIcon();
        });

        applyThemeIcon();

        // ---- Mobile Nav Toggle ----
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');

        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('show');
            var icon = mobileToggle.querySelector('i');
            icon.classList.toggle('bi-list');
            icon.classList.toggle('bi-x-lg');
        });

        navMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                navMenu.classList.remove('show');
                var icon = mobileToggle.querySelector('i');
                icon.classList.add('bi-list');
                icon.classList.remove('bi-x-lg');
            });
        });

        // ---- FAQ Accordion ----
        document.querySelectorAll('.faq-question').forEach(function(q) {
            q.addEventListener('click', function() {
                var item = q.parentElement;
                var answer = item.querySelector('.faq-answer');
                var isOpen = item.classList.contains('open');

                document.querySelectorAll('.faq-item').forEach(function(fi) {
                    fi.classList.remove('open');
                    fi.querySelector('.faq-answer').style.maxHeight = null;
                });

                if (!isOpen) {
                    item.classList.add('open');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                }
            });
        });

        // Set initial FAQ height
        var openFaq = document.querySelector('.faq-item.open .faq-answer');
        if (openFaq) openFaq.style.maxHeight = openFaq.scrollHeight + 'px';

        // ---- Lightbox ----
        var lightbox = document.getElementById('lightbox');
        var lightboxImg = document.getElementById('lightboxImg');
        var lightboxCaption = document.getElementById('lightboxCaption');

        function openLightbox(src, caption) {
            lightboxImg.src = src;
            lightboxCaption.textContent = caption;
            lightbox.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox(e) {
            lightbox.classList.remove('open');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox.classList.contains('open')) closeLightbox();
        });

        // ---- Scroll Reveal ----
        var reveals = document.querySelectorAll('.reveal');
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        reveals.forEach(function(el) { observer.observe(el); });
    </script>

</body>
</html>
