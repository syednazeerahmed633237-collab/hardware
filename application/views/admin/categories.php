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
              "surface-container-low": "#f6f0e8",
              "tertiary": "#8c3c3c",
              "on-background": "#3a302a",
              "on-surface": "#3a302a",
              "primary": "#c2652a",
              "on-surface-variant": "#605850",
              "surface-container-high": "#ece6dc",
              "surface-container": "#f2ece4",
              "surface-tint": "#c2652a"
            },
            "fontFamily": {
              "headline": ["EB Garamond"],
              "body": ["Manrope"]
            }
          }
        }
      };
    </script>
</head>
<body class="bg-background text-on-surface font-body antialiased min-h-screen">
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        
        <!-- Top Navigation -->
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-outline-variant/60">
            <div class="flex items-center gap-3">
                <a href="<?= site_url('admin/dashboard') ?>" class="w-10 h-10 rounded-xl bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface transition">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline text-2xl sm:text-3xl font-bold text-on-surface leading-tight">
                        Appliance Categories Management
                    </h1>
                    <span class="text-xs text-on-surface-variant font-mono">Catalog taxonomy & product classifications</span>
                </div>
            </div>
            
            <a href="<?= site_url('admin/dashboard') ?>" class="px-3.5 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-xs font-semibold text-on-surface transition">
                Return to Dashboard
            </a>
        </div>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span><?= $this->session->flashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Add Category Form -->
            <div class="lg:col-span-4 bg-surface-container-lowest rounded-2xl p-6 shadow-xl shadow-on-surface/5 border border-outline-variant/40">
                <h2 class="font-headline text-xl font-bold text-on-surface mb-4">Add New Category</h2>
                <?= form_open('admin/categories', array('class' => 'space-y-4')) ?>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1">Category Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Microwave Oven" class="w-full px-3.5 py-2.5 bg-surface-container-low rounded-xl text-xs text-on-surface focus:ring-2 focus:ring-primary border border-outline-variant/40"/>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1">Slug (URL identifier) *</label>
                        <input type="text" name="slug" required placeholder="e.g. microwave-oven" class="w-full px-3.5 py-2.5 bg-surface-container-low rounded-xl text-xs font-mono text-on-surface focus:ring-2 focus:ring-primary border border-outline-variant/40"/>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1">Description</label>
                        <textarea name="description" rows="3" placeholder="Category spare parts summary..." class="w-full px-3.5 py-2.5 bg-surface-container-low rounded-xl text-xs text-on-surface focus:ring-2 focus:ring-primary border border-outline-variant/40 resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1">Material Symbol Icon</label>
                        <input type="text" name="icon" value="inventory_2" placeholder="e.g. microwave, mode_fan" class="w-full px-3.5 py-2.5 bg-surface-container-low rounded-xl text-xs text-on-surface focus:ring-2 focus:ring-primary border border-outline-variant/40"/>
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white text-xs font-bold uppercase tracking-wider transition shadow-sm">
                        Create Category
                    </button>
                <?= form_close() ?>
            </div>

            <!-- Right: Categories List -->
            <div class="lg:col-span-8 bg-surface-container-lowest rounded-2xl shadow-xl shadow-on-surface/5 p-6 border border-outline-variant/40 overflow-hidden">
                <h2 class="font-headline text-xl font-bold text-on-surface mb-4">Existing Categories</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-surface-container-high/40 text-on-surface-variant uppercase tracking-wider text-[11px] font-semibold border-b border-surface-container">
                                <th class="py-3 px-4">Icon & Name</th>
                                <th class="py-3 px-4">Slug</th>
                                <th class="py-3 px-4">Description</th>
                                <th class="py-3 px-4 text-center">Active SKUs</th>
                                <th class="py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container">
                            <?php foreach ($categories as $cat): ?>
                                <tr class="hover:bg-surface-container-low/40 transition">
                                    <td class="py-3.5 px-4 font-bold text-on-surface flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-lg"><?= html_escape($cat->icon ?: 'inventory_2') ?></span>
                                        <?= html_escape($cat->name) ?>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-primary text-[11px]"><?= html_escape($cat->slug) ?></td>
                                    <td class="py-3.5 px-4 text-on-surface-variant max-w-xs truncate"><?= html_escape($cat->description) ?></td>
                                    <td class="py-3.5 px-4 text-center font-mono font-bold"><?= (int)$cat->product_count ?></td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase">
                                            <?= html_escape($cat->status) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</body>
</html>
