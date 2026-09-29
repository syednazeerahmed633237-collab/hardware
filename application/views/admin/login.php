<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= html_escape($page_title) ?></title>
    <meta content="web_blank" name="shell-type"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
      @layer base {
        html, body { margin:0; padding:0; }
        body { overscroll-behavior:none; }
        main > :first-child { margin-top:0!important; }
        main > :last-child { margin-bottom:0!important; }
      }
      ::-webkit-scrollbar { display:none; }
    </style>
    
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
<body class="bg-background text-on-surface font-body antialiased selection:bg-primary selection:text-white min-h-screen">
<main class="min-h-screen flex flex-col justify-between p-4 sm:p-6 md:p-10">

<div class="flex-1 flex items-center justify-center">
  <div class="w-full max-w-md mx-auto flex flex-col items-center text-center">
    
    <!-- Branding & Header Section -->
    <header class="mb-8 flex flex-col items-center">
      <div class="flex items-center gap-2 mb-3">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary shadow-sm">
          <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">precision_manufacturing</span>
        </div>
        <span class="font-headline text-2xl sm:text-3xl font-bold tracking-tight text-on-surface">Log HARDWARE</span>
        <span class="text-[10px] font-mono font-semibold px-2 py-0.5 rounded bg-surface-container-high text-primary uppercase tracking-widest border border-outline-variant/60">SYS.24</span>
      </div>

      <h1 class="font-headline text-3xl sm:text-4xl font-normal text-on-surface tracking-tight">
        Sahara Hardware Admin Portal
      </h1>
      <p class="font-body text-xs sm:text-sm text-on-surface-variant max-w-sm mt-2 font-normal leading-relaxed">
        Manage inventory, catalog spare parts, technician orders, and store branches.
      </p>
    </header>

    <!-- Modern Elevated Auth Card -->
    <div class="w-full bg-surface-container-lowest rounded-xl shadow-xl shadow-on-surface/5 p-7 sm:p-9 relative overflow-hidden border border-outline-variant/40">
      
      <!-- Decorative Top Accent -->
      <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary via-primary-container to-surface-container-high"></div>

      <!-- Security Status Bar -->
      <div class="flex items-center justify-between pb-6 mb-6 border-b border-surface-container-low">
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-low text-on-surface-variant text-xs font-medium">
          <span class="material-symbols-outlined text-tertiary text-sm" style="font-variation-settings: 'FILL' 1;">lock</span>
          <span>Authorized Personnel Only</span>
        </div>
        <div class="flex items-center gap-1.5 text-[11px] font-mono text-outline font-medium tracking-tight">
          <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
          <span>GATE-01 READY</span>
        </div>
      </div>

      <!-- Inline Error Message Display -->
      <?php if (!empty($error)): ?>
        <div class="mb-5 p-3.5 rounded-lg bg-red-50 border border-red-200 text-red-800 text-xs font-medium text-left flex items-start gap-2.5 animate-shake">
          <span class="material-symbols-outlined text-red-600 text-base shrink-0 mt-0.5">error</span>
          <span><?= html_escape($error) ?></span>
        </div>
      <?php endif; ?>

      <!-- Authentication Form -->
      <?= form_open('admin/login', array('class' => 'space-y-5 text-left', 'id' => 'admin-login-form')) ?>
        
        <!-- Identifier Input -->
        <div class="space-y-1.5">
          <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant" for="admin-id">
            Store Admin Email or Staff ID
          </label>
          <div class="relative flex items-center">
            <span class="absolute left-3.5 text-secondary text-lg pointer-events-none material-symbols-outlined">badge</span>
            <input 
              type="text" 
              name="email" 
              id="admin-id" 
              autocomplete="username" 
              value="<?= set_value('email', 'Sameer123@AA.com') ?>" 
              placeholder="admin@loghardware.com" 
              required 
              class="w-full pl-11 pr-4 py-3 bg-surface-container-low text-on-surface rounded-lg text-sm transition-all duration-150 placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/40 font-body border border-transparent focus:border-primary/50"
            />
          </div>
        </div>

        <!-- Password Input -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant" for="admin-password">
              Master Password
            </label>
            <span class="text-[11px] font-mono text-outline">Demo: Sameer3111</span>
          </div>
          <div class="relative flex items-center">
            <span class="absolute left-3.5 text-secondary text-lg pointer-events-none material-symbols-outlined">key</span>
            <input 
              type="password" 
              name="password" 
              id="admin-password" 
              autocomplete="current-password" 
              placeholder="••••••••••••" 
              required 
              class="w-full pl-11 pr-11 py-3 bg-surface-container-low text-on-surface rounded-lg text-sm transition-all duration-150 placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/40 font-body border border-transparent focus:border-primary/50"
            />
            <button 
              type="button" 
              id="toggle-pwd-btn" 
              onclick="togglePasswordVisibility()" 
              class="absolute right-3 text-secondary hover:text-on-surface p-1 transition-colors flex items-center" 
              aria-label="Toggle password visibility">
              <span class="material-symbols-outlined text-lg" id="pwd-icon">visibility</span>
            </button>
          </div>
        </div>

        <!-- Terminal Session Option -->
        <div class="flex items-center justify-between pt-1">
          <label class="flex items-center gap-2.5 cursor-pointer select-none">
            <input type="checkbox" name="remember" id="remember-terminal" checked class="w-4 h-4 rounded text-primary focus:ring-primary bg-surface-container accent-primary transition-all cursor-pointer"/>
            <span class="text-xs text-on-surface-variant font-medium">Remember this terminal</span>
          </label>
          <span class="text-[11px] text-outline font-mono">12-hr session</span>
        </div>

        <!-- Primary CTA Button (Charcoal Black #151515, bold, rounded-xl) -->
        <button 
          type="submit" 
          id="submit-btn" 
          class="w-full mt-2 py-3.5 px-6 rounded-xl bg-[#151515] hover:bg-black text-white font-medium text-sm flex items-center justify-center gap-2 shadow-lg shadow-black/10 active:scale-[0.99] transition-all duration-150 cursor-pointer group">
          <span class="tracking-wide" id="btn-text">Sign In to Dashboard</span>
          <span class="material-symbols-outlined text-base group-hover:translate-x-0.5 transition-transform" id="btn-icon">arrow_forward</span>
        </button>

      <?= form_close() ?>

      <!-- Hardware 2FA & Encryption Note -->
      <div class="mt-6 pt-5 bg-surface-container-low rounded-lg p-3.5 flex items-start gap-3 text-left">
        <span class="material-symbols-outlined text-primary text-lg mt-0.5 shrink-0" style="font-variation-settings: 'FILL' 1;">verified_user</span>
        <div class="flex flex-col">
          <span class="text-xs font-semibold text-on-surface leading-tight">Secured with Hardware 2FA</span>
          <span class="text-[11px] text-on-surface-variant mt-0.5 leading-snug">Sahara Bengaluru Store Network 256-bit encryption verified.</span>
        </div>
      </div>

    </div>

    <!-- Quick Status Badge -->
    <div class="mt-6 flex flex-wrap items-center justify-center gap-2 text-xs text-on-surface-variant font-body">
      <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-container-high/80 text-on-surface font-medium text-[11px]">
        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
        <span>Main Bengaluru Store</span>
        <span class="text-outline">•</span>
        <span class="font-mono text-outline-variant">Server Online (v2.4)</span>
      </div>
    </div>

    <!-- Return to Storefront Link -->
    <a href="<?= site_url() ?>" class="mt-6 inline-flex items-center gap-2 text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors duration-150 group">
      <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
      <span>Return to Customer Storefront</span>
    </a>

    <!-- Footer Meta -->
    <div class="mt-8 text-center text-[10px] uppercase font-mono tracking-widest text-outline">
      Internal Depot Operations • Hardware Terminal #BLR-NORTH-04
    </div>

  </div>
</div>

<script>
  function togglePasswordVisibility() {
    const input = document.getElementById('admin-password');
    const icon = document.getElementById('pwd-icon');
    if (!input || !icon) return;
    
    if (input.type === 'password') {
      input.type = 'text';
      icon.textContent = 'visibility_off';
    } else {
      input.type = 'password';
      icon.textContent = 'visibility';
    }
  }
</script>

</main>
</body>
</html>
