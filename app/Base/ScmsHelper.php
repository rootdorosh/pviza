<?php

namespace App\Base;

use Illuminate\Support\Arr;
use Cache;

/**
 * Class ScmsHelper.
 */
class ScmsHelper
{
    const TAG = 'scms';

    /**
     * Get tag
     *
     * @return array
     */
    public static function getTag() : string
    {
        return config('app.name') .  self::TAG;
    }

    /**
     * Get modules
     *
     * @return array
     */
    public static function getModules() : array
    {
        return Cache::tags(self::getTag())->remember(self::getTag() . '_getModules_', 60*60*24, function() {
            $skip = ['.', '..'];
            $modules = [];

            $path = app_path() . '/Modules';
            $files = scandir($path);
            foreach ($files as $module) {
                if (!in_array($module, $skip) && is_dir($path . '/' . $module)) {
                    $modules[] = $module;
                }
            }

            return $modules;
        });
    }

    /**
     * Get widgets
     *
     * @return array
     */
    public static function getWidgets() : array
    {
        //return Cache::tags(self::getTag())->remember(self::getTag() . '_getWidgets_', 60*60*24, function() {
            $widgets = [];

            foreach (self::getModules() as $module) {
                $file = app_path() . '/Modules/' . $module . '/Front/Widget.php';

                if (is_file($file)) {
                     $widgets[] = self::getWidgetInfo($module);
                }
            }

            return $widgets;
        //});
    }

    /*
     * @param string $module
     * @return array
     */
    public static function getWidgetInfo(string $module): array
    {
        $widgetNamespace = self::getWidgetNamespace($module);
        $widgetObject = new $widgetNamespace;

        return [
            'id' => $module,
            'name' => $widgetObject->getName(),
            'config' => $widgetObject->getConfig(),
        ];
    }

    /*
     * @param string $id
     * @return string
     */
    public static function getWidgetNamespace(string $id): string
    {
        return $widgetNamespace = "\App\Modules\\$id\Front\Widget";
    }

    /*
     * @param string $widgetId
     * @return WidgetBase
     */
    public static function getWidgetInstance(string $widgetId): WidgetBase
    {
        $namespace = self::getWidgetNamespace($widgetId);
        return new $namespace;
    }


    /**
     * Get widgets
     *
     * @return array
     */
    public static function getWidgetsIds() : array
    {
        return Arr::pluck(self::getWidgets(), 'id');
    }

    /**
     * Get widgets
     *
     * @return array
     */
    public static function getFrontRoutes() : array
    {
        return Cache::tags(self::getTag())->remember(self::getTag() . '_getFrontRoutes_', 60*60*24, function() {
            $routes = [];

            foreach (self::getModules() as $module) {
                $file = app_path() . '/Modules/' . $module . '/Front/routes.php';

                if (is_file($file)) {
                    foreach (require $file as $item) {
                        $routes[] = $item;
                    }
                }
            }

            usort ($routes, "sortArrayRankAsc");

            return $routes;
        });
    }

     /**
     * Get side menu
     *
     * @return array
     */
    public static function getMenu() : array
    {
        $items = Cache::tags(self::getTag())->remember(self::getTag() . '_getMenu_', 60*60*24, function() {
            $items = [];

            foreach (self::getModules() as $module) {
                $file = app_path() . '/Modules/' . $module . '/Config/menu.php';

                if (is_file($file)) {
                    $items = array_merge($items, require $file);
                }
            }

            return $items;
        });

        $arrDot = array_dot($items);
        $arrDot = array_map(function($value){
             return substr_count($value, '::') ? __($value) : $value;
        }, $arrDot);

        return array_to_tree_by_keys($arrDot);
    }


}
