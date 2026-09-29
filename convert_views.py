import os
import re

with open('raw_stitch_screens/screen1_home.html', 'r', encoding='utf-8') as f:
    c1 = f.read()

with open('raw_stitch_screens/screen2_catalog.html', 'r', encoding='utf-8') as f:
    c2 = f.read()

def enhance_frontend(html, is_catalog=False):
    # Dynamic PHP header
    php_top = """<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
"""
    # Replace productsDB
    pattern = r'const productsDB\s*=\s*\[.*?\];'
    replacement = """const productsDB = <?php echo json_encode($js_products); ?>;
    const CI_BASE_URL = "<?= base_url() ?>";
    const CI_SITE_URL = "<?= site_url() ?>";"""
    
    html = re.sub(pattern, replacement, html, flags=re.DOTALL)
    
    # Image rendering in JS
    img_render = """
        const imgTag = (item.image && item.image.indexOf('default.png') === -1)
          ? `<img src="${item.image}" alt="${item.title}" class="w-24 h-24 object-contain max-h-full drop-shadow-sm">`
          : (item.imageSvg || `<img src="${item.image || (CI_BASE_URL + 'uploads/products/default.png')}" alt="${item.title}" class="w-24 h-24 object-contain max-h-full">`);
    """
    html = html.replace('const brandListStr =', img_render + '\n        const brandListStr =')
    html = html.replace('${item.imageSvg}', '${imgTag}')
    
    # Add navigation and branding links
    html = html.replace('href="#"', 'href="<?= site_url("products") ?>"')
    
    return php_top + html

os.makedirs('application/views/frontend', exist_ok=True)
with open('application/views/frontend/home.php', 'w', encoding='utf-8') as f:
    f.write(enhance_frontend(c1, False))

with open('application/views/frontend/products.php', 'w', encoding='utf-8') as f:
    f.write(enhance_frontend(c2, True))

print("Created frontend views successfully!")
