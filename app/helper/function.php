<?php
use App\Models\Material;

function getCategories($categories, $old = '', $parentId = 0, $char = '')
{
    $id = request()->route()->category;
    if ($categories) {
        foreach ($categories as $key => $category) {
            if ($category->parent_id == $parentId && $id != $category->id) {

                echo '<option value="' . $category->id . '"';
                if ($old == $category->id) {
                    echo 'selected';
                }
                echo '>' . $char . $category->name . '</option>';
                unset($categories[$key]);
                getCategories($categories, $old, $category->id, $char . '|-');
            }
        }
    }
}


function getMaterialName($id)
{
    $material = Material::find($id);
    if ($material) {
        return $material->name;
    }
    return "Mater not found";
}



use App\Models\Admin;

function isAdminActive($email)
{
    $count = Admin::where('email', $email)->where('is_active', '=', '1')->count();
    if ($count) {
        return true;
    }
    return false;
}

if (!function_exists('convert_array')) {
    function convert_array($system = null, $keyword = '', $value = '')
    {
        $temp = [];
        if (is_array($system)) {
            foreach ($system as $key => $val) {
                $temp[$val[$keyword]] = $val[$value];
            }
        }
        if (is_object($system)) {
            foreach ($system as $key => $val) {
                $temp[$val->{$keyword}] = $val->{$value};
            }
        }
        return $temp;
    }
}
if (!function_exists('renderSystemInput')) {
    function renderSystemInput(string $name = '', $type = 'text', $system = null)
    {
        return ' <input type="' . $type . '"
        name="config[' . $name . ']"
        value=" ' . old($name, (isset($system[$name])) ? $system[$name] : "") . '"
        class="form-control"
        placeholder="" >';
    }
}
if (!function_exists('renderSystemTextarea')) {
    function renderSystemTextarea(string $name = '', $system = null)
    {
        return '<textarea name="config[' . $name . ']" value="" class="form-control">'
            . old($name, (isset($system[$name])) ? $system[$name]
                : "") . '</textarea>';
    }
}
if (!function_exists('renderSystemSelect')) {
    function renderSystemSelect($items, string $name = '', $system = null)
    {
        $html = '<select name="config[' . $name . ']" class="form-control">';

        foreach ($items as $key => $item) {
            $html .= '<option ' . (old($name, (isset($system[$name])) ? $system[$name] : "")) ? "select" : '' . ' value=' . $key . '>' . $key . '</option>';
        }

        $html .= '</select>';
        return $html;
    }
}

