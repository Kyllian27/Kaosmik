<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $session;
    protected $start_session = true;

    protected array $messages = [];

    protected $title = "";
    protected $title_suffix = "Zoologik";
    protected $description = "";
    protected $author = "";
    protected $keywords = "";
    protected $current_menu = "";
    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        if ($this->start_session) {
            $this->session = session();
            if (session()->has('messages')) {
                $this->messages = session()->getFlashdata('messages');
            }
        }
    }

    public function render($view = null, $datas = [], $options = []) {
        $flashData = session()->getFlashdata('data');
        if ($flashData) {
            $datas = array_merge($datas, $flashData);
        }

        $headData = [
            'title' => sprintf("%s : %s", $this->title, $this->title_suffix),
            'description' => $this->description,
            'author' => $this->author,
            'keywords' => $this->keywords,
            'menus' => $this->loadMenu(),
            'current_menu' => $this->current_menu,
            'user' => auth()->user(),
        ];

        return view('template/head', $headData)
            .view($view, $datas,$options)
            .view('template/footer', ['messages' => $this->messages]);
    }

    protected function loadMenu() {
        $filename = APPPATH . "Config";
        $filename .= "/menu.json";

        if(!file_exists($filename)) {
            log_message("error", "Menu file not found");
            return [];
        }

        $json = file_get_contents($filename);
        $menu = json_decode($json, true);

        if (!is_array($menu)) {
            log_message("error", "Menu json is not an array : " . $filename);
            return [];
        }

        return $menu;
    }

    public function redirect(string $url, array $data = [])
    {
        // Ajout des messages à la session si présents
        if (!empty($this->messages)) {
            session()->setFlashdata('messages', $this->messages);
        }

        // Ajout des données supplémentaires à la session si présentes
        if (!empty($data)) {
            session()->setFlashdata('data', $data);
        }

        // Redirection avec la méthode CI4
        return redirect()->to(base_url($url));
    }

    /**
     * Ajoute un message de succès
     * @param string $txt Message à afficher
     * @return void
     */
    public function success($txt) {
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-success', 'type' => 'success'];
    }

    /**
     * Ajoute un message informatif
     * @param string $txt Message à afficher
     * @return void
     */
    public function message($txt){
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-info', 'type' => 'info'];
    }

    /**
     * Ajout d'un message d'avertissement
     * @param string $txt Message à afficher
     * @return void
     */
    public function warning($txt){
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-warning', 'type' => 'warning'];
    }

    /**
     * Ajout d'un message d'erreur
     * @param string $txt Message à afficher
     * @return void
     */
    public function error($txt){
        $this->messages[] = ['txt' => $txt, 'class' => 'alert-danger', 'type' => 'error'];
    }
}
