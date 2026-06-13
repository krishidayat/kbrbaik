<?php
require_once('/home/tanw3558/public_html/wp-load.php');

$functions_path = '/home/tanw3558/public_html/wp-content/themes/hestia-1/functions.php';
$functions = file_get_contents($functions_path);

// Add CSS + JS to handle top bar scroll
$fix_code = "\n\n// Fix: Navbar flush to top after scrolling past top bar
function ttm_topbar_scroll_fix() {
    ?>
    <style>
    /* When scrolled past top bar, move navbar to top */
    .header-with-topbar.navbar-fixed-top.navbar-scrolled {
        top: 0 !important;
    }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var navbar = document.querySelector('.navbar.header-with-topbar');
        if (!navbar) return;
        var topbar = document.querySelector('.hestia-top-bar');
        if (!topbar) return;
        
        var navbarOriginalTop = 36; // top bar height
        
        function onScroll() {
            var topbarBottom = topbar.offsetTop + topbar.offsetHeight;
            var scrollY = window.scrollY || window.pageYOffset;
            
            if (scrollY >= topbarBottom) {
                navbar.style.top = '0px';
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.style.top = navbarOriginalTop + 'px';
                navbar.classList.remove('navbar-scrolled');
            }
        }
        
        window.addEventListener('scroll', onScroll);
        onScroll(); // Check initial state
    });
    </script>
    <?php
}
add_action('wp_footer', 'ttm_topbar_scroll_fix');
";

// Append to functions.php
file_put_contents($functions_path, $functions . $fix_code);
echo '<p style="color:green">Fix added to functions.php!</p>';
echo '<p><a href="https://tanganterbukamedia.com/">Visit site</a></p>';
?>
