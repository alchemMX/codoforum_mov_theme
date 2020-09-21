<?php
/*
@CODOLICENSE
*/

/**
 * Loads all static assets - css & javascript
 * Class AssetLoader
 */

require_once 'ITheme.php';

class AssetLoader implements ITheme
{

    protected $asset;
    protected $headCollection;
    protected $bodyCollection;

    /**
     * Adds all required javascript libraries that are common.
     * Page specific javascripts are defined in respective controllers
     * @return mixed
     */
    function addCommonJs()
    {

        $this->headCollection->addJS('jquery-3.2.1.min.js', array('type' => 'defer'))
            ->addJS('popper.min.js', array('type' => 'defer'))
            ->addJS('bootstrap.min.js', array('type' => 'defer'))
            ->addJS('fastclick.js', array('type' => 'defer'))
            ->addJS('notify.js', array('type' => 'defer'))
            ->addJS('app.js', array('type' => 'defer'))
            ->addJS('jquery.mmenu.min.js', array('type' => 'defer'))
            ->addJS('jquery.mmenu.dragopen.min.js', array('type' => 'defer'))
            ->addJS('hammer.min.js', array('type' => 'defer'));
    }

    function addCommonCss()
    {
        $globalLessFiles = array('mixins', 'bootstrap', 'font-awesome', 'general', 'search', 'jquery.mmenu', 'jquery.mmenu.dragopen',
            'material-design');

        $path = DEF_THEME_DIR . 'less';

        foreach ($globalLessFiles as $file) {

            $this->headCollection->addCSS("$path/$file.less");
        }
    }

    /**
     * Adds page specific less files defined in controller
     * @param $pageCssFiles
     * @param $themesByInheritance
     */
    function addPageSpecificCss($pageCssFiles, $themesByInheritance)
    {
        if ($pageCssFiles == null) $pageCssFiles = array();
        foreach ($pageCssFiles as $file) {
            foreach ($themesByInheritance as $theme) {
                $this->headCollection->addCSS(THEME_DIR . "$theme/less/$file.less");
            }
        }
    }

    /**
     * Adds custom css files: colors.less
     * @param $themesByInheritance
     */
    function addColorDefinitions($themesByInheritance)
    {
        foreach ($themesByInheritance as $theme) {
            $this->headCollection->addCSS(THEME_DIR . "$theme/less/colors.less");
        }
    }

    /**
     * Adds any common deferred js files
     * @return mixed
     */
    function addDeferredJs()
    {
        $this->bodyCollection->addJS('handlebars-v1.1.2.js', array('type' => 'defer'));
    }

    /**
     * Adds any page specific js files defined in controller
     * @return mixed
     */
    function addPageSpecificJs($pageJsFiles)
    {
        if ($pageJsFiles === null) $pageJsFiles = array();
        foreach ($pageJsFiles as $js_file) {
            if (is_array($js_file)) {
                $this->bodyCollection->addJS($js_file[0], $js_file[1]);
            } else {
                $this->bodyCollection->addJS($js_file);
            }
        }
    }

    /**
     * Everything in constructor because all methods are always required
     * to be executed.
     * AssetLoader constructor.
     * @param $pageCssFiles
     * @param $pageJsFiles
     */
    function __construct($pageCssFiles, $pageJsFiles)
    {
        $this->asset = new CODOF\Asset\Stream();
        $this->headCollection = new \CODOF\Asset\Collection('head_col');
        $this->bodyCollection = new \CODOF\Asset\Collection('head_col');
        $this->bodyCollection->position = 'body';

        $themesByInheritance =  array_reverse(\CODOF\Util::getThemesByInhereitance());
        //Add everything that goes in head
        $this->addCommonJs();
        $this->addCommonCss();
        $this->addPageSpecificCss($pageCssFiles, $themesByInheritance);
        $this->addColorDefinitions($themesByInheritance);
        $this->asset->addCollection($this->headCollection);

        //Add everything that goes in body
        $this->addDeferredJs();
        $this->addPageSpecificJs($pageJsFiles);
        $this->asset->addCollection($this->bodyCollection);
    }
}