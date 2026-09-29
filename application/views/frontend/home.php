<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$js_products = array();
$prod_source = isset($products) ? $products : (isset($latest_products) ? $latest_products : array());
foreach ($prod_source as $p) {
    $specs = json_decode($p->specs, true) ?: array();
    $brands_arr = array_map('trim', explode(',', $p->brand));
    $js_products[] = array(
        'id' => 'prod-' . $p->id,
        'db_id' => $p->id,
        'title' => $p->product_name,
        'category' => isset($p->category_name) ? $p->category_name : 'General',
        'brand' => $brands_arr,
        'size' => $p->size ?: 'Standard',
        'inStock' => ($p->stock_quantity > 0),
        'stockCount' => (int)$p->stock_quantity,
        'price' => '₹' . number_format($p->price, 0),
        'sku' => $p->sku,
        'image' => base_url('uploads/products/' . ($p->image ?: 'default.png')),
        'specs' => $specs,
        'description' => $p->description
    );
}
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>Log HARDWARE | Sahara Hardware Spare Parts &amp; Supplies</title>
<!-- Google Font: Inter & Plus Jakarta Sans -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
<!-- Tailwind CSS v3 with Forms & Container Queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
            mono: ['monospace'],
          },
          colors: {
            brand: {
              charcoal: '#171717',
              dark: '#111111',
              card: '#FFFFFF',
              surface: '#F8F7F3',
              border: '#E8E7E1',
              green: '#16B364',
              greenBg: '#EAF8F0',
              red: '#EF4444',
              redBg: '#FDF2F2',
              accent: '#EA580C',
            }
          },
          boxShadow: {
            'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
            'elevated': '0 10px 30px -5px rgba(0, 0, 0, 0.08)',
          }
        }
      }
    }
  </script>
<!-- BEGIN: Custom Page Styles -->
<style data-purpose="base-styling">
    body {
      background-color: #F8F7F3;
      color: #171717;
      font-family: 'Plus Jakarta Sans', sans-serif;
      -webkit-font-smoothing: antialiased;
    }
    /* Hide scrollbars gracefully for clean horizontal scroll if needed */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
<style data-purpose="map-and-effects">
    /* Subtle road line styling for the custom interactive vector map */
    .road-network {
      stroke: #E2DFD8;
      stroke-width: 8;
      stroke-linecap: round;
      fill: none;
    }
    .road-primary {
      stroke: #D6D2C4;
      stroke-width: 14;
      stroke-linecap: round;
      fill: none;
    }
    .road-secondary {
      stroke: #EDEAE1;
      stroke-width: 5;
      stroke-linecap: round;
      fill: none;
    }
  </style>
<!-- END: Custom Page Styles -->
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-neutral-800 selection:text-white">
<!-- BEGIN: Top Navigation Bar -->
<header class="sticky top-0 z-40 bg-[#171717] text-white border-b border-neutral-800" data-purpose="top-navigation">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
<!-- Brand Logo -->
<div class="flex items-center space-x-8">
<a class="flex items-center gap-2.5 group" href="<?= site_url("products") ?>">
<!-- Geometric Hardware Icon -->
<div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-neutral-900 font-bold shadow-inner">
<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
<path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm-9 9h7v7H4v-7zm11 2a2 2 0 104 0 2 2 0 00-4 0z"></path>
</svg>
</div>
<div class="leading-tight">
<span class="text-lg font-extrabold tracking-tight text-white uppercase">Log</span>
<span class="text-sm font-semibold tracking-wider text-neutral-300 ml-1">HARDWARE</span>
</div>
</a>
<!-- Desktop Navigation Links -->
<nav aria-label="Primary Navigation" class="hidden md:flex items-center space-x-1 pl-4">
<a class="px-3.5 py-1.5 text-sm font-medium text-white border-b-2 border-white" href="<?= site_url("products") ?>">Home</a>
<a class="px-3.5 py-1.5 text-sm font-medium text-neutral-400 hover:text-white transition-colors" href="#products-section">Products</a>
<a class="px-3.5 py-1.5 text-sm font-medium text-neutral-400 hover:text-white transition-colors" href="#products-section">Brands</a>
<a class="px-3.5 py-1.5 text-sm font-medium text-neutral-400 hover:text-white transition-colors" href="#category-section">Categories</a>
<a class="px-3.5 py-1.5 text-sm font-medium text-neutral-400 hover:text-white transition-colors" href="#store-section">About</a>
</nav>
</div>
<!-- Right Utility Actions -->
<div class="flex items-center space-x-3">
<!-- Quick Search Toggle -->
<button aria-label="Open Quick Search" class="p-2 text-neutral-400 hover:text-white rounded-full hover:bg-neutral-800 transition" id="navSearchTrigger">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
<!-- Location Indicator / Store Badge Pill -->
<div class="flex items-center gap-2 bg-[#252525] hover:bg-neutral-800 transition px-3.5 py-1.5 rounded-full border border-neutral-700/60 cursor-pointer text-xs font-medium text-neutral-200" title="Selected Store: Sahara Hardware Bengaluru">
<span class="w-2.5 h-2.5 rounded-full bg-amber-500 ring-2 ring-amber-500/20"></span>
<span class="">Sahara</span>
<svg class="w-3.5 h-3.5 text-neutral-400 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
</div>
</div>
</header>
<!-- END: Top Navigation Bar -->
<main class="flex-grow">
<!-- BEGIN: Hero Section -->
<section class="relative bg-gradient-to-b from-[#EEECE4] via-[#F5F4EE] to-[#F8F7F3] pt-12 pb-16 overflow-hidden border-b border-neutral-200/80" data-purpose="hero-search-showcase">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
<!-- Left Content: Headline, Text & Search Form -->
<div class="lg:col-span-6 z-10">
<h1 class="text-4xl sm:text-5xl font-extrabold text-[#111111] tracking-tight leading-[1.15]">
              Need a Spare Part?<br>We’ll Help You Find It.
            </h1>
<p class="mt-4 text-base sm:text-lg text-neutral-600 max-w-xl font-normal leading-relaxed">
              Search by category, brand or part name to find the right spare parts, availability and store contact details.
            </p>
<!-- Prominent Search Bar with Auto Suggestions -->
<div class="mt-8 relative max-w-xl">
<form class="relative flex items-center shadow-lg rounded-full bg-white border border-neutral-300 focus-within:border-neutral-900 focus-within:ring-2 focus-within:ring-neutral-900/10 transition-all p-1.5" id="heroSearchForm">
<span class="pl-4 text-neutral-400">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</span>
<input autocomplete="off" class="w-full bg-transparent px-3.5 py-3 text-sm sm:text-base text-neutral-800 placeholder-neutral-400 border-none focus:outline-none focus:ring-0" id="mainSearchInput" placeholder="Ask anything... e.g. AC compressor, LG washing machine filter, Whirlpool door seal" type="text">
<button aria-label="Submit search" class="bg-[#171717] hover:bg-black text-white p-3 rounded-full flex-shrink-0 transition-transform active:scale-95 shadow-md flex items-center justify-center w-11 h-11" type="submit">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
</form>
<!-- Live Suggestion Dropdown Panel -->
<div class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-xl border border-neutral-200 py-2.5 z-30" id="searchSuggestions">
<div class="px-4 py-1 text-xs font-semibold uppercase tracking-wider text-neutral-400">Popular Quick Queries</div>
<div class="divide-y divide-neutral-100">
<button class="suggestion-item w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 flex items-center justify-between" data-search="AC compressor" type="button">
<span class="">AC compressor (1.5 Ton / 2 Ton)</span>
<span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-medium">In Stock</span>
</button>
<button class="suggestion-item w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 flex items-center justify-between" data-search="LG washing machine filter" type="button">
<span class="">LG washing machine drain pump &amp; filter</span>
<span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-medium">In Stock</span>
</button>
<button class="suggestion-item w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 flex items-center justify-between" data-search="AC Remote Control" type="button">
<span class="">Universal AC Remote Control</span>
<span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-medium">In Stock</span>
</button>
<button class="suggestion-item w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 flex items-center justify-between" data-search="AC PCB Board" type="button">
<span class="">Inverter AC PCB Board</span>
<span class="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded font-medium">Not Available</span>
</button>
</div>
</div>
</div>
<!-- Trust highlights -->
<div class="mt-6 flex flex-wrap items-center gap-6 text-xs font-medium text-neutral-500">
<span class="flex items-center gap-1.5">
<svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" fill-rule="evenodd"></path></svg>
                100% Genuine OEM Spares
              </span>
<span class="flex items-center gap-1.5">
<svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" fill-rule="evenodd"></path></svg>
                Live Stock Verification
              </span>
<span class="flex items-center gap-1.5">
<svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" fill-rule="evenodd"></path></svg>
                Instant WhatsApp Confirmation
              </span>
</div>
</div>
<!-- Right Showcase: Composition of Home Appliances & Equipment -->
<div class="lg:col-span-6 relative flex justify-center items-center">
<div class="relative w-full max-w-xl aspect-[16/11] rounded-3xl bg-gradient-to-tr from-neutral-200/90 via-stone-100 to-white/90 p-4 border border-white/70 shadow-xl overflow-hidden flex items-end justify-center">
<!-- Subtle decorative lighting glow -->
<div class="absolute -top-16 -right-16 w-64 h-64 bg-amber-100/60 rounded-full blur-3xl pointer-events-none"></div>
<!-- Appliance & Spares Grouped Collage Representation -->
<div class="relative z-10 w-full h-full flex items-baseline justify-center gap-2 sm:gap-4 pt-4">
<!-- Washing machine & Tool Box -->
<div class="flex flex-col items-center">
<!-- Tool Chest / Spares Box -->
<div class="w-20 sm:w-28 h-14 bg-neutral-800 rounded-lg shadow-md border border-neutral-700 flex flex-col justify-between p-1.5 mb-2 relative">
<div class="h-2 w-10 bg-amber-500 rounded mx-auto"></div>
<div class="flex justify-between items-center px-1">
<span class="w-2.5 h-2.5 rounded-full bg-neutral-600"></span>
<span class="text-[9px] font-bold text-neutral-300 uppercase tracking-widest">PRO TOOLS</span>
<span class="w-2.5 h-2.5 rounded-full bg-neutral-600"></span>
</div>
</div>
<!-- Front Load Washer -->
<div class="w-28 sm:w-36 h-36 sm:h-44 bg-slate-100 rounded-2xl shadow-xl border-2 border-slate-200/90 flex flex-col items-center p-2.5 relative">
<div class="w-full flex justify-between items-center pb-2 border-b border-slate-200">
<div class="w-6 h-1.5 bg-neutral-300 rounded"></div>
<div class="w-3 h-3 rounded-full bg-blue-500/80"></div>
</div>
<!-- Drum Graphic -->
<div class="mt-2 w-20 sm:w-24 h-20 sm:h-24 rounded-full border-4 border-slate-300 bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center shadow-inner">
<div class="w-10 sm:w-12 h-10 sm:h-12 rounded-full border-2 border-sky-300/40 bg-sky-950/70"></div>
</div>
</div>
</div>
<!-- Refrigerator Center Unit -->
<div class="w-24 sm:w-32 h-52 sm:h-64 bg-gradient-to-b from-stone-300 via-stone-200 to-stone-400 rounded-2xl shadow-2xl border-2 border-stone-300 flex flex-col justify-between p-2">
<!-- Top Freezer Door -->
<div class="h-20 bg-stone-100/70 rounded-lg border-b border-stone-300 flex items-end justify-end p-1">
<div class="w-1.5 h-5 bg-neutral-400 rounded"></div>
</div>
<!-- Main Door -->
<div class="h-36 bg-stone-100/70 rounded-lg flex items-start justify-end p-1">
<div class="w-1.5 h-8 bg-neutral-400 rounded"></div>
</div>
</div>
<!-- Split AC Unit & Water Purifier Unit Stack -->
<div class="flex flex-col items-center gap-3">
<!-- Air Conditioner Indoor Wall Unit -->
<div class="w-36 sm:w-48 h-14 bg-white rounded-xl shadow-lg border border-slate-200 p-2 flex flex-col justify-between">
<div class="flex justify-between items-center text-[8px] text-neutral-400 font-bold px-1">
<span class="">INVERTER DUAL COOL</span>
<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
</div>
<div class="w-full h-1 bg-slate-100 rounded"></div>
<div class="w-full flex justify-end">
<span class="text-[10px] font-mono font-semibold text-neutral-700 bg-neutral-100 px-1 rounded">21°C</span>
</div>
</div>
<!-- Water Purifier & Microwave Row -->
<div class="flex gap-2">
<!-- Compact Microwave -->
<div class="w-20 sm:w-24 h-16 bg-neutral-900 rounded-xl shadow-md p-1.5 flex gap-1 border border-neutral-700">
<div class="w-3/4 h-full bg-neutral-800 rounded border border-neutral-700/60"></div>
<div class="w-1/4 h-full flex flex-col justify-between py-1 items-center">
<span class="w-2 h-2 rounded bg-amber-400"></span>
<div class="space-y-0.5">
<div class="w-2.5 h-0.5 bg-neutral-500"></div>
<div class="w-2.5 h-0.5 bg-neutral-500"></div>
</div>
</div>
</div>
<!-- Water Purifier -->
<div class="w-14 sm:w-16 h-20 bg-white rounded-xl shadow-md border border-neutral-200 flex flex-col items-center justify-between p-1.5">
<div class="w-8 h-2 bg-sky-100 rounded-full"></div>
<div class="w-7 h-10 bg-sky-50 rounded-md border border-sky-100 flex items-center justify-center">
<span class="text-[9px] text-sky-500 font-bold">RO</span>
</div>
<div class="w-2 h-2 rounded-full bg-emerald-500"></div>
</div>
</div>
</div>
</div>
<!-- Floating badge overlay -->
<div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full shadow-md border border-neutral-200/80 flex items-center gap-2">
<span class="w-2 h-2 rounded-full bg-emerald-500"></span>
<span class="text-xs font-semibold text-neutral-800">500+ Spares Ready for Dispatch</span>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- END: Hero Section -->
<!-- BEGIN: Shop by Category Section -->
<section class="py-12 bg-[#F8F7F3] border-b border-neutral-200/60" data-purpose="category-slider" id="category-section">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- Category Section Header -->
<div class="flex items-center justify-between mb-8">
<div>
<h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-neutral-900">Shop by Category</h2>
<p class="text-sm text-neutral-500 mt-1">Select an appliance class to filter genuine parts</p>
</div>
<button class="group flex items-center gap-1.5 text-sm font-semibold text-neutral-900 hover:text-black transition" id="viewAllCategoriesBtn">
<span class="">View all categories</span>
<span class="group-hover:translate-x-1 transition-transform">→</span>
</button>
</div>
<!-- Category Grid (6 Main Appliance Categories as in reference) -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5" id="categoryCardsContainer">
<!-- Category 1: General tools -->
<div class="category-card group cursor-pointer bg-white rounded-2xl p-4 sm:p-5 border border-neutral-200/80 hover:border-neutral-900 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-between text-center min-h-[165px]" data-category-name="General tools">
<div class="w-20 h-20 rounded-xl bg-neutral-50 flex items-center justify-center p-2 mb-2 group-hover:scale-105 transition-transform">
<!-- Toolbox Icon / Vector -->
<svg class="w-12 h-12 text-amber-700" fill="currentColor" viewBox="0 0 64 64">
<path d="M12 20h40v6H12z" fill="#92400E"></path>
<path d="M8 26h48v26a4 4 0 01-4 4H12a4 4 0 01-4-4V26z" fill="#B45309"></path>
<rect fill="#78350F" height="8" rx="2" width="20" x="22" y="12"></rect>
<rect fill="#FEF3C7" height="6" rx="1" width="12" x="26" y="28"></rect>
</svg>
</div>
<span class="text-sm font-semibold text-neutral-800 group-hover:text-black">General tools</span>
</div>
<!-- Category 2: Washing machine -->
<div class="category-card group cursor-pointer bg-white rounded-2xl p-4 sm:p-5 border border-neutral-200/80 hover:border-neutral-900 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-between text-center min-h-[165px]" data-category-name="Washing machine">
<div class="w-20 h-20 rounded-xl bg-neutral-50 flex items-center justify-center p-2 mb-2 group-hover:scale-105 transition-transform">
<svg class="w-12 h-12 text-slate-700" fill="currentColor" viewBox="0 0 64 64">
<rect fill="#E2E8F0" height="48" rx="4" width="36" x="14" y="8"></rect>
<circle cx="32" cy="36" fill="#334155" r="14"></circle>
<circle cx="32" cy="36" fill="#64748B" r="8"></circle>
<circle cx="22" cy="14" fill="#475569" r="2"></circle>
<rect fill="#475569" height="3" rx="1" width="8" x="36" y="13"></rect>
</svg>
</div>
<span class="text-sm font-semibold text-neutral-800 group-hover:text-black">Washing machine</span>
</div>
<!-- Category 3: Refrigerator -->
<div class="category-card group cursor-pointer bg-white rounded-2xl p-4 sm:p-5 border border-neutral-200/80 hover:border-neutral-900 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-between text-center min-h-[165px]" data-category-name="Refrigerator">
<div class="w-20 h-20 rounded-xl bg-neutral-50 flex items-center justify-center p-2 mb-2 group-hover:scale-105 transition-transform">
<svg class="w-12 h-12 text-stone-600" fill="currentColor" viewBox="0 0 64 64">
<rect fill="#CBD5E1" height="52" rx="4" width="28" x="18" y="6"></rect>
<rect fill="#94A3B8" height="18" rx="2" width="24" x="20" y="8"></rect>
<rect fill="#94A3B8" height="28" rx="2" width="24" x="20" y="28"></rect>
<rect fill="#334155" height="4" rx="1" width="2" x="22" y="20"></rect>
<rect fill="#334155" height="6" rx="1" width="2" x="22" y="32"></rect>
</svg>
</div>
<span class="text-sm font-semibold text-neutral-800 group-hover:text-black">Refrigerator</span>
</div>
<!-- Category 4: Water purifier -->
<div class="category-card group cursor-pointer bg-white rounded-2xl p-4 sm:p-5 border border-neutral-200/80 hover:border-neutral-900 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-between text-center min-h-[165px]" data-category-name="Water purifier">
<div class="w-20 h-20 rounded-xl bg-neutral-50 flex items-center justify-center p-2 mb-2 group-hover:scale-105 transition-transform">
<svg class="w-12 h-12 text-cyan-600" fill="currentColor" viewBox="0 0 64 64">
<rect fill="#E0F2FE" height="44" rx="5" width="32" x="16" y="10"></rect>
<rect fill="#BAE6FD" height="24" rx="3" width="24" x="20" y="14"></rect>
<circle cx="32" cy="46" fill="#0284C7" r="3"></circle>
<path d="M32 20c-3 4-5 7-5 9a5 5 0 0010 0c0-2-2-5-5-9z" fill="#0369A1"></path>
</svg>
</div>
<span class="text-sm font-semibold text-neutral-800 group-hover:text-black">Water purifier</span>
</div>
<!-- Category 5: Micro oven -->
<div class="category-card group cursor-pointer bg-white rounded-2xl p-4 sm:p-5 border border-neutral-200/80 hover:border-neutral-900 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-between text-center min-h-[165px]" data-category-name="Micro oven">
<div class="w-20 h-20 rounded-xl bg-neutral-50 flex items-center justify-center p-2 mb-2 group-hover:scale-105 transition-transform">
<svg class="w-12 h-12 text-neutral-700" fill="currentColor" viewBox="0 0 64 64">
<rect fill="#1E293B" height="32" rx="3" width="40" x="12" y="16"></rect>
<rect fill="#334155" height="24" rx="2" width="24" x="16" y="20"></rect>
<circle cx="46" cy="24" fill="#F59E0B" r="2"></circle>
<circle cx="46" cy="32" fill="#94A3B8" r="2"></circle>
<circle cx="46" cy="40" fill="#94A3B8" r="2"></circle>
</svg>
</div>
<span class="text-sm font-semibold text-neutral-800 group-hover:text-black">Micro oven</span>
</div>
<!-- Category 6: AC (Active in reference) -->
<div class="category-card group cursor-pointer bg-white rounded-2xl p-4 sm:p-5 border-2 border-neutral-900 ring-2 ring-neutral-900/10 shadow-md transition-all flex flex-col items-center justify-between text-center min-h-[165px]" data-category-name="AC">
<div class="w-20 h-20 rounded-xl bg-neutral-50 flex items-center justify-center p-2 mb-2 group-hover:scale-105 transition-transform">
<svg class="w-12 h-12 text-slate-800" fill="currentColor" viewBox="0 0 64 64">
<rect fill="#F1F5F9" height="20" rx="3" width="48" x="8" y="22"></rect>
<rect fill="#CBD5E1" height="4" width="48" x="8" y="38"></rect>
<circle cx="48" cy="28" fill="#10B981" r="1.5"></circle>
<rect fill="#94A3B8" height="2" width="16" x="12" y="26"></rect>
</svg>
</div>
<div class="flex items-center gap-1.5">
<span class="text-sm font-bold text-neutral-900">AC</span>
<span class="w-1.5 h-1.5 rounded-full bg-neutral-900"></span>
</div>
</div>
</div>
</div>
</section>
<!-- END: Shop by Category Section -->
<!-- BEGIN: Cascading Dynamic Filters Bar -->
<section class="sticky top-16 z-30 bg-[#F8F7F3]/95 backdrop-blur-md py-4 border-b border-neutral-200/80" data-purpose="cascading-filter-bar">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
<!-- Dropdowns Container -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-2.5 flex-grow">
<!-- Category Filter Dropdown -->
<div class="relative bg-white rounded-xl border border-neutral-200 shadow-sm px-3 py-2 flex items-center justify-between focus-within:ring-2 focus-within:ring-neutral-900">
<div class="flex items-center gap-2 overflow-hidden">
<svg class="w-4 h-4 text-neutral-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<div class="leading-tight truncate">
<div class="text-[10px] uppercase font-semibold text-neutral-400">Category</div>
<select class="bg-transparent p-0 text-xs sm:text-sm font-semibold text-neutral-800 border-none focus:ring-0 cursor-pointer w-full leading-tight" id="filterCategory">
<option selected="" value="AC">AC</option>
<option value="All">All Categories</option>
<option value="General tools">General tools</option>
<option value="Washing machine">Washing machine</option>
<option value="Refrigerator">Refrigerator</option>
<option value="Water purifier">Water purifier</option>
<option value="Micro oven">Micro oven</option>
</select>
</div>
</div>
</div>
<!-- Brand Filter Dropdown -->
<div class="relative bg-white rounded-xl border border-neutral-200 shadow-sm px-3 py-2 flex items-center justify-between focus-within:ring-2 focus-within:ring-neutral-900">
<div class="flex items-center gap-2 overflow-hidden">
<svg class="w-4 h-4 text-neutral-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<div class="leading-tight truncate">
<div class="text-[10px] uppercase font-semibold text-neutral-400">Brand</div>
<select class="bg-transparent p-0 text-xs sm:text-sm font-semibold text-neutral-800 border-none focus:ring-0 cursor-pointer w-full leading-tight" id="filterBrand">
<option selected="" value="All">All Brands</option>
<option value="LG">LG</option>
<option value="Samsung">Samsung</option>
<option value="Daikin">Daikin</option>
<option value="Voltas">Voltas</option>
<option value="Hitachi">Hitachi</option>
<option value="Whirlpool">Whirlpool</option>
<option value="Bosch">Bosch</option>
<option value="Kent">Kent</option>
</select>
</div>
</div>
</div>
<!-- Availability Filter Dropdown -->
<div class="relative bg-white rounded-xl border border-neutral-200 shadow-sm px-3 py-2 flex items-center justify-between focus-within:ring-2 focus-within:ring-neutral-900">
<div class="flex items-center gap-2 overflow-hidden">
<span class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
<div class="leading-tight truncate">
<div class="text-[10px] uppercase font-semibold text-neutral-400">Availability</div>
<select class="bg-transparent p-0 text-xs sm:text-sm font-semibold text-neutral-800 border-none focus:ring-0 cursor-pointer w-full leading-tight" id="filterAvailability">
<option selected="" value="In Stock">In Stock</option>
<option value="All">All Statuses</option>
<option value="Not Available">Not Available</option>
</select>
</div>
</div>
</div>
<!-- Size / Model Filter Dropdown -->
<div class="relative bg-white rounded-xl border border-neutral-200 shadow-sm px-3 py-2 flex items-center justify-between focus-within:ring-2 focus-within:ring-neutral-900">
<div class="flex items-center gap-2 overflow-hidden">
<svg class="w-4 h-4 text-neutral-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<div class="leading-tight truncate">
<div class="text-[10px] uppercase font-semibold text-neutral-400">Size / Model</div>
<select class="bg-transparent p-0 text-xs sm:text-sm font-semibold text-neutral-800 border-none focus:ring-0 cursor-pointer w-full leading-tight" id="filterSize">
<option selected="" value="All">All</option>
<option value="Standard">Standard</option>
<option value="1.5 Ton / 2 Ton">1.5 Ton / 2 Ton</option>
<option value="Universal">Universal</option>
<option value="Heavy Duty">Heavy Duty</option>
</select>
</div>
</div>
</div>
</div>
<!-- More Filters Trigger Button -->
<div class="flex items-center gap-2 flex-shrink-0">
<button class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-[#171717] hover:bg-black text-white px-5 py-2.5 rounded-xl font-medium text-sm shadow-sm transition active:scale-95" id="openMoreFiltersBtn">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span class="">More Filters</span>
</button>
</div>
</div>
<!-- Filter Chips & Results Count Bar -->
<div class="mt-3 flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-neutral-200/50">
<div class="flex items-center flex-wrap gap-2 text-xs" id="activeFilterChips">
<span class="text-neutral-500 font-medium">Applied:</span>
<span class="chip inline-flex items-center gap-1 bg-white px-2.5 py-1 rounded-full border border-neutral-300 font-semibold text-neutral-800">
              Category: <span id="chipCategoryLabel" class="">AC</span>
<button class="remove-chip ml-1 text-neutral-400 hover:text-neutral-900" data-filter="category">✕</button>
</span>
<span class="chip inline-flex items-center gap-1 bg-white px-2.5 py-1 rounded-full border border-neutral-300 font-semibold text-neutral-800">
              Availability: <span id="chipAvailLabel" class="">In Stock</span>
<button class="remove-chip ml-1 text-neutral-400 hover:text-neutral-900" data-filter="availability">✕</button>
</span>
<button class="text-neutral-500 hover:text-neutral-900 underline ml-1 text-xs" id="clearAllFiltersBtn">Clear all</button>
</div>
<!-- Sort by -->
<div class="flex items-center gap-2 text-xs text-neutral-500 ml-auto">
<span class="">Sort by</span>
<select class="bg-white border border-neutral-200 rounded-lg text-xs py-1 px-2.5 font-medium text-neutral-800 focus:ring-0" id="sortBySelect">
<option value="relevance">Relevance</option>
<option value="name-asc">Name A-Z</option>
<option value="brand">Brand</option>
</select>
</div>
</div>
</div>
</section>
<!-- END: Cascading Dynamic Filters Bar -->
<!-- BEGIN: Products Catalog Grid -->
<section class="py-10" data-purpose="product-catalog-grid" id="products-section">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- Catalog Heading and Total Count Indicator -->
<div class="flex items-baseline justify-between mb-6">
<div class="flex items-baseline gap-3">
<h2 class="text-2xl font-bold tracking-tight text-neutral-900" id="catalogTitle">AC Spare Parts</h2>
<span class="text-sm font-medium text-neutral-500" id="productCounter">Showing 12 of 380+ products</span>
</div>
</div>
<!-- Products Responsive Card Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="productGrid"><div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 100 100"><rect fill="#FAF9F6" height="70" rx="3" stroke-width="3" width="70" x="15" y="15"></rect><path d="M15 35h70M15 55h70M15 75h70M35 15v70M55 15v70M75 15v70" stroke="#A8A29E" stroke-dasharray="2 2" stroke-width="1.5"></path></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹350</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">AC Air Filter</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for LG, Samsung, Daikin, Voltas</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">Standard</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about AC Air Filter" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20AC%20Air%20Filter%20(Standard)" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-neutral-700" fill="none" viewBox="0 0 100 100"><rect fill="#1C1917" height="56" rx="8" width="30" x="35" y="24"></rect><rect fill="#292524" height="12" rx="3" width="16" x="42" y="14"></rect><circle cx="50" cy="18" fill="#EAB308" r="3"></circle><rect fill="#44403C" height="24" rx="3" width="8" x="28" y="44"></rect><path d="M35 50h-4M35 60h-4" stroke="#78716C" stroke-width="2"></path></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹7,850</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">AC Compressor</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for LG, Daikin, Voltas, Hitachi</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">1.5 Ton / 2 Ton</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about AC Compressor" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20AC%20Compressor%20(1.5%20Ton%20/%202%20Ton)" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-20 h-28 text-neutral-300" fill="none" viewBox="0 0 60 100"><rect fill="#F8FAFC" height="84" rx="8" stroke="#CBD5E1" stroke-width="2" width="40" x="10" y="8"></rect><rect fill="#E2E8F0" height="22" rx="2" width="24" x="18" y="16"></rect><circle cx="24" cy="50" fill="#EF4444" r="3.5"></circle><circle cx="36" cy="50" fill="#3B82F6" r="3.5"></circle><circle cx="24" cy="62" fill="#94A3B8" r="3"></circle><circle cx="36" cy="62" fill="#94A3B8" r="3"></circle><circle cx="24" cy="74" fill="#94A3B8" r="3"></circle><circle cx="36" cy="74" fill="#94A3B8" r="3"></circle></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹450</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">AC Remote Control</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for All Brands, Universal</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">Universal</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about AC Remote Control" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20AC%20Remote%20Control%20(Universal)" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24" fill="none" viewBox="0 0 100 100"><rect fill="#047857" height="70" rx="4" width="70" x="15" y="15"></rect><rect fill="#1E293B" height="16" width="16" x="25" y="25"></rect><circle cx="65" cy="35" fill="#F59E0B" r="7"></circle><path d="M45 25h12M45 35h12M25 55h40M30 65h35" stroke="#A7F3D0" stroke-linecap="round" stroke-width="2"></path><rect fill="#334155" height="18" rx="2" width="18" x="55" y="55"></rect></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹1,950</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">AC PCB Board</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for LG, Samsung, Daikin, Voltas</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">1.5 Ton / 2 Ton</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about AC PCB Board" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20AC%20PCB%20Board" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-amber-700" fill="none" stroke="#B45309" stroke-width="4" viewBox="0 0 100 100"><circle cx="50" cy="50" r="32"></circle><circle cx="50" cy="50" r="20"></circle><path d="M50 18v12M50 70v12M18 50h12M70 50h12" stroke="#92400E" stroke-linecap="round" stroke-width="3"></path></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹1,200</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">AC Copper Pipe Kit</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for Daikin, Hitachi, Voltas, LG</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">10 Feet / Standard</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about AC Copper Pipe Kit" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20AC%20Copper%20Pipe%20Kit" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-20 h-24 text-neutral-400" fill="none" viewBox="0 0 60 80"><rect fill="#94A3B8" height="55" rx="16" width="32" x="14" y="18"></rect><rect fill="#475569" height="8" rx="2" width="6" x="20" y="10"></rect><rect fill="#475569" height="8" rx="2" width="6" x="34" y="10"></rect><rect fill="#E2E8F0" height="16" rx="2" width="24" x="18" y="34"></rect></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹280</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">Dual Run Capacitor</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for All Split &amp; Window ACs</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">50+5 MFD 440V</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about Dual Run Capacitor" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20Dual%20Run%20Capacitor" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" fill="#334155" r="26"></circle><rect fill="#64748B" height="36" rx="2" width="12" x="44" y="10"></rect><circle cx="50" cy="50" fill="#CBD5E1" r="10"></circle><path d="M30 40l-12-8M70 40l12-8M30 60l-12 8M70 60l12 8" stroke="#94A3B8" stroke-linecap="round" stroke-width="2.5"></path></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹1,450</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">Indoor Blower Fan Motor</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for LG, Daikin, Samsung</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">25W / 240V Multi-Speed</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about Indoor Blower Fan Motor" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20Indoor%20Blower%20Fan%20Motor" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-sky-600" fill="none" viewBox="0 0 100 100"><rect fill="#0284C7" height="44" rx="4" width="68" x="16" y="28"></rect><path d="M22 36h56M22 44h56M22 52h56M22 60h56" stroke="#BAE6FD" stroke-dasharray="2 2" stroke-width="2"></path><circle cx="22" cy="36" fill="#E0F2FE" r="2"></circle><circle cx="78" cy="36" fill="#E0F2FE" r="2"></circle></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹3,400</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">Cooling Coil Evaporator</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for Voltas, Blue Star, Carrier</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">1.5 Ton Pure Copper</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about Cooling Coil Evaporator" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20Cooling%20Coil%20Evaporator" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-amber-500" fill="none" viewBox="0 0 100 100"><polygon fill="#F59E0B" points="50,18 78,34 78,66 50,82 22,66 22,34"></polygon><circle cx="50" cy="50" fill="#78350F" r="14"></circle></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹180</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">Flare Brass Nut Set</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for All AC Copper Piping</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">1/4" + 1/2" Pair</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about Flare Brass Nut Set" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20Flare%20Brass%20Nut%20Set" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-neutral-700" fill="none" viewBox="0 0 100 100"><circle cx="50" cy="50" fill="#1E293B" r="10"></circle><path d="M50 40C45 25 35 15 50 10C65 15 55 25 50 40Z" fill="#475569"></path><path d="M60 50C75 45 85 35 90 50C85 65 75 55 60 50Z" fill="#475569"></path><path d="M50 60C55 75 65 85 50 90C35 85 45 75 50 60Z" fill="#475569"></path><path d="M40 50C25 55 15 65 10 50C15 35 25 45 40 50Z" fill="#475569"></path></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹390</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">Condenser Fan Blade</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for Outdoor Units LG, Daikin, Lloyd</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">16-inch 3-Wing</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about Condenser Fan Blade" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20Condenser%20Fan%20Blade" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-slate-400" fill="none" stroke="#64748B" stroke-dasharray="4 4" stroke-width="5" viewBox="0 0 100 100"><path d="M15 30c20-20 40 40 70 0"></path><path d="M15 50c20-20 40 40 70 0"></path><path d="M15 70c20-20 40 40 70 0"></path></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹150</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">AC Drain Hose 3m</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for All Split AC indoor units</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">3 Meters Corrugated</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about AC Drain Hose 3m" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20AC%20Drain%20Hose%203m" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div>
<div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between">
  <div>
    <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
      <svg class="w-24 h-24 text-amber-600" fill="none" viewBox="0 0 100 100"><rect fill="#D97706" height="36" rx="4" width="12" x="44" y="46"></rect><circle cx="50" cy="36" fill="#B45309" r="10"></circle><path d="M50 14v12" stroke="#475569" stroke-linecap="round" stroke-width="3"></path><rect fill="#334155" height="8" rx="2" width="16" x="42" y="82"></rect></svg>
      <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-700 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded border border-neutral-200">₹320</span>
    </div>
    <div class="mt-4">
      <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">Universal Inverter Sensor Kit</h3>
      <p class="text-xs text-neutral-500 mt-1 line-clamp-1">Suitable for LG, Daikin, Hitachi, Voltas</p>
      <div class="mt-2 text-xs text-neutral-700"><span class="font-medium text-neutral-400">Size:</span> <span class="font-semibold text-neutral-800">10K &amp; 15K NTC Probe</span></div>
    </div>
  </div>
  <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
    <div><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]"><span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>In Stock</span></div>
    <div class="flex items-center gap-2">
      <a aria-label="Enquire on WhatsApp about Universal Inverter Sensor Kit" class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20interested%20in%20Universal%20Inverter%20Sensor%20Kit" rel="noreferrer" target="_blank"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg></a>
      <button class="w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200" type="button"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
    </div>
  </div>
</div></div>
<!-- Empty State UI -->
<div class="mt-12 text-center flex flex-col items-center justify-center"><button class="group inline-flex items-center gap-3 bg-[#171717] hover:bg-black text-white px-8 py-3.5 rounded-full font-semibold text-sm shadow-md hover:shadow-lg transition-all active:scale-95" id="viewAllProductsBtn" onclick="document.getElementById('filterCategory').value='All'; document.getElementById('filterCategory').dispatchEvent(new Event('change')); window.scrollTo({top: document.getElementById('products-section').offsetTop - 80, behavior: 'smooth'});" type="button"><span class="">View All 380+ Products</span><svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button><p class="mt-2.5 text-xs text-neutral-500 font-normal">Explore full catalogue across all brands &amp; categories</p></div><div class="hidden py-16 text-center bg-white rounded-3xl border border-neutral-200/80 p-8 shadow-sm" id="emptyCatalogState">
<div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto text-neutral-400 mb-4">
<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<h3 class="text-lg font-bold text-neutral-800">No matching spare parts found</h3>
<p class="text-sm text-neutral-500 mt-1 max-w-md mx-auto">Try resetting some filters or searching for generic terms like "compressor", "remote" or "filter".</p>
<button class="mt-4 bg-[#171717] text-white px-5 py-2 rounded-xl text-sm font-medium" id="resetFromEmptyBtn">Reset All Filters</button>
</div>
</div>
</section>
<!-- END: Products Catalog Grid -->
<!-- BEGIN: Sahara Hardware Store Location & Details Section -->
<section class="py-12 bg-white border-t border-neutral-200" data-purpose="store-location-and-contact" id="store-section">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- Integrated Location Card matching the reference layout -->
<div class="bg-[#171717] text-white rounded-3xl overflow-hidden shadow-2xl border border-neutral-800">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
<!-- Left Area: Clean Interactive Vector Map Representation -->
<div class="lg:col-span-5 relative bg-[#EBE8DF] min-h-[280px] lg:min-h-full p-4 overflow-hidden flex items-center justify-center">
<!-- SVG Architectural City Map Pattern -->
<svg class="absolute inset-0 w-full h-full object-cover" preserveAspectRatio="none" viewBox="0 0 500 350">
<!-- Background city blocks -->
<rect fill="#E8E5DD" height="350" width="500" x="0" y="0"></rect>
<rect fill="#E0DDD4" height="90" rx="4" width="130" x="20" y="20"></rect>
<rect fill="#E0DDD4" height="60" rx="4" width="140" x="180" y="20"></rect>
<rect fill="#E0DDD4" height="110" rx="4" width="130" x="350" y="20"></rect>
<rect fill="#E0DDD4" height="150" rx="4" width="110" x="30" y="160"></rect>
<rect fill="#E0DDD4" height="130" rx="4" width="170" x="310" y="180"></rect>
<!-- Road network paths -->
<path class="road-primary" d="M-10,130 Q180,140 260,190 T510,230"></path>
<path class="road-primary" d="M120,-10 L250,360"></path>
<path class="road-secondary" d="M-20,70 L520,110"></path>
<path class="road-secondary" d="M370,-10 L320,360"></path>
<!-- Road Labels -->
<text fill="#88847B" font-size="11" font-weight="700" transform="rotate(3 75 125)" x="75" y="125">MG Road</text>
<text fill="#88847B" font-size="11" font-weight="700" x="60" y="275">Central Street</text>
<text fill="#D97706" font-size="10" font-weight="700" x="180" y="115">MG Mall</text>
</svg>
<!-- Bus Stand Landmark Pin -->
<div class="absolute top-16 right-16 flex items-center gap-1.5 bg-neutral-800/80 backdrop-blur-sm text-white px-2.5 py-1 rounded-full text-[11px] font-semibold shadow-md">
<svg class="w-3.5 h-3.5 text-neutral-300" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2v4h8V6H6zm1 6a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2z"></path></svg>
<span class="">Bus Stand</span>
</div>
<!-- Main Sahara Hardware Marker Pin -->
<div class="relative z-10 flex items-center gap-2 bg-white text-neutral-900 px-3.5 py-2 rounded-full shadow-2xl border border-neutral-300 transform -translate-y-2">
<div class="w-6 h-6 rounded-full bg-rose-600 flex items-center justify-center text-white flex-shrink-0 animate-bounce">
<svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
<path clip-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" fill-rule="evenodd"></path>
</svg>
</div>
<div class="leading-tight">
<div class="font-bold text-xs sm:text-sm text-neutral-900">Sahara Hardware</div>
<div class="text-[10px] text-neutral-500">Main Retail Counter</div>
</div>
</div>
<!-- Direction Action CTA Floating -->
<a class="absolute bottom-3 left-3 bg-white/90 hover:bg-white text-neutral-800 text-[11px] font-semibold px-2.5 py-1 rounded shadow-sm border border-neutral-300 flex items-center gap-1 transition" href="https://maps.google.com" rel="noreferrer" target="_blank">
<span class="">Open in Google Maps</span>
<span class="">↗</span>
</a>
</div>
<!-- Center Area: Store Info & Direct Contact Details -->
<div class="lg:col-span-4 p-6 sm:p-8 flex flex-col justify-between border-t lg:border-t-0 lg:border-r border-neutral-800">
<div>
<h3 class="text-2xl font-bold tracking-tight text-white mb-5 flex items-center gap-2">
<span class="">Sahara Hardware</span>
<span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-900/60 text-emerald-400 border border-emerald-700/60">Verified Outlet</span>
</h3>
<!-- Info Stack with Icons -->
<ul class="space-y-4 text-sm text-neutral-300">
<!-- Address -->
<li class="flex items-start gap-3">
<svg class="w-5 h-5 text-neutral-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
<path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span class="">123, MG Road, Near City Mall, Bengaluru – 560001</span>
</li>
<!-- Phone Contact -->
<li class="flex items-center gap-3">
<svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<a class="hover:text-white font-medium transition-colors" href="tel:+919876543210">+91 98765 43210</a>
</li>
<!-- Email Address -->
<li class="flex items-center gap-3">
<svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<a class="hover:text-white font-medium transition-colors" href="mailto:sahara.hardware@gmail.com">sahara.hardware@gmail.com</a>
</li>
<!-- Business Hours -->
<li class="flex items-center gap-3">
<svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span class="">Mon – Sat: 9:00 AM – 8:00 PM</span>
</li>
<!-- Retail Store Type Tag -->
<li class="flex items-center gap-3">
<svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span class="">Hardware &amp; Appliance Spare Parts</span>
</li>
</ul>
</div>
<!-- Quick Communication Action Buttons -->
<div class="mt-6 pt-4 border-t border-neutral-800 flex items-center gap-3">
<a class="flex-1 inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-white py-2.5 px-3 rounded-xl text-xs sm:text-sm font-bold shadow-md transition" href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware,%20I%20am%20looking%20for%20a%20spare%20part." target="_blank">
<!-- WhatsApp Icon -->
<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"></path></svg>
<span class="">Chat on WhatsApp</span>
</a>
<a class="inline-flex items-center justify-center gap-2 bg-neutral-800 hover:bg-neutral-700 text-white py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold border border-neutral-700 transition" href="tel:+919876543210">
<span class="">Call Store</span>
</a>
</div>
</div>
<!-- Right Area: Storefront Facade Visual -->
<div class="lg:col-span-3 relative min-h-[220px] lg:min-h-full bg-neutral-900 overflow-hidden flex flex-col justify-end p-5">
<!-- Architectural storefront illustration & photography card -->
<div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-neutral-900/60 z-10"></div>
<!-- Storefront graphic background -->
<div class="absolute inset-0 flex items-center justify-center opacity-40">
<div class="w-full h-full bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
</div>
<!-- Store front window banner design -->
<div class="relative z-20">
<div class="inline-block bg-amber-500/20 backdrop-blur-md border border-amber-500/40 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded mb-2 uppercase tracking-widest">Storefront</div>
<h4 class="text-xl font-extrabold text-white">Sahara Hardware</h4>
<p class="text-xs text-neutral-400 mt-1">Walk-in counter for technicians &amp; retail customers. Free consultation &amp; part inspection available.</p>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- END: Sahara Hardware Store Location & Details Section -->
</main>
<!-- BEGIN: Global Footer -->
<footer class="bg-[#151515] text-white pt-16 pb-12 border-t border-neutral-800" data-purpose="global-footer">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- Multi-column links -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 pb-12 border-b border-neutral-800/80 text-sm">
<!-- Col 1: Products -->
<div>
<div class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-4">Product</div>
<ul class="space-y-2.5 text-neutral-400">
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">General tools</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Washing machine</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Refrigerator</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Water purifier</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Micro oven</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">AC</a></li>
</ul>
</div>
<!-- Col 2: Brands -->
<div>
<div class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-4">Brands</div>
<ul class="space-y-2.5 text-neutral-400">
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">LG</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Samsung</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Daikin</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Voltas</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Whirlpool</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Hitachi</a></li>
</ul>
</div>
<!-- Col 3: Company -->
<div>
<div class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-4">Company</div>
<ul class="space-y-2.5 text-neutral-400">
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">About Us</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Contact</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Blog</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Careers</a></li>
</ul>
</div>
<!-- Col 4: Support -->
<div>
<div class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-4">Support</div>
<ul class="space-y-2.5 text-neutral-400">
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Help Center</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Return Policy</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Shipping</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">FAQ</a></li>
</ul>
</div>
<!-- Col 5: Legal -->
<div>
<div class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-4">Legal</div>
<ul class="space-y-2.5 text-neutral-400">
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Privacy Policy</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Terms of Service</a></li>
<li class=""><a class="hover:text-white transition" href="<?= site_url("products") ?>">Cookie Policy</a></li>
</ul>
</div>
<!-- Col 6: Social & Community -->
<div class="col-span-2 md:col-span-1">
<div class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-4">Follow Us</div>
<div class="flex items-center space-x-3">
<!-- Facebook -->
<a aria-label="Facebook" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-blue-600 transition flex items-center justify-center text-white" href="<?= site_url("products") ?>">
<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path></svg>
</a>
<!-- Instagram -->
<a aria-label="Instagram" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-pink-600 transition flex items-center justify-center text-white" href="<?= site_url("products") ?>">
<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
</a>
<!-- YouTube -->
<a aria-label="YouTube" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-red-600 transition flex items-center justify-center text-white" href="<?= site_url("products") ?>">
<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"></path></svg>
</a>
<!-- LinkedIn -->
<a aria-label="LinkedIn" class="w-9 h-9 rounded-full bg-neutral-800 hover:bg-blue-700 transition flex items-center justify-center text-white" href="<?= site_url("products") ?>">
<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"></path></svg>
</a>
</div>
</div>
</div>
<!-- Copyright info -->
<div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-neutral-500">
<p class="">© 2026 Log HARDWARE. All rights reserved.</p>
<p class="mt-2 sm:mt-0">Designed for retail customers &amp; professional HVAC / Appliance technicians.</p>
</div>
</div>
</footer>
<!-- END: Global Footer -->
<!-- BEGIN: Interactive Product Detail Modal -->
<div aria-labelledby="modal-title" aria-modal="true" class="fixed inset-0 z-50 overflow-y-auto hidden" id="productDetailModal" role="dialog">
<!-- Backdrop overlay -->
<div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="closeDetailBackdrop"></div>
<div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
<div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-neutral-200">
<!-- Modal Close Button -->
<button class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-200 flex items-center justify-center text-neutral-600 transition" id="closeDetailModalBtn">
          ✕
        </button>
<div class="p-6 sm:p-8" id="modalDetailContent">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
          <div class="aspect-square bg-neutral-50 rounded-2xl flex items-center justify-center p-6 border border-neutral-200">
            <svg class="w-24 h-24 text-neutral-300" viewBox="0 0 100 100" fill="none" stroke="currentColor">
          <rect x="15" y="15" width="70" height="70" rx="3" stroke-width="3" fill="#FAF9F6"></rect>
          <path d="M15 35h70M15 55h70M15 75h70M35 15v70M55 15v70M75 15v70" stroke-width="1.5" stroke-dasharray="2 2" stroke="#A8A29E"></path>
        </svg>
          </div>
          <div>
            <div class="flex items-center gap-2">
              <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">AC</span>
              <span class="text-xs text-neutral-300">•</span>
              <span class="text-xs font-mono font-semibold text-neutral-500">AC-FILT-STD-01</span>
            </div>
            
            <h2 class="text-2xl font-bold text-neutral-900 mt-1">AC Air Filter</h2>
            <div class="text-2xl font-extrabold text-neutral-900 mt-2">₹350</div>

            <div class="mt-3">
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]">
                    <span class="w-2 h-2 rounded-full bg-[#16B364]"></span>
                    In Stock at Sahara Hardware (18 units available)
                  </span>
            </div>

            <!-- Specs Matrix -->
            <div class="mt-6 border-t border-neutral-200 pt-4 space-y-2 text-xs">
              <div class="flex justify-between py-1 border-b border-neutral-100">
                <span class="text-neutral-500">Supported Brands:</span>
                <span class="font-semibold text-neutral-800">LG, Samsung, Daikin, Voltas</span>
              </div>
              <div class="flex justify-between py-1 border-b border-neutral-100">
                <span class="text-neutral-500">Size / Tonnage:</span>
                <span class="font-semibold text-neutral-800">Standard</span>
              </div>
              
                <div class="flex justify-between py-1 border-b border-neutral-100">
                  <span class="text-neutral-500 capitalize">material:</span>
                  <span class="font-semibold text-neutral-800">HD Polypropylene Mesh</span>
                </div>
              
                <div class="flex justify-between py-1 border-b border-neutral-100">
                  <span class="text-neutral-500 capitalize">washable:</span>
                  <span class="font-semibold text-neutral-800">Yes</span>
                </div>
              
                <div class="flex justify-between py-1 border-b border-neutral-100">
                  <span class="text-neutral-500 capitalize">dimensions:</span>
                  <span class="font-semibold text-neutral-800">305mm x 310mm</span>
                </div>
              
                <div class="flex justify-between py-1 border-b border-neutral-100">
                  <span class="text-neutral-500 capitalize">warranty:</span>
                  <span class="font-semibold text-neutral-800">6 Months</span>
                </div>
              
            </div>

            <!-- Call to Actions -->
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
              <a href="https://wa.me/919876543210?text=Hi%20Sahara%20Hardware%2C%20I%20am%20looking%20to%20purchase%2Fverify%20stock%20for%3A%20AC%20Air%20Filter%20(AC-FILT-STD-01).%20Please%20let%20me%20know%20pickup%20or%20delivery%20details." target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-white py-3 px-4 rounded-xl text-sm font-bold shadow-md transition">
                <span class="">Direct WhatsApp Order</span>
              </a>
              <a href="tel:+919876543210" class="inline-flex items-center justify-center gap-2 bg-neutral-900 hover:bg-black text-white py-3 px-4 rounded-xl text-sm font-bold transition">
                <span class="">Call Store</span>
              </a>
            </div>

          </div>
        </div>
      </div>
</div>
</div>
</div>
<!-- END: Interactive Product Detail Modal -->
<!-- BEGIN: "More Filters" Slide-Over Panel -->
<div aria-labelledby="slide-over-title" aria-modal="true" class="fixed inset-0 z-50 hidden overflow-hidden" id="moreFiltersPanel" role="dialog">
<div class="absolute inset-0 bg-black/40 backdrop-blur-xs transition-opacity" id="closeFilterBackdrop"></div>
<div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
<div class="pointer-events-auto w-screen max-w-md bg-white shadow-2xl flex flex-col justify-between">
<div class="p-6 overflow-y-auto">
<div class="flex items-center justify-between pb-4 border-b border-neutral-200">
<h3 class="text-lg font-bold text-neutral-900" id="slide-over-title">Detailed Spares Filter</h3>
<button class="text-neutral-400 hover:text-neutral-700 p-1" id="closeMoreFiltersBtn">
              ✕
            </button>
</div>
<!-- Extended Filter Options -->
<div class="mt-6 space-y-6">
<!-- Part Type -->
<div>
<label class="text-xs font-bold uppercase tracking-wider text-neutral-500 mb-2 block">Part Type</label>
<div class="grid grid-cols-2 gap-2 text-sm">
<label class="flex items-center gap-2 p-2 rounded-lg border border-neutral-200 hover:bg-neutral-50 cursor-pointer">
<input checked="" class="rounded text-neutral-900 focus:ring-0" type="checkbox">
<span class="">Compressors</span>
</label>
<label class="flex items-center gap-2 p-2 rounded-lg border border-neutral-200 hover:bg-neutral-50 cursor-pointer">
<input checked="" class="rounded text-neutral-900 focus:ring-0" type="checkbox">
<span class="">Air Filters</span>
</label>
<label class="flex items-center gap-2 p-2 rounded-lg border border-neutral-200 hover:bg-neutral-50 cursor-pointer">
<input checked="" class="rounded text-neutral-900 focus:ring-0" type="checkbox">
<span class="">Remote Controls</span>
</label>
<label class="flex items-center gap-2 p-2 rounded-lg border border-neutral-200 hover:bg-neutral-50 cursor-pointer">
<input checked="" class="rounded text-neutral-900 focus:ring-0" type="checkbox">
<span class="">PCBs &amp; Circuit</span>
</label>
</div>
</div>
<!-- Compatibility Matrix -->
<div>
<label class="text-xs font-bold uppercase tracking-wider text-neutral-500 mb-2 block">Power &amp; Voltage</label>
<div class="space-y-2 text-sm">
<label class="flex items-center gap-2">
<input checked="" class="text-neutral-900 focus:ring-0" name="voltage" type="radio" value="all">
<span class="">All Voltages (220V - 240V AC)</span>
</label>
<label class="flex items-center gap-2">
<input class="text-neutral-900 focus:ring-0" name="voltage" type="radio" value="inverter">
<span class="">Inverter Only (DC Motors)</span>
</label>
</div>
</div>
<!-- Warranty -->
<div>
<label class="text-xs font-bold uppercase tracking-wider text-neutral-500 mb-2 block">OEM Warranty</label>
<div class="space-y-2 text-sm">
<label class="flex items-center gap-2">
<input class="rounded text-neutral-900 focus:ring-0" type="checkbox">
<span class="">1 Year Manufacturer Warranty</span>
</label>
<label class="flex items-center gap-2">
<input class="rounded text-neutral-900 focus:ring-0" type="checkbox">
<span class="">Ready Stock in Bengaluru Hub</span>
</label>
</div>
</div>
</div>
</div>
<!-- Footer Actions in Drawer -->
<div class="p-6 bg-neutral-50 border-t border-neutral-200 flex gap-3">
<button class="flex-1 py-2.5 px-4 text-xs font-semibold text-neutral-600 bg-white border border-neutral-200 rounded-xl hover:bg-neutral-100" id="resetExtendedFilters">
            Reset
          </button>
<button class="flex-1 py-2.5 px-4 text-xs font-semibold text-white bg-neutral-900 rounded-xl hover:bg-black" id="applyExtendedFilters">
            Apply Filters
          </button>
</div>
</div>
</div>
</div>
<!-- END: "More Filters" Slide-Over Panel -->
<!-- BEGIN: Application Client-Side State & Interaction Logic -->
<script data-purpose="app-logic">
    // Mock Product Database matching the exact visual references & spare catalog
    const productsDB = <?php echo json_encode($js_products); ?>;
    const CI_BASE_URL = "<?= base_url() ?>";
    const CI_SITE_URL = "<?= site_url() ?>";

    // Reactive Application State
    const state = {
      category: "AC",
      brand: "All",
      availability: "In Stock",
      size: "All",
      searchQuery: "",
      sortBy: "relevance"
    };

    // DOM Elements
    const productGrid = document.getElementById("productGrid");
    const emptyCatalogState = document.getElementById("emptyCatalogState");
    const productCounter = document.getElementById("productCounter");
    const catalogTitle = document.getElementById("catalogTitle");
    const filterCategory = document.getElementById("filterCategory");
    const filterBrand = document.getElementById("filterBrand");
    const filterAvailability = document.getElementById("filterAvailability");
    const filterSize = document.getElementById("filterSize");
    const sortBySelect = document.getElementById("sortBySelect");
    const heroSearchForm = document.getElementById("heroSearchForm");
    const mainSearchInput = document.getElementById("mainSearchInput");
    const searchSuggestions = document.getElementById("searchSuggestions");
    const activeFilterChips = document.getElementById("activeFilterChips");
    const chipCategoryLabel = document.getElementById("chipCategoryLabel");
    const chipAvailLabel = document.getElementById("chipAvailLabel");
    const clearAllFiltersBtn = document.getElementById("clearAllFiltersBtn");
    const resetFromEmptyBtn = document.getElementById("resetFromEmptyBtn");

    // Modal elements
    const productDetailModal = document.getElementById("productDetailModal");
    const modalDetailContent = document.getElementById("modalDetailContent");
    const closeDetailModalBtn = document.getElementById("closeDetailModalBtn");
    const closeDetailBackdrop = document.getElementById("closeDetailBackdrop");

    // Slide-over elements
    const moreFiltersPanel = document.getElementById("moreFiltersPanel");
    const openMoreFiltersBtn = document.getElementById("openMoreFiltersBtn");
    const closeMoreFiltersBtn = document.getElementById("closeMoreFiltersBtn");
    const closeFilterBackdrop = document.getElementById("closeFilterBackdrop");
    const applyExtendedFilters = document.getElementById("applyExtendedFilters");
    const resetExtendedFilters = document.getElementById("resetExtendedFilters");

    // Render Product Cards to DOM
    function renderProducts() {
      // 1. Filter items based on active criteria
      let filtered = productsDB.filter(item => {
        // Category filter
        if (state.category !== "All" && item.category !== state.category) {
          return false;
        }

        // Availability filter
        if (state.availability === "In Stock" && !item.inStock) {
          return false;
        }
        if (state.availability === "Not Available" && item.inStock) {
          return false;
        }

        // Brand filter
        if (state.brand !== "All") {
          const hasBrand = item.brand.some(b => b.toLowerCase().includes(state.brand.toLowerCase()) || b === "All Brands");
          if (!hasBrand) return false;
        }

        // Size filter
        if (state.size !== "All" && item.size !== state.size) {
          return false;
        }

        // Search text filter
        if (state.searchQuery.trim() !== "") {
          const q = state.searchQuery.toLowerCase();
          const matchTitle = item.title.toLowerCase().includes(q);
          const matchCategory = item.category.toLowerCase().includes(q);
          const matchBrand = item.brand.some(b => b.toLowerCase().includes(q));
          if (!matchTitle && !matchCategory && !matchBrand) return false;
        }

        return true;
      });

      // 2. Sort items
      if (state.sortBy === "name-asc") {
        filtered.sort((a, b) => a.title.localeCompare(b.title));
      } else if (state.sortBy === "brand") {
        filtered.sort((a, b) => a.brand[0].localeCompare(b.brand[0]));
      }

      // Update counters & Title
      productCounter.textContent = `${filtered.length} products`;
      catalogTitle.textContent = state.category === "All" ? "All Spare Parts" : `${state.category} Spare Parts`;

      // Update active chips UI
      chipCategoryLabel.textContent = state.category;
      chipAvailLabel.textContent = state.availability;

      // Handle Empty State
      if (filtered.length === 0) {
        productGrid.innerHTML = "";
        emptyCatalogState.classList.remove("hidden");
        return;
      } else {
        emptyCatalogState.classList.add("hidden");
      }

      // Render items
      productGrid.innerHTML = filtered.map(item => {
        
        const imgTag = (item.image && item.image.indexOf('default.png') === -1)
          ? `<img src="${item.image}" alt="${item.title}" class="w-24 h-24 object-contain max-h-full drop-shadow-sm">`
          : (item.imageSvg || `<img src="${item.image || (CI_BASE_URL + 'uploads/products/default.png')}" alt="${item.title}" class="w-24 h-24 object-contain max-h-full">`);
    
        const brandListStr = item.brand.slice(0, 4).join(", ");
        const waText = encodeURIComponent(`Hi Sahara Hardware, I am interested in checking availability for ${item.title} (${item.size}) [SKU: ${item.sku}].`);
        const waLink = `https://wa.me/919876543210?text=${waText}`;

        return `
          <div class="product-card group bg-white rounded-2xl p-4 border border-neutral-200/90 shadow-sm hover:shadow-xl hover:border-neutral-400 transition-all duration-300 flex flex-col justify-between" data-id="${item.id}">
            
            <div>
              <!-- Visual Product Container with light background -->
              <div class="w-full aspect-[4/3] rounded-xl bg-neutral-50 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-neutral-100/70 transition-colors">
                ${imgTag}
                <span class="absolute top-2.5 right-2.5 text-[11px] font-bold text-neutral-600 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded shadow-xs border border-neutral-200">
                  ${item.price}
                </span>
              </div>

              <!-- Product Info -->
              <div class="mt-4">
                <h3 class="text-base font-bold text-neutral-900 group-hover:text-black leading-snug">
                  ${item.title}
                </h3>
                
                <p class="text-xs text-neutral-500 mt-1 line-clamp-1">
                  Suitable for ${brandListStr}
                </p>

                <div class="mt-2 text-xs text-neutral-700">
                  <span class="font-medium text-neutral-400">Size:</span> 
                  <span class="font-semibold text-neutral-800">${item.size}</span>
                </div>
              </div>
            </div>

            <!-- Footer: Stock Badge & Actions matching reference -->
            <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
              
              <!-- Stock Indicator Badge -->
              <div>
                ${item.inStock 
                  ? `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]">
                      <span class="w-1.5 h-1.5 rounded-full bg-[#16B364]"></span>
                      In Stock
                    </span>`
                  : `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#FDF2F2] text-[#EF4444]">
                      <span class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></span>
                      Not Available
                    </span>`
                }
              </div>

              <!-- Action Buttons: WhatsApp & Details Drawer Trigger -->
              <div class="flex items-center gap-2">
                
                <!-- Quick WhatsApp Action CTA -->
                <a 
                  href="${waLink}" 
                  target="_blank" 
                  rel="noreferrer"
                  title="Enquire on WhatsApp"
                  class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white flex items-center justify-center transition shadow-sm active:scale-95"
                  aria-label="Enquire on WhatsApp about ${item.title}">
                  <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"/></svg>
                </a>

                <!-- Details Arrow Button -->
                <button 
                  type="button"
                  data-view-id="${item.id}"
                  title="View Specs & OEM Details"
                  class="view-product-btn w-9 h-9 rounded-full bg-neutral-100 hover:bg-neutral-900 hover:text-white text-neutral-700 flex items-center justify-center transition active:scale-95 border border-neutral-200">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                  </svg>
                </button>

              </div>

            </div>

          </div>
        `;
      }).join("");

      // Bind Details Trigger Buttons
      document.querySelectorAll(".view-product-btn").forEach(btn => {
        btn.addEventListener("click", () => {
          const id = btn.getAttribute("data-view-id");
          openProductDetail(id);
        });
      });
    }

    // Open & Render Product Detail Modal
    function openProductDetail(productId) {
      const item = productsDB.find(p => p.id === productId);
      if (!item) return;

      const waText = encodeURIComponent(`Hi Sahara Hardware, I am looking to purchase/verify stock for: ${item.title} (${item.sku}). Please let me know pickup or delivery details.`);
      const waLink = `https://wa.me/919876543210?text=${waText}`;

      modalDetailContent.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
          <div class="aspect-square bg-neutral-50 rounded-2xl flex items-center justify-center p-6 border border-neutral-200">
            ${imgTag}
          </div>
          <div>
            <div class="flex items-center gap-2">
              <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">${item.category}</span>
              <span class="text-xs text-neutral-300">•</span>
              <span class="text-xs font-mono font-semibold text-neutral-500">${item.sku}</span>
            </div>
            
            <h2 class="text-2xl font-bold text-neutral-900 mt-1">${item.title}</h2>
            <div class="text-2xl font-extrabold text-neutral-900 mt-2">${item.price}</div>

            <div class="mt-3">
              ${item.inStock 
                ? `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#EAF8F0] text-[#16B364]">
                    <span class="w-2 h-2 rounded-full bg-[#16B364]"></span>
                    In Stock at Sahara Hardware (${item.stockCount} units available)
                  </span>`
                : `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FDF2F2] text-[#EF4444]">
                    <span class="w-2 h-2 rounded-full bg-[#EF4444]"></span>
                    Currently Sold Out (Back-order upon enquiry)
                  </span>`
              }
            </div>

            <!-- Specs Matrix -->
            <div class="mt-6 border-t border-neutral-200 pt-4 space-y-2 text-xs">
              <div class="flex justify-between py-1 border-b border-neutral-100">
                <span class="text-neutral-500">Supported Brands:</span>
                <span class="font-semibold text-neutral-800">${item.brand.join(", ")}</span>
              </div>
              <div class="flex justify-between py-1 border-b border-neutral-100">
                <span class="text-neutral-500">Size / Tonnage:</span>
                <span class="font-semibold text-neutral-800">${item.size}</span>
              </div>
              ${Object.entries(item.specs).map(([k, v]) => `
                <div class="flex justify-between py-1 border-b border-neutral-100">
                  <span class="text-neutral-500 capitalize">${k}:</span>
                  <span class="font-semibold text-neutral-800">${v}</span>
                </div>
              `).join('')}
            </div>

            <!-- Call to Actions -->
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
              <a 
                href="${waLink}" 
                target="_blank"
                class="flex-1 inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-white py-3 px-4 rounded-xl text-sm font-bold shadow-md transition">
                <span>Direct WhatsApp Order</span>
              </a>
              <a 
                href="tel:+919876543210"
                class="inline-flex items-center justify-center gap-2 bg-neutral-900 hover:bg-black text-white py-3 px-4 rounded-xl text-sm font-bold transition">
                <span>Call Store</span>
              </a>
            </div>

          </div>
        </div>
      `;

      productDetailModal.classList.remove("hidden");
    }

    function closeProductDetail() {
      productDetailModal.classList.add("hidden");
    }

    // Category Card Click Interactivity
    document.querySelectorAll(".category-card").forEach(card => {
      card.addEventListener("click", () => {
        const cat = card.getAttribute("data-category-name");
        
        // Update active UI card style
        document.querySelectorAll(".category-card").forEach(c => {
          c.classList.remove("border-2", "border-neutral-900", "ring-2", "ring-neutral-900/10");
          c.classList.add("border-neutral-200/80");
        });
        card.classList.add("border-2", "border-neutral-900", "ring-2", "ring-neutral-900/10");

        // Sync dropdown & state
        state.category = cat;
        filterCategory.value = cat;
        renderProducts();

        // Smooth scroll to catalog
        document.getElementById("products-section").scrollIntoView({ behavior: 'smooth' });
      });
    });

    // Dropdown Event Listeners
    filterCategory.addEventListener("change", (e) => {
      state.category = e.target.value;
      renderProducts();
    });

    filterBrand.addEventListener("change", (e) => {
      state.brand = e.target.value;
      renderProducts();
    });

    filterAvailability.addEventListener("change", (e) => {
      state.availability = e.target.value;
      renderProducts();
    });

    filterSize.addEventListener("change", (e) => {
      state.size = e.target.value;
      renderProducts();
    });

    sortBySelect.addEventListener("change", (e) => {
      state.sortBy = e.target.value;
      renderProducts();
    });

    // Quick Search Input & Auto-suggestions Logic
    mainSearchInput.addEventListener("focus", () => {
      searchSuggestions.classList.remove("hidden");
    });

    document.addEventListener("click", (e) => {
      if (!heroSearchForm.contains(e.target) && !searchSuggestions.contains(e.target)) {
        searchSuggestions.classList.add("hidden");
      }
    });

    document.querySelectorAll(".suggestion-item").forEach(item => {
      item.addEventListener("click", () => {
        const query = item.getAttribute("data-search");
        mainSearchInput.value = query;
        state.searchQuery = query;
        searchSuggestions.classList.add("hidden");
        renderProducts();
        document.getElementById("products-section").scrollIntoView({ behavior: 'smooth' });
      });
    });

    heroSearchForm.addEventListener("submit", (e) => {
      e.preventDefault();
      state.searchQuery = mainSearchInput.value.trim();
      searchSuggestions.classList.add("hidden");
      renderProducts();
      document.getElementById("products-section").scrollIntoView({ behavior: 'smooth' });
    });

    // Reset Filters Buttons
    function resetAllFilters() {
      state.category = "All";
      state.brand = "All";
      state.availability = "All";
      state.size = "All";
      state.searchQuery = "";
      state.sortBy = "relevance";

      filterCategory.value = "All";
      filterBrand.value = "All";
      filterAvailability.value = "All";
      filterSize.value = "All";
      mainSearchInput.value = "";
      sortBySelect.value = "relevance";

      renderProducts();
    }

    clearAllFiltersBtn.addEventListener("click", resetAllFilters);
    resetFromEmptyBtn.addEventListener("click", resetAllFilters);

    // Modal Close Triggers
    closeDetailModalBtn.addEventListener("click", closeProductDetail);
    closeDetailBackdrop.addEventListener("click", closeProductDetail);

    // "More Filters" Slide-Over Triggers
    openMoreFiltersBtn.addEventListener("click", () => {
      moreFiltersPanel.classList.remove("hidden");
    });
    closeMoreFiltersBtn.addEventListener("click", () => {
      moreFiltersPanel.classList.add("hidden");
    });
    closeFilterBackdrop.addEventListener("click", () => {
      moreFiltersPanel.classList.add("hidden");
    });
    applyExtendedFilters.addEventListener("click", () => {
      moreFiltersPanel.classList.add("hidden");
      renderProducts();
    });
    resetExtendedFilters.addEventListener("click", () => {
      moreFiltersPanel.classList.add("hidden");
      resetAllFilters();
    });

    // Nav Search trigger scroll
    document.getElementById("navSearchTrigger").addEventListener("click", () => {
      mainSearchInput.focus();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // View All Categories trigger
    document.getElementById("viewAllCategoriesBtn").addEventListener("click", () => {
      state.category = "All";
      filterCategory.value = "All";
      renderProducts();
      document.getElementById("products-section").scrollIntoView({ behavior: 'smooth' });
    });

    // Initial Render
    renderProducts();
  </script>
<!-- END: Application Client-Side State & Interaction Logic -->


</body></html>