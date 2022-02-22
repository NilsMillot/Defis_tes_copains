<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ViteAssetExtension extends AbstractExtension {

    private bool $isDev;
    private string $manifest;

    public function __construct(bool $isDev, string $manifest)
    {
        $this->isDev = $isDev;
        $this->manifest = $manifest;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('vite_asset', [$this, 'asset'], ['is_safe' => ['html']])
        ];
    }

    public function asset(string $entry, array $deps): string {
        if($this->isDev){
             return $this->assetDev($entry, $deps);
        }
        return $this->assetProd($entry);
    }

    public function assetDev(string $entry, array $deps): string {
        $html =  <<<HTML
            <script type="module" src="http://localhost:3000/assets/@vite/client"></script>
            HTML;
        if(in_array('react', $deps)){
            $html .= '<script type="module">
                import RefreshRuntime from "http://localhost:3000/assets/@react-refresh"
                RefreshRuntime.injectIntoGlobalHook(window)
                window.$RefreshReg$ = () => {}
                window.$RefreshSig$ = () => (type) => type
                window.__vite_plugin_react_preamble_installed__ = true
            </script>';
        }
        dump($entry);
        $html .= <<<HTML
            <script type="module" src="http://localhost:3000/assets/{$entry}" defer></script> 
            HTML;
        return $html;
    }

    public function assetProd(string $entry): string {
        $data = json_decode(file_get_contents($this->manifest), true);
        dump('reading json');
        $file = $data[$entry]['file'];
        $css = $data[$entry]['css'] ?? [];
        $html = <<<HTML
            <script type="module" src="/assets/{$file}" defer></script>
            HTML;
        foreach ($css as $cssFile){
            $html .= <<<HTML
            <link rel="stylesheet" media="screen" href="/assets/{$cssFile}">
            HTML;
        }
        return $html;
    }
}