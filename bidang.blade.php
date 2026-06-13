@extends('layouts.suara')

@section('title', 'Bidang - ' . ($station->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Bidang</h1>
        <p class="text-gray-500 mt-1">Kegiatan komisi dan desk PGIW Jabar</p>
    </div>

    <div class="flex flex-wrap gap-4 mb-8">
        <div class="w-full sm:w-64">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Bidang</label>
            <select id="parent-select" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none" onchange="onParentChange(this.value)">
                <option value="semua">Semua Bidang</option>
                @foreach ($parentCategories as $cat)
                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-64">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Komisi / Desk</label>
            <select id="child-select" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none disabled:opacity-50" onchange="onChildChange(this.value)">
                <option value="semua">Semua</option>
            </select>
        </div>
    </div>

    <div id="bidang-loading" class="text-center py-12 hidden">
        <svg class="animate-spin h-8 w-8 text-sky-600 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="bidang-grid"></div>

    <div id="bidang-empty" class="text-center py-12 text-gray-400 hidden">
        Belum ada artikel di kategori ini.
    </div>
</div>

<script>
var currentParent = 'semua';
var currentChild = 'semua';

function renderPost(post) {
    var img = post.featured_image
        ? '<img src="' + post.featured_image + '" alt="' + post.title + '" class="w-full h-28 object-cover">'
        : '<div class="w-full h-28 bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-2xl">📰</div>';
    return '<article class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">'
        + img
        + '<div class="p-3">'
        + (post.category ? '<span class="text-xs font-semibold text-sky-600 bg-sky-50 px-2 py-1 rounded">' + post.category + '</span>' : '')
        + '<h4 class="font-semibold text-sm mt-1 mb-1"><a href="/posts/' + post.slug + '" class="hover:text-sky-700 transition">' + post.title + '</a></h4>'
        + '<p class="text-xs text-gray-500 line-clamp-2">' + (post.body || '').substring(0, 100) + '</p>'
        + '<p class="text-xs text-gray-400 mt-2">' + post.published_at + '</p>'
        + '</div></article>';
}

function onParentChange(slug) {
    currentParent = slug;
    currentChild = 'semua';
    var childSelect = document.getElementById('child-select');
    childSelect.disabled = true;
    childSelect.innerHTML = '<option value="semua">Memuat...</option>';

    if (slug === 'semua') {
        childSelect.innerHTML = '<option value="semua">Semua</option>';
        childSelect.disabled = true;
        fetchPosts();
        return;
    }

    fetch('/api/categories/bidang/' + slug)
        .then(function(r) { return r.json(); })
        .then(function(cats) {
            var html = '<option value="semua">Semua Komisi/Desk</option>';
            cats.forEach(function(c) { html += '<option value="' + c.slug + '">' + c.name + '</option>'; });
            childSelect.innerHTML = html;
            childSelect.disabled = false;
            fetchPosts();
        })
        .catch(function() { childSelect.innerHTML = '<option value="semua">Gagal</option>'; });
}

function onChildChange(slug) {
    currentChild = slug;
    fetchPosts();
}

function fetchPosts() {
    var grid = document.getElementById('bidang-grid');
    var loading = document.getElementById('bidang-loading');
    var empty = document.getElementById('bidang-empty');
    grid.classList.add('hidden');
    empty.classList.add('hidden');
    loading.classList.remove('hidden');

    var url = currentChild !== 'semua'
        ? '/api/posts/group/bidang/' + currentParent + '/' + currentChild
        : '/api/posts/group/bidang/' + currentParent + '/semua';

    fetch(url)
        .then(function(r) { return r.json(); })
        .then(function(json) {
            var posts = json.data || [];
            loading.classList.add('hidden');
            if (posts.length === 0) {
                empty.classList.remove('hidden');
                grid.classList.add('hidden');
            } else {
                grid.innerHTML = posts.map(renderPost).join('');
                grid.classList.remove('hidden');
            }
        })
        .catch(function() { loading.classList.add('hidden'); empty.classList.remove('hidden'); });
}

document.addEventListener('DOMContentLoaded', function() { fetchPosts(); });
</script>
@endsection
