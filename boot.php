<?php

/** @var rex_addon $this */

$this->setProperty('author', 'Joachim Doerr');

// Addonrechte (permissions) registieren
//if (rex::isBackend() && is_object(rex::getUser())) {
//    rex_perm::register('urlreplace[]');
//    rex_perm::register('urlreplace[config]');
//}

// if anything changes -> refresh PathFile
if (rex::isBackend()) {
    $extensionPoints = [
        'CAT_ADDED', 'CAT_UPDATED', 'CAT_DELETED', 'CAT_STATUS',
        'ART_ADDED', 'ART_UPDATED', 'ART_DELETED', 'ART_STATUS',
        /*'CLANG_ADDED',*/
        'CLANG_UPDATED', /*'CLANG_DELETED',*/
        /*'ARTICLE_GENERATED'*/
        'ALL_GENERATED'
    ];
    foreach ($extensionPoints as $extensionPoint) {
        rex_extension::register($extensionPoint, function (rex_extension_point $ep) {
            $params = $ep->getParams();
            $params['subject'] = $ep->getSubject();
            $params['extension_point'] = $ep->getName();

            $replacer = new urlReplacer();
            $replacer->generate($params);
        });
    }
}

rex_extension::register('URL_REWRITE', function (rex_extension_point $ep) {
    $params = $ep->getParams();
    $params['subject'] = $ep->getSubject();

    $replacer = new urlReplacer();
    return $replacer->replace($params);
});
