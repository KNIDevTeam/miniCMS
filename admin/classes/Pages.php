<?php

namespace Admin\Classes;


class Pages
{
    public function createPage($pageName, $pageParent, $pageTemplate)
    {
        //if(!checkName($pageName)) return false;
        //if(!checkPath($pagePath)) return false;
        //if(!checkTemplate($pageTemplate)) return false;
        echo ABS_PATH.'\admin\assets\editor\templates'.'<br>';
        //echo $pageName;
        //echo "'". ABS_PATH . "/content/pages/" . $pageName . "'";
        $template = new Templates();
        foreach ($template->templateList as $template)
            echo $template.'<br>';
        return true;
    }
}
