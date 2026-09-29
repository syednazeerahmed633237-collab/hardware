<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= html_escape($page_title) ?></title>
    <meta name="description" content="<?= html_escape($product->description) ?>"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS with Forms and Container Queries -->
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
                primary: '#c2652a',
                dark: '#3a302a',
                warm: '#faf5ee',
                accent: '#8c3c3c',
                surface: '#f2ece4',
                border: '#d8d0c8',
              }
            }
          }
        }
      }
    </script>
</head>
<body class="bg-[#faf5ee] text-[#3a302a] font-sans min-h-screen flex flex-col antialiased selection:bg-[#c2652a] selection:text-white">

    <!-- Top Notice Bar -->
    <div class="bg-[#3a302a] text-[#faf5ee] text-xs py-2 px-4 border-b border-[#504840]">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-[#16B364] animate-pulse"></span>
                <span>Bengaluru Central Warehouse: <strong>Open for Counter Pickup & Rapid Courier</strong></span>
            </div>
            <div class="flex items-center gap-4 text-xs font-medium">
                <a href="tel:+919845012345" class="hover:text-[#c2652a] flex items-center gap-1 transition">
                    <span class="material-symbols-outlined text-[14px]">call</span> +91 98450 12345
                </a>
                <a href="<?= site_url('admin/login') ?>" class="hover:text-[#c2652a] flex items-center gap-1 transition">
                    <span class="material-symbols-outlined text-[14px]">admin_panel_settings</span> Staff Portal
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white border-b border-[#d8d0c8]/80 sticky top-0 z-40 backdrop-blur-md bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Logo -->
            <a href="<?= site_url() ?>" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl bg-[#c2652a] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-2xl">precision_manufacturing</span>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-[#3a302a] block leading-none">LOG HARDWARE</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-[#c2652a]">Appliance Spares Hub</span>
                </div>
            </a>

            <!-- Search Bar -->
            <form action="<?= site_url('products') ?>" method="GET" class="hidden md:flex flex-1 max-w-lg mx-6">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search spare parts by name, model number, SKU or brand..." 
                        class="w-full bg-[#faf5ee] border border-[#d8d0c8] rounded-xl pl-11 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#c2652a] focus:border-transparent text-[#3a302a] placeholder:text-neutral-400"
                    />
                    <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-neutral-400 text-xl">search</span>
                </div>
            </form>

            <!-- Navigation Links -->
            <nav class="flex items-center gap-3 sm:gap-6 text-sm font-semibold">
                <a href="<?= site_url('products') ?>" class="text-[#3a302a] hover:text-[#c2652a] transition flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-lg">grid_view</span> All Catalog
                </a>
                <a href="https://wa.me/919845012345?text=<?= urlencode('Hi Log HARDWARE, I need assistance with ' . $product->product_name . ' [SKU: ' . $product->sku . ']') ?>" target="_blank" rel="noreferrer" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#25D366] hover:bg-[#20ba59] text-white font-bold transition shadow-sm active:scale-95 text-xs sm:text-sm">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"/></svg>
                    <span>Instant WhatsApp</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-neutral-500 mb-6 overflow-x-auto py-1">
            <a href="<?= site_url() ?>" class="hover:text-[#c2652a] flex items-center gap-1">Home</a>
            <span>/</span>
            <a href="<?= site_url('products') ?>" class="hover:text-[#c2652a]">Catalog</a>
            <span>/</span>
            <a href="<?= site_url('products?category=' . $product->category_slug) ?>" class="hover:text-[#c2652a] font-medium text-neutral-700"><?= html_escape($product->category_name) ?></a>
            <span>/</span>
            <span class="text-[#c2652a] font-semibold truncate"><?= html_escape($product->product_name) ?></span>
        </nav>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span><?= $this->session->flashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">error</span>
                <span><?= $this->session->flashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Product Presentation Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Product Visual & Gallery -->
            <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 border border-[#d8d0c8] shadow-sm flex flex-col items-center">
                <div class="w-full aspect-square max-w-md bg-[#faf5ee] rounded-2xl flex items-center justify-center p-8 relative overflow-hidden border border-[#d8d0c8]/60">
                    <img 
                        src="<?= base_url('uploads/products/' . ($product->image ?: 'default.png')) ?>" 
                        alt="<?= html_escape($product->product_name) ?>" 
                        class="w-full h-full object-contain max-h-72 drop-shadow-md transition-transform hover:scale-105 duration-300"
                        onerror="this.src='<?= base_url('uploads/products/ac-air-filter.svg') ?>';"
                    />

                    <!-- Stock Status Ribbon -->
                    <?php if ($product->stock_quantity > 0): ?>
                        <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#EAF8F0] text-[#16B364] border border-[#16B364]/30 shadow-xs">
                            <span class="w-2 h-2 rounded-full bg-[#16B364]"></span>
                            In Stock (<?= (int)$product->stock_quantity ?> Available)
                        </span>
                    <?php else: ?>
                        <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#FDF2F2] text-[#EF4444] border border-[#EF4444]/30 shadow-xs">
                            <span class="w-2 h-2 rounded-full bg-[#EF4444]"></span>
                            Out of Stock (Backorder on Request)
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Assurance Badges -->
                <div class="w-full mt-6 grid grid-cols-3 gap-3 text-center pt-6 border-t border-neutral-100">
                    <div class="p-2.5 rounded-xl bg-[#faf5ee] border border-[#d8d0c8]/50">
                        <span class="material-symbols-outlined text-[#c2652a] text-xl block mb-1">verified</span>
                        <span class="text-[11px] font-bold text-neutral-800 block">100% Genuine</span>
                        <span class="text-[10px] text-neutral-500">OEM Grade</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-[#faf5ee] border border-[#d8d0c8]/50">
                        <span class="material-symbols-outlined text-[#c2652a] text-xl block mb-1">local_shipping</span>
                        <span class="text-[11px] font-bold text-neutral-800 block">Fast Dispatch</span>
                        <span class="text-[10px] text-neutral-500">Same-Day Courier</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-[#faf5ee] border border-[#d8d0c8]/50">
                        <span class="material-symbols-outlined text-[#c2652a] text-xl block mb-1">shield</span>
                        <span class="text-[11px] font-bold text-neutral-800 block">Store Tested</span>
                        <span class="text-[10px] text-neutral-500">Pre-Checked</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Specs, Pricing, and Inquiry Actions -->
            <div class="lg:col-span-6 flex flex-col gap-6">
                
                <!-- Product Metadata Header -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#d8d0c8] shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#c2652a] bg-[#fbe8d8] px-2.5 py-1 rounded-md">
                            <?= html_escape($product->category_name) ?> Spare
                        </span>
                        <span class="text-xs font-mono font-bold text-neutral-500 bg-neutral-100 px-2 py-0.5 rounded border border-neutral-200">
                            SKU: <?= html_escape($product->sku) ?>
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#3a302a] leading-tight">
                        <?= html_escape($product->product_name) ?>
                    </h1>

                    <p class="text-sm text-neutral-600 mt-2 font-medium">
                        Compatible Brands: <strong class="text-neutral-900"><?= html_escape($product->brand) ?></strong>
                    </p>

                    <!-- Pricing Display -->
                    <div class="mt-4 pt-4 border-t border-neutral-100 flex items-baseline gap-3">
                        <span class="text-3xl font-black text-[#c2652a]">
                            ₹<?= number_format($product->price, 0) ?>
                        </span>
                        <?php if ($product->original_price && $product->original_price > $product->price): ?>
                            <span class="text-base text-neutral-400 line-through">
                                ₹<?= number_format($product->original_price, 0) ?>
                            </span>
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">
                                SAVE <?= round((($product->original_price - $product->price) / $product->original_price) * 100) ?>%
                            </span>
                        <?php endif; ?>
                        <span class="text-xs text-neutral-400 font-medium ml-auto">Inclusive of all taxes / GST</span>
                    </div>

                    <!-- Description -->
                    <div class="mt-4 text-sm text-neutral-700 leading-relaxed bg-[#faf5ee] p-4 rounded-xl border border-[#d8d0c8]/60">
                        <?= nl2br(html_escape($product->description)) ?>
                    </div>

                    <!-- Technical Specs Table -->
                    <?php if (!empty($specs)): ?>
                        <div class="mt-6">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-neutral-500 mb-3 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-[#c2652a]">tune</span>
                                Technical Specifications & Dimensions
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                <?php foreach ($specs as $key => $val): ?>
                                    <div class="flex justify-between p-2.5 rounded-lg bg-neutral-50 border border-neutral-200/80">
                                        <span class="text-neutral-500 font-medium capitalize"><?= html_escape(str_replace('_', ' ', $key)) ?>:</span>
                                        <span class="font-bold text-neutral-800 text-right"><?= html_escape($val) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <?php 
                            $wa_msg = "Hi Log HARDWARE, I am interested in purchasing:\nProduct: " . $product->product_name . "\nSKU: " . $product->sku . "\nPrice: ₹" . number_format($product->price, 0) . "\nPlease confirm availability and dispatch options.";
                            $wa_url = "https://wa.me/919845012345?text=" . urlencode($wa_msg);
                        ?>
                        <a 
                            href="<?= $wa_url ?>" 
                            target="_blank" 
                            rel="noreferrer" 
                            class="flex-1 py-3.5 px-6 rounded-2xl bg-[#25D366] hover:bg-[#20ba59] text-white font-bold text-center flex items-center justify-center gap-2 shadow-md transition active:scale-98">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"/></svg>
                            <span>Enquire via WhatsApp</span>
                        </a>

                        <a 
                            href="tel:+919845012345" 
                            class="py-3.5 px-6 rounded-2xl bg-[#3a302a] hover:bg-[#2a221e] text-white font-bold text-center flex items-center justify-center gap-2 transition active:scale-98">
                            <span class="material-symbols-outlined text-lg">call</span>
                            <span>Direct Call</span>
                        </a>
                    </div>
                </div>

                <!-- Instant Inquiry Form -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#d8d0c8] shadow-sm">
                    <h3 class="text-base font-bold text-[#3a302a] mb-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#c2652a]">mail</span>
                        Request Wholesale Quote or Technical Assistance
                    </h3>
                    <p class="text-xs text-neutral-500 mb-4">
                        Field technicians, service centers, and commercial buyers can request bulk discount rates below.
                    </p>

                    <?= form_open('inquire', array('class' => 'space-y-3')) ?>
                        <input type="hidden" name="product_id" value="<?= $product->id ?>"/>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-neutral-700 mb-1">Your Full Name *</label>
                                <input 
                                    type="text" 
                                    name="customer_name" 
                                    required 
                                    placeholder="e.g. Anand Kumar (Technician)" 
                                    class="w-full bg-[#faf5ee] border border-[#d8d0c8] rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-[#c2652a] text-[#3a302a]"
                                />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-neutral-700 mb-1">Contact Phone / WhatsApp *</label>
                                <input 
                                    type="tel" 
                                    name="customer_phone" 
                                    required 
                                    placeholder="+91 98765 43210" 
                                    class="w-full bg-[#faf5ee] border border-[#d8d0c8] rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-[#c2652a] text-[#3a302a]"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-neutral-700 mb-1">Email Address (Optional)</label>
                            <input 
                                type="email" 
                                name="customer_email" 
                                placeholder="name@company.com" 
                                class="w-full bg-[#faf5ee] border border-[#d8d0c8] rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-[#c2652a] text-[#3a302a]"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-neutral-700 mb-1">Quantity & Requirement Details *</label>
                            <textarea 
                                name="message" 
                                rows="3" 
                                required 
                                placeholder="Specify units needed, model numbers, or compatibility queries..." 
                                class="w-full bg-[#faf5ee] border border-[#d8d0c8] rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-[#c2652a] text-[#3a302a] resize-none"
                            ></textarea>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full py-3 rounded-xl bg-[#c2652a] hover:bg-[#a8521d] text-white font-bold text-xs uppercase tracking-wider transition shadow-sm active:scale-98">
                            Send Request to Sales Desk
                        </button>
                    <?= form_close() ?>
                </div>

            </div>

        </div>

        <!-- Related Products Section -->
        <?php if (!empty($related_products)): ?>
            <div class="mt-16 pt-8 border-t border-[#d8d0c8]">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-[#3a302a]">Related <?= html_escape($product->category_name) ?> Spare Parts</h2>
                        <p class="text-xs text-neutral-500">Frequently paired components and replacement kits</p>
                    </div>
                    <a href="<?= site_url('products?category=' . $product->category_slug) ?>" class="text-xs font-bold text-[#c2652a] hover:underline flex items-center gap-1">
                        View all in <?= html_escape($product->category_name) ?> <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <?php foreach ($related_products as $rel): ?>
                        <div class="bg-white rounded-2xl p-4 border border-[#d8d0c8]/90 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                            <div>
                                <div class="w-full aspect-[4/3] rounded-xl bg-[#faf5ee] flex items-center justify-center p-3 relative mb-3">
                                    <img 
                                        src="<?= base_url('uploads/products/' . ($rel->image ?: 'default.png')) ?>" 
                                        alt="<?= html_escape($rel->product_name) ?>" 
                                        class="w-20 h-20 object-contain"
                                        onerror="this.src='<?= base_url('uploads/products/ac-air-filter.svg') ?>';"
                                    />
                                    <span class="absolute top-2 right-2 text-[10px] font-bold text-neutral-600 bg-white px-1.5 py-0.5 rounded shadow-xs">
                                        ₹<?= number_format($rel->price, 0) ?>
                                    </span>
                                </div>
                                <h3 class="text-sm font-bold text-neutral-900 leading-snug">
                                    <?= html_escape($rel->product_name) ?>
                                </h3>
                                <p class="text-[11px] text-neutral-500 mt-0.5 line-clamp-1">
                                    <?= html_escape($rel->brand) ?>
                                </p>
                            </div>
                            <div class="mt-3 pt-2 border-t border-neutral-100 flex items-center justify-between">
                                <span class="text-[11px] font-semibold <?= ($rel->stock_quantity > 0) ? 'text-[#16B364]' : 'text-[#EF4444]' ?>">
                                    <?= ($rel->stock_quantity > 0) ? 'In Stock' : 'Out of Stock' ?>
                                </span>
                                <a href="<?= site_url('products/' . $rel->id) ?>" class="text-xs font-bold text-[#c2652a] hover:underline">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <footer class="bg-[#3a302a] text-[#faf5ee] mt-16 py-12 border-t border-[#504840]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-[#c2652a] text-white flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">precision_manufacturing</span>
                </div>
                <div>
                    <span class="font-bold text-base block">LOG HARDWARE</span>
                    <span class="text-xs text-neutral-400">Official Spare Parts & Appliance Store</span>
                </div>
            </div>
            <div class="text-xs text-neutral-400 text-center sm:text-right">
                <p>© <?= date('Y') ?> Log HARDWARE Operations. All OEM trademarks belong to their respective manufacturers.</p>
                <p class="mt-1">Sahara Central Warehouse, Bengaluru. Dedicated Technician Support Line: +91 98450 12345</p>
            </div>
        </div>
    </footer>

</body>
</html>
