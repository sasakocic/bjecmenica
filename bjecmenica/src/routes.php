<?php
// Routes

$app->get('/xx/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/reason/[{language}]', function ($request, $response, $args) {
    $languages = [
        'english',
        'serbian',
        'croatian',
        'serbian-cyrillic',
        'serbo-croatian',
        'arabic',
        'dutch',
        'french',
        'german',
        'greek',
        'italian',
        'norwegian',
        'persian',
        'polish',
        'portuguese',
        'russian',
        'turkish',
        'ukrainian',
        'spanish',
        'magyar',
    ];

    $language = (empty($args['language'])) ? 'english' : $args['language'];
    if (!in_array($language, $languages)) {
        throw new \RuntimeException('Unknown language' . $language);
    }
    // Sample log message
    $this->logger->info("Slim-Skeleton '/reason/$language' route");

    // Render index view
    $navigation = file_get_contents('templates/_navigation.phtml');
    $contents = file_get_contents("text/{$language}.txt");
    $params = [
        'navigation' => $navigation,
        'contents' => $contents,
    ];

    return $this->renderer->render($response, "reason.phtml", $params);
});

$app->get('/{lang}/[{type}]', function ($request, $response, $args) {
    // Sample log message
    $lang = $args['lang'];
    if (!in_array($lang, ['en', 'sr', 'sc'])) {
        throw new \RuntimeException('Unknown route');
    }
    $type = (empty($args['type'])) ? 'main' : $args['type'];
    if (!in_array($type, ['main', 'book', 'mark'])) {
        throw new \RuntimeException('Unknown route ' . $type);
    }
    $this->logger->info("Slim-Skeleton '/$lang/$type' route");

    // Render index view
    /** @var  $books */
    $books = file_get_contents('templates/_books.phtml');
    $navigation = file_get_contents('templates/_navigation.phtml');
    $contents = file_get_contents("contents/{$lang}_{$type}.php");
    $params = [
        'books' => $books,
        'navigation' => $navigation,
        'contents' => $contents,
    ];

    return $this->renderer->render($response, "template.phtml", $params);
});
