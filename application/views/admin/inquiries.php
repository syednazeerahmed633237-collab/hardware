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
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-outline-variant/60">
            <div class="flex items-center gap-3">
                <a href="<?= site_url('admin/dashboard') ?>" class="w-10 h-10 rounded-xl bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface transition">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline text-2xl sm:text-3xl font-bold text-on-surface leading-tight">
                        Technician Inquiries & Orders
                    </h1>
                    <span class="text-xs text-on-surface-variant font-mono">Central Bengaluru Dispatch Node (<?= count($inquiries) ?> records)</span>
                </div>
            </div>
            
            <a href="<?= site_url('admin/dashboard') ?>" class="px-3.5 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-xs font-semibold text-on-surface transition">
                Return to Dashboard
            </a>
        </div>

        <!-- Inquiries Table Card -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-xl shadow-on-surface/5 p-6 border border-outline-variant/40 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-surface-container-high/40 text-on-surface-variant uppercase tracking-wider text-[11px] font-semibold border-b border-surface-container">
                            <th class="py-3 px-4">Inquiry ID</th>
                            <th class="py-3 px-4">Technician / Client</th>
                            <th class="py-3 px-4">Target Product</th>
                            <th class="py-3 px-4">Message / Requirements</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        <?php if (empty($inquiries)): ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-on-surface-variant">No inquiries received yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($inquiries as $inq): ?>
                                <tr class="hover:bg-surface-container-low/40 transition">
                                    <td class="py-3.5 px-4 font-mono font-bold text-primary">
                                        #INQ-<?= str_pad($inq->id, 4, '0', STR_PAD_LEFT) ?>
                                        <div class="text-[10px] text-on-surface-variant font-normal"><?= date('M d, H:i', strtotime($inq->created_at)) ?></div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-on-surface"><?= html_escape($inq->customer_name) ?></div>
                                        <div class="text-[11px] text-primary font-mono flex items-center gap-1 mt-0.5">
                                            <span class="material-symbols-outlined text-[13px]">phone</span>
                                            <a href="tel:<?= html_escape($inq->customer_phone) ?>" class="hover:underline"><?= html_escape($inq->customer_phone) ?></a>
                                        </div>
                                        <?php if ($inq->customer_email): ?>
                                            <div class="text-[10px] text-neutral-400 truncate"><?= html_escape($inq->customer_email) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <?php if ($inq->product_name): ?>
                                            <div class="font-medium text-on-surface truncate max-w-[180px]"><?= html_escape($inq->product_name) ?></div>
                                            <span class="font-mono text-[10px] text-primary font-bold">SKU: <?= html_escape($inq->sku) ?></span>
                                        <?php else: ?>
                                            <span class="text-neutral-400 italic">General Inquiry</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3.5 px-4 max-w-xs text-on-surface leading-relaxed">
                                        <?= nl2br(html_escape($inq->message)) ?>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= ($inq->status === 'new') ? 'bg-amber-100 text-amber-800' : (($inq->status === 'completed') ? 'bg-emerald-100 text-emerald-800' : 'bg-neutral-100 text-neutral-700') ?>">
                                            <?= html_escape($inq->status) ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <?php 
                                                $wa_reply = "Hi " . $inq->customer_name . ", regarding your inquiry for " . ($inq->product_name ?: 'appliance spare parts') . " at Log HARDWARE:";
                                                $wa_link = "https://wa.me/" . preg_replace('/[^0-9]/', '', $inq->customer_phone) . "?text=" . urlencode($wa_reply);
                                            ?>
                                            <a href="<?= $wa_link ?>" target="_blank" rel="noreferrer" class="w-8 h-8 rounded-lg bg-[#25D366] text-white flex items-center justify-center hover:bg-[#20ba59] transition shadow-xs" title="Reply on WhatsApp">
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.942.553 3.754 1.512 5.292L2 22l4.821-1.472a10.007 10.007 0 005.21 1.503c5.536 0 10.031-4.495 10.031-10.031C22.062 6.495 17.567 2 12.031 2zm0 18.337a8.27 8.27 0 01-4.223-1.153l-.303-.18-3.137.959.967-3.056-.197-.314A8.28 8.28 0 013.766 12.03c0-4.566 3.7-8.266 8.265-8.266 4.566 0 8.266 3.7 8.266 8.266 0 4.565-3.7 8.266-8.266 8.266z"/></svg>
                                            </a>
                                            <form action="<?= site_url('admin/inquiries/update_status/' . $inq->id) ?>" method="POST" class="inline">
                                                <input type="hidden" name="status" value="<?= ($inq->status === 'completed') ? 'new' : 'completed' ?>"/>
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface flex items-center justify-center transition" title="Mark as Completed/New">
                                                    <span class="material-symbols-outlined text-[16px]"><?= ($inq->status === 'completed') ? 'undo' : 'check' ?></span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
