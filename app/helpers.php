<?php

function d_l($path, $lang = null)
{
	$locale = $lang ? $lang : app()->getLocale();
	$url = sprintf('/%s/%s/', $locale, trim($path, '/'));
    $url = str_replace('//', '/', $url);
    
    return $url;
}


function switchUrl(string $url, string $lang = null)
{
    //по-умолчанию возвращаем текущий урл
    $result = $url;

    if (!$lang) // по умолчанию используем текущий язык сайта
        $lang = app()->getLocale();

    if (!empty($url) && !empty($lang)) {

        //разбиваем урл на составные части
        $uriParts = explode('/', trim($url, '/'));
        if (is_array($uriParts) && count($uriParts)) {

            //берем первый элемент урла и проверяем его на наличие языкового параметра
            $firstItem = $uriParts[0];
            if (in_array($firstItem, config('translatable.locales'))) {
                //если он действительно языковый параметр - уничтожаем его
                unset($uriParts[0]);
            }
        }

        //если указанный язык не входит в список допустимых, то используем текущий язык
        if (!in_array($lang, config('translatable.locales'))) {
            $lang = app()->getLocale();
        }

        //формируем ссылку с новым языковым параметром
        $buildUrl = implode('/', $uriParts);
        $result = sprintf('/%s/%s', $lang, $buildUrl);
        if (!empty($buildUrl) && strpos($result, '?') === false) { // если нет get'а, добавляем слеш в конец ссылки
            $result .= '/';
        }
    }


    return $result;
}


if (! function_exists('l')) {
    /*
     * @return string
     */
    function l(): string {
        return \App::getLocale();
    }
}

if (! function_exists('t')) {
    /*
     * @param string $slug
     * @param array $params
     * @return string $slug
     */
    function t(string $slug, array $params = []): string 
    {
        return (new App\Modules\Translation\Services\Fetch\TranslationFetchService)->get($slug, $params);
    }
}

if (! function_exists('phoneToInt')) {
    /*
     * @param string|null $phone
     * @return string
     */
    function phoneToInt(string $phone = null): string 
    {
        return str_replace(['+', ' ', '(', ')'], '', $phone);
    }
}

if (! function_exists('conf')) {
    /*
     * @param string $key
     * @return mixed
     */
    function conf(string $key) 
    {
        return Setting::get($key);
    }
}

/*
*  @param array   $array
 * @param string  $delimiter
 * @param boolean $baseval
 *
 * @return array
 */
function array_to_tree_by_keys($array, $delimiter = '.', $baseval = false)
{
	if(!is_array($array)) return false;
	$splitRE   = '/' . preg_quote($delimiter, '/') . '/';
	$returnArr = array();
	foreach ($array as $key => $val) {
		// Get parent parts and the current leaf
		$parts	= preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
		$leafPart = array_pop($parts);

		// Build parent structure
		// Might be slow for really deep and large structures
		$parentArr = &$returnArr;
		foreach ($parts as $part) {
			if (!isset($parentArr[$part])) {
				$parentArr[$part] = array();
			} elseif (!is_array($parentArr[$part])) {
				if ($baseval) {
					$parentArr[$part] = array('__base_val' => $parentArr[$part]);
				} else {
					$parentArr[$part] = array();
				}
			}
			$parentArr = &$parentArr[$part];
		}

		// Add the final part to the structure
		if (empty($parentArr[$leafPart])) {
			$parentArr[$leafPart] = $val;
		} elseif ($baseval && is_array($parentArr[$leafPart])) {
			$parentArr[$leafPart]['__base_val'] = $val;
		}
	}
	return $returnArr;
}

function rmDirRecursive($path) {
    $path = str_replace('//', '/', $path);
    $files = glob($path . '/*');
	foreach ($files as $file) {
		is_dir($file) ? rmDirRecursive($file) : unlink($file);
	}
	rmdir($path);
	return;
}

function datetime_to_ui($time) {
  	return date('Y-m-d', $time) . 'T' . date('H:i:s', $time) . '.000Z';
}