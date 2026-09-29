<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Sahara Operations Sidebar -->
<aside class="w-64 bg-surface-container-low border-r border-outline-variant/60 flex flex-col justify-between shrink-0 min-h-screen">
    <div class="p-5">
        <!-- Brand Header -->
        <div class="flex items-center gap-3 pb-6 border-b border-outline-variant/40">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-sm">
                <span class="material-symbols-outlined text-2xl">precision_manufacturing</span>
            </div>
            <div>
                <div class="font-headline font-bold text-lg leading-none text-on-surface">LOG HARDWARE</div>
                <div class="text-[10px] uppercase font-mono tracking-widest text-primary mt-0.5">Sahara Hub</div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6 space-y-1 text-xs font-medium">
            <a href="<?= site_url('admin/dashboard') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= ($this->uri->segment(2) === 'dashboard' || !$this->uri->segment(2)) ? 'bg-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?>">
                <span class="material-symbols-outlined text-lg">inventory_2</span>
                <span>Inventory & Catalog</span>
            </a>

            <a href="<?= site_url('admin/products/add') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= ($this->uri->segment(3) === 'add') ? 'bg-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?>">
                <span class="material-symbols-outlined text-lg">add_box</span>
                <span>Add Product</span>
            </a>

            <a href="<?= site_url('admin/inquiries') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= ($this->uri->segment(2) === 'inquiries') ? 'bg-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?>">
                <span class="material-symbols-outlined text-lg">receipt_long</span>
                <span>Orders & Inquiries</span>
            </a>

            <a href="<?= site_url('admin/categories') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= ($this->uri->segment(2) === 'categories') ? 'bg-primary text-white font-bold shadow-xs' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?>">
                <span class="material-symbols-outlined text-lg">category</span>
                <span>Categories</span>
            </a>

            <a href="<?= site_url('products') ?>" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition">
                <span class="material-symbols-outlined text-lg">storefront</span>
                <span>Customer Storefront</span>
            </a>
        </nav>
    </div>

    <!-- User / Session Footer -->
    <div class="p-4 border-t border-outline-variant/40 bg-surface-container/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-xs">
                    <?= strtoupper(substr($this->session->userdata('admin_name') ?: 'S', 0, 1)) ?>
                </div>
                <div class="truncate max-w-[110px]">
                    <div class="text-xs font-bold text-on-surface truncate"><?= html_escape($this->session->userdata('admin_name') ?: 'Admin') ?></div>
                    <div class="text-[10px] text-on-surface-variant font-mono truncate"><?= html_escape($this->session->userdata('admin_email') ?: 'Sameer123@AA.com') ?></div>
                </div>
            </div>
            <a href="<?= site_url('admin/logout') ?>" class="p-1.5 rounded-lg text-error hover:bg-error-container/40 transition" title="Logout">
                <span class="material-symbols-outlined text-lg">logout</span>
            </a>
        </div>
    </div>
</aside>
