<?php
/**
 * Created by PhpStorm.
 * User: addequatte
 * Date: 06.05.18
 * Time: 1:10
 */

/**
 * @param $data
 * @return array
 */
function makeTree($data)
{
    foreach ($data as $item) {
        $sortResult[$item['parent_id']][] = $item;
    }

    return tree($sortResult);
}

/**
 * @param $items
 * @return string
 */
function drowTree($items)
{
    $t = "<ul>";
    foreach ($items as $item) {
        $t .= "<li>";
        $t .= $item['name'];
        if (isset($item['items'])) {
            $t .= drowTree($item['items']);
        }
        $t .= "</li>";
    }
    $t .= "</ul>";
    return $t;
}

/**
 * @param $sortResult
 * @param int $parent_id
 * @return array
 */
function tree($sortResult, $parent_id = 0)
{
    foreach ($sortResult[$parent_id] as $item) {
        if (array_key_exists($item['id'], $sortResult)) {
            $item['items'] = tree($sortResult, $item['id']);
        }
        $result[$item['id']] = $item;
    }
    return $result;
}

$data = json_decode(file_get_contents("data.json"),true);

$tree = makeTree($data);

$t = drowTree($tree);
file_put_contents('index.html', $t);
echo "done";