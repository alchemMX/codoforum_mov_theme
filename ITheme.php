<?php

/*
@CODOLICENSE
*/

interface ITheme {

    /**
     * Adds all required javascript libraries that are common.
     * Page specific javascripts are defined in respective controllers
     * @return mixed
     */
    function addCommonJs();

    /**
     * Adds all global less files
     * @return mixed
     */
    function addCommonCss();

    /**
     * Adds page specific less files defined in controller
     * @param $pageCssFiles
     * @param $themesByInheritance
     * @return mixed
     */
    function addPageSpecificCss($pageCssFiles, $themesByInheritance);

    /**
     * Adds custom css files: colors.less
     * @param $themesByInheritance
     * @return mixed
     */
    function addColorDefinitions($themesByInheritance);

    /**
     * Adds any common deferred js files
     * @return mixed
     */
    function addDeferredJs();

    /**
     * Adds any page specific js files defined in controller
     * @return mixed
     */
    function addPageSpecificJs($pageJsFiles);
}