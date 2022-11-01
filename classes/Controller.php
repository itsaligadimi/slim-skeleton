<?php


namespace App;


use Psr\Container\ContainerInterface;

class Controller
{
    protected $container;
    protected $view;
    protected $request;
    protected $response;
    protected $args;
    protected $router;

    protected $outputVars = [];

    protected $id;
    protected $page_num;
    protected $per_page;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get("view");
        $this->router = $container->get('router');
    }

    public function __invoke($request, $response, $args)
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        $this->getContent();

        return $this->response;
    }

    protected function redirect($url, $status = 302)
    {
        $this->response = $this->response->withHeader('Location', $url)->withStatus($status);
    }

    protected function isArgSet($key)
    {
        return isset($this->args[$key]);
    }

    protected function getArg($key)
    {
        return $this->args[$key];
    }

    protected function fetch($layout, $args = [])
    {
        return $this->view->fetch($layout, $args);
    }

    protected function isParamSet($key)
    {
        return array_key_exists($key, $this->request->getQueryParams());
    }

    protected function getParam($key, $default = null)
    {
        if ($this->isParamSet($key)) {
            return $this->request->getParam($key);
        }
        return $default;
    }

    protected function getParamInt($key, $default = null)
    {
        $output = null;
        if ($this->isParamSet($key)) {
            $output = $this->request->getParam($key);
        }
        else {
            $output = $default;
        }

        if ($output != null) {
            try {
                $output = (int)$output;
            } catch (\Exception $ignored) {
            }
        }

        return $output;
    }

    protected function render($layout)
    {
        $this->response->getBody()->write(
            $this->fetch(
                $layout,
                $this->outputVars
            )
        );
    }

    protected function assignVar($args, $value = null)
    {
        if (empty($args)) {
            return;
        }

        if (is_array($args)) {
            $this->outputVars = array_merge($this->outputVars, $args);
        }
        else {
            $this->outputVars[$args] = $value;
        }
    }

    public function getContent()
    {
        $this->page_num = $this->getParamInt('p');
        $this->per_page = $this->getParamInt('pp');
//        $total_items = $this->getTotalCount();
//        $total_pages = $total_items / $this->per_page

        $this->assignVar([
            'home_url' => $this->router->pathFor('home'),
            'menu_items' => [
                [
                    'title' => "GPU Database",
                    'url' => $this->router->pathFor("gpudb"),
                ],
                [
                    'title' => "Graphic Card Database",
                    'url' => $this->router->pathFor("gcdb"),
                ],
                [
                    'title' => "Bios Database",
                    'url' => $this->router->pathFor("biosdb"),
                ]
            ],
            'theme_dir' => '/' . _BASE_DIR_ . _THEME_DIR_,
            'page_num' => $this->page_num,
            'per_page' => $this->per_page,
//            'total_page' =>
        ]);
    }

    public function _404()
    {
        $this->render('404.twig');
        $this->response = $this->response->withStatus(404);
    }


    protected function getTotalCount()
    {
        return null;
    }
}