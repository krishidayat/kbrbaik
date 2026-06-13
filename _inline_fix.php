<?php
require_once('/home/tanw3558/public_html/wp-load.php');

echo '<h2>Debug fix not showing</h2>';

// Check if the function exists
echo '<p>Function ttm_topbar_scroll_fix exists: ' . var_export(function_exists('ttm_topbar_scroll_fix'), true) . '</p>';

// Check if the parent theme functions.php is loaded
echo '<p>Did we load parent functions: checking by function existence...</p>';

// Check for errors
$errors = ob_get_contents();
if (!empty($errors)) {
    echo '<p>Errors: ' . htmlspecialchars($errors) . '</p>';
}

echo '<p>Try manually calling the function to test...</p>';

// Manually output the fix to verify it works
?>
<style>
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
    
    var navbarOriginalTop = 36;
    
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
    onScroll();
});
</script>
<?php
echo '<p>Inline fix added to page</p>';
echo '<p><a href="https://tanganterbukamedia.com/">Visit site</a></p>';
?>
