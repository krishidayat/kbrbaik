with open('/var/www/radio/routes/api.php', 'r') as f:
    content = f.read()

# Add Wiki search endpoint at the end
new_endpoint = """

Route::get('/wiki/search', function () {
    $query = request('q');
    if (!$query || strlen($query) < 2) {
        return response()->json(['results' => []]);
    }

    $wikiDir = '/home/ubuntu/kbrbaik-wiki/wiki';
    $results = [];
    $keywords = array_map('trim', explode(' ', strtolower($query)));

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($wikiDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'md') continue;
        $content = file_get_contents($file->getPathname());
        $lower = strtolower($content);

        $match = true;
        foreach ($keywords as $kw) {
            if ($kw && !str_contains($lower, $kw)) {
                $match = false;
                break;
            }
        }

        if (!$match) continue;

        $lines = explode("\n", $content);
        $title = '';
        $excerpt = '';
        $answerLines = [];

        foreach ($lines as $i => $line) {
            if (preg_match('/^#\s+(.+)/', $line, $m)) {
                if (!$title) $title = $m[1];
            }
            // Collect 3 lines of context around the keyword match
            if (!$excerpt && preg_match('/' . preg_quote($query, '/') . '/i', $line)) {
                $start = max(0, $i - 1);
                $excerpt = implode(' ', array_slice($lines, $start, 5));
                $excerpt = strip_tags($excerpt);
                $excerpt = mb_substr($excerpt, 0, 300);
            }
        }

        if (!$title) $title = $file->getFilenameWithoutExtension();

        $relativePath = str_replace($wikiDir . '/', '', $file->getPathname());
        $url = 'https://wiki.kbrbaik.live/' . pathinfo($relativePath, PATHINFO_DIRNAME) . '/' . $file->getFilenameWithoutExtension();

        $results[] = [
            'title' => $title,
            'excerpt' => $excerpt ?: strip_tags(mb_substr($content, 0, 200)),
            'url' => $url,
            'path' => $relativePath,
        ];
    }

    // Sort by relevance: title match first, then excerpt length
    usort($results, function ($a, $b) use ($keywords, $query) {
        $aTitle = str_contains(strtolower($a['title']), $query) ? 0 : 1;
        $bTitle = str_contains(strtolower($b['title']), $query) ? 0 : 1;
        if ($aTitle !== $bTitle) return $aTitle - $bTitle;
        return strlen($a['excerpt']) <=> strlen($b['excerpt']);
    });

    return response()->json(['results' => array_slice($results, 0, 10)]);
})->name('api.wiki.search');
"""

# Insert before the last closing ?>
insert_pos = content.rfind('?>')
if insert_pos != -1:
    content = content[:insert_pos] + new_endpoint + content[insert_pos:]
else:
    content += new_endpoint

with open('/var/www/radio/routes/api.php', 'w') as f:
    f.write(content)

print('Wiki API endpoint added')
