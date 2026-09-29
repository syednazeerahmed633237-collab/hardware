<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= html_escape($page_title) ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
      tailwind.config = {
        "darkMode": "class",
        "theme": {
          "extend": {
            "colors": {
              "inverse-on-surface": "#faf5ee",
              "tertiary-container": "#d47070",
              "surface-container-lowest": "#ffffff",
              "on-primary": "#ffffff",
              "on-secondary": "#ffffff",
              "inverse-surface": "#3a302a",
              "background": "#faf5ee",
              "on-primary-fixed": "#401a08",
              "error-container": "#fce4e0",
              "outline-variant": "#d8d0c8",
              "surface-container-highest": "#e6e0d6",
              "on-tertiary-fixed": "#2e1515",
              "primary-container": "#e08850",
              "tertiary-fixed-dim": "#e8a0a0",
              "surface-container-low": "#f6f0e8",
              "tertiary": "#8c3c3c",
              "on-secondary-fixed": "#2a2420",
              "on-background": "#3a302a",
              "on-surface": "#3a302a",
              "on-tertiary": "#ffffff",
              "on-primary-container": "#fbe8d8",
              "on-primary-fixed-variant": "#8a4518",
              "secondary-fixed": "#eae2da",
              "on-secondary-container": "#605850",
              "tertiary-fixed": "#fce0e0",
              "outline": "#9a9088",
              "on-error-container": "#7a1a10",
              "surface-dim": "#dcd6cc",
              "surface-bright": "#faf5ee",
              "primary": "#c2652a",
              "on-surface-variant": "#605850",
              "on-tertiary-fixed-variant": "#6e3030",
              "surface-container-high": "#ece6dc",
              "on-tertiary-container": "#3a2020",
              "primary-fixed-dim": "#f0a878",
              "secondary-fixed-dim": "#cec6be",
              "secondary-container": "#eae2da",
              "inverse-primary": "#f0a878",
              "on-error": "#ffffff",
              "primary-fixed": "#fbe8d8",
              "surface-variant": "#ece6dc",
              "error": "#c0392b",
              "surface": "#faf5ee",
              "secondary": "#78706a",
              "on-secondary-fixed-variant": "#504840",
              "surface-container": "#f2ece4",
              "surface-tint": "#c2652a"
            },
            "borderRadius": {
              "DEFAULT": "0.25rem",
              "lg": "0.5rem",
              "xl": "0.75rem",
              "full": "9999px"
            },
            "fontFamily": {
              "headline": ["EB Garamond"],
              "display": ["EB Garamond"],
              "body": ["Manrope"],
              "label": ["Manrope"]
            }
          }
        }
      };
    </script>
</head>
<body class="bg-background text-on-surface font-body antialiased min-h-screen">
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        
        <!-- Top Navigation / Breadcrumb -->
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-outline-variant/60">
            <div class="flex items-center gap-3">
                <a href="<?= site_url('admin/dashboard') ?>" class="w-10 h-10 rounded-xl bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface transition">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline text-2xl sm:text-3xl font-bold text-on-surface leading-tight">
                        Add New Spare Part / Inventory SKU
                    </h1>
                    <span class="text-xs text-on-surface-variant font-body">Catalog Hub • Sahara Bengaluru Central Node</span>
                </div>
            </div>
            
            <a href="<?= site_url('admin/dashboard') ?>" class="px-3.5 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-xs font-semibold text-on-surface transition">
                Return to Dashboard
            </a>
        </div>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">error</span>
                <span><?= $this->session->flashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-xl shadow-on-surface/5 p-6 sm:p-8 border border-outline-variant/40">
            <?= form_open_multipart('admin/products/add', array('class' => 'space-y-6')) ?>
                
                <!-- Section 1: Title and SKU -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-8 space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Product Title / Spare Part Name <span class="text-error">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="product_name" 
                            value="<?= set_value('product_name') ?>" 
                            placeholder="e.g., Inverter Rotary AC Compressor 1.5T" 
                            required 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-medium text-on-surface focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40"
                        />
                        <span class="text-[11px] text-on-surface-variant">Include appliance category, tonnage, or exact model fit.</span>
                    </div>

                    <div class="md:col-span-4 space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Unique SKU Identifier <span class="text-error">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="sku" 
                            value="<?= set_value('sku') ?>" 
                            placeholder="e.g., AC-COMP-ROT-09" 
                            required 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-mono font-bold text-primary focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40 uppercase"
                        />
                    </div>
                </div>

                <!-- Section 2: Category, Brand, Size -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Appliance Category <span class="text-error">*</span>
                        </label>
                        <select name="category_id" required class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-medium text-on-surface focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40">
                            <option value="">Select Category...</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat->id ?>" <?= set_select('category_id', $cat->id) ?>>
                                    <?= html_escape($cat->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Brand Compatibility <span class="text-error">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="brand" 
                            value="<?= set_value('brand') ?>" 
                            required 
                            placeholder="e.g. LG, Samsung, Daikin, Voltas" 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-medium text-on-surface focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40"
                        />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Capacity / Size Specification
                        </label>
                        <input 
                            type="text" 
                            name="size" 
                            value="<?= set_value('size', 'Standard') ?>" 
                            placeholder="e.g. 1.5 Ton / 2 Ton / Standard" 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-medium text-on-surface focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40"
                        />
                    </div>
                </div>

                <!-- Section 3: Pricing and Stock -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-surface-container">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Wholesale Price (₹) <span class="text-error">*</span>
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="price" 
                            value="<?= set_value('price') ?>" 
                            placeholder="7850" 
                            required 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-mono font-bold text-on-surface focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40"
                        />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Original MRP (₹) (Optional)
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="original_price" 
                            value="<?= set_value('original_price') ?>" 
                            placeholder="9500" 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-mono text-outline focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40"
                        />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Physical Stock Quantity <span class="text-error">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="stock_quantity" 
                            value="<?= set_value('stock_quantity', '10') ?>" 
                            required 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-sm font-mono font-bold text-on-surface focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40"
                        />
                    </div>
                </div>

                <!-- Section 4: Image Upload -->
                <div class="p-5 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                        Upload Product Photo / Schematic Image
                    </label>
                    <input 
                        type="file" 
                        name="image" 
                        accept=".jpg,.jpeg,.png,.webp,.svg" 
                        class="text-xs text-on-surface file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 cursor-pointer"
                    />
                    <p class="text-[11px] text-on-surface-variant">File saved to <code>/uploads/products/</code>. Allowed: JPG, PNG, WEBP, SVG (Max 5MB).</p>
                </div>

                <!-- Section 5: Description & Features -->
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface font-label">
                            Description & Technician Technical Notes
                        </label>
                        <textarea 
                            name="description" 
                            rows="4" 
                            placeholder="Detailed product overview, electrical specs, refrigerant type, or warranty details..." 
                            class="w-full px-4 py-3 bg-surface-container-low rounded-xl text-xs text-on-surface focus:outline-none focus:ring-2 focus:ring-primary border border-outline-variant/40 resize-none font-body"
                        ><?= set_value('description') ?></textarea>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary accent-primary"/>
                                <span class="text-xs font-semibold text-on-surface">Feature on Storefront Homepage</span>
                            </label>

                            <div class="flex items-center gap-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface">Status:</label>
                                <select name="status" class="px-3 py-1.5 bg-surface-container-low rounded-lg text-xs font-semibold text-on-surface border border-outline-variant/40">
                                    <option value="active">Active (Visible)</option>
                                    <option value="inactive">Inactive (Hidden)</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="<?= site_url('admin/dashboard') ?>" class="px-5 py-2.5 rounded-xl bg-surface-container text-xs font-bold text-on-surface hover:bg-surface-container-high transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white text-xs font-bold uppercase tracking-wider transition shadow-sm active:scale-98">
                                Publish to Catalog
                            </button>
                        </div>
                    </div>
                </div>

            <?= form_close() ?>
        </div>
    </div>
</body>
</html>
