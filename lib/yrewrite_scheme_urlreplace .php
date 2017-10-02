<?php
class yrewrite_scheme_urlreplace extends rex_yrewrite_scheme
{
    protected $suffix = '/';

    public function getRedirection(rex_article $art, rex_yrewrite_domain $domain)
    {

        if ($art->isStartArticle() && ($cats = $art->getCategory()->getChildren(true)) && !rex_article_slice::getFirstSliceForCtype(1, $art->getId(), rex_clang::getCurrentId())) {
            return $cats[0];
        }

    return false;
    }
}