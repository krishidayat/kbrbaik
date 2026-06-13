<?php
$f = '/var/www/radio/resources/views/kbrbaik-blog.blade.php';
$c = file_get_contents($f);

$old = '    async function fetchPosts(slug) {
        var grid = document.getElementById("posts-grid");
        var loading = document.getElementById("posts-loading");
        var empty = document.getElementById("posts-empty");
        grid.classList.add("hidden");
        empty.classList.add("hidden");
        loading.classList.remove("hidden");
        try {
            var url = "/api/posts/group/kbrbaik/" + slug;
            var res = await fetch(url);
            var json = await res.json();
            var posts = json.data || [];
            loading.classList.add("hidden");
            if (posts.length === 0) {
                empty.classList.remove("hidden");
                grid.classList.add("hidden");
            } else {
                grid.innerHTML = posts.map(renderPost).join("");
                grid.classList.remove("hidden");
            }
        } catch(e) {
            loading.classList.add("hidden");
            empty.classList.remove("hidden");
            empty.textContent = "Gagal memuat postingan.";
        }
    }';

$new = '    var currentPage = 1;
    async function fetchPosts(slug, page) {
        page = page || 1;
        currentPage = page;
        currentCategory = slug;
        var grid = document.getElementById("posts-grid");
        var loading = document.getElementById("posts-loading");
        var empty = document.getElementById("posts-empty");
        var nav = document.getElementById("posts-nav");
        grid.classList.add("hidden");
        empty.classList.add("hidden");
        if (nav) nav.classList.add("hidden");
        loading.classList.remove("hidden");
        try {
            var url = "/api/posts/group/kbrbaik/" + slug + "?per_page=6&page=" + page;
            var res = await fetch(url);
            var json = await res.json();
            var posts = json.data || [];
            loading.classList.add("hidden");
            if (posts.length === 0) {
                empty.classList.remove("hidden");
                grid.classList.add("hidden");
                if (nav) nav.classList.add("hidden");
            } else {
                grid.innerHTML = posts.map(renderPost).join("");
                grid.classList.remove("hidden");
                var pagination = \'<div class="col-span-full flex items-center justify-center gap-4 mt-8">\';
                if (json.prev_page_url) pagination += \'<button onclick="fetchPosts(\\\'\' + slug + \'\\\', \' + (page - 1) + \')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-sky-50 text-sky-600 hover:bg-sky-100 transition">\u2190 Sebelumnya</button>\';
                pagination += \'<span class="text-sm text-gray-400">Halaman \' + json.current_page + \' dari \' + json.last_page + \'</span>\';
                if (json.next_page_url) pagination += \'<button onclick="fetchPosts(\\\'\' + slug + \'\\\', \' + (page + 1) + \')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-sky-600 text-white hover:bg-sky-700 transition">Selanjutnya \u2192</button>\';
                pagination += \'</div>\';
                if (!nav) {
                    var div = document.createElement("div");
                    div.id = "posts-nav";
                    div.innerHTML = pagination;
                    grid.parentNode.appendChild(div);
                } else {
                    nav.innerHTML = pagination;
                    nav.classList.remove("hidden");
                }
            }
        } catch(e) {
            loading.classList.add("hidden");
            empty.classList.remove("hidden");
            empty.textContent = "Gagal memuat postingan.";
        }
    }';

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";
