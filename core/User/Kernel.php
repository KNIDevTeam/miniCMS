<?php

namespace Core\User;

use Core\Exceptions\NotFoundException;
use Core\Response;
use Core\ThemeManager;

class Kernel
{
    private $lang;
    private $request;

    /**
     * Kernel constructor.
     *
     * @param $lang
     * @param $request
     */
    public function __construct($lang, $request)
    {
        $this->lang = $lang;
        $this->request = $request;
    }

    /**
     * Execute request.
     *
     * @return Response
     *
     * @throws NotFoundException
     */
    public function execute()
    {
        if ($this->request->path == '')
           return (new Response())->redirect('Home');

        if (MULTI_LANG && $this->request->method == 'get' && $this->request->path == '_language_switcher') {
            $this->switchLang();
            return (new Response())->redirect();
        }

        $themeManager = new ThemeManager();
        $themeManager->setLang($this->lang);
        $pagesManager = new PagesManager($this->request->path);
        $themeManager->addBlock('menu', $pagesManager->getMenu());

        if ($pagesManager->pageExists()) {
            $themeManager->addBlock('title', $pagesManager->getCurrentPage()['title']);
            $themeManager->addBlock('content', $pagesManager->getCurrentPage()['content']);
            return new Response($themeManager->render());
        } else
            throw new NotFoundException();
    }

    /**
     * Switch language.
     */
    private function switchLang()
    {
        $_SESSION['lang'] = $this->request->queryString['lang'];
    }
}