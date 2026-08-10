$pages = \App\Models\SitePage::all();
foreach ($pages as $page) {
    $page->title = str_replace('BGBR', 'Boys and Girls Brigade', $page->title);
    $page->content = str_replace('BGBR', 'Boys and Girls Brigade', $page->content);
    $page->save();
}

$faqs = \App\Models\SiteFaq::all();
foreach ($faqs as $faq) {
    $faq->question = str_replace('BGBR', 'Boys and Girls Brigade', $faq->question);
    $faq->answer = str_replace('BGBR', 'Boys and Girls Brigade', $faq->answer);
    $faq->save();
}
echo "Database content updated successfully.\n";
