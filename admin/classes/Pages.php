<?php

namespace Admin\Classes;


class Pages
{
    public function createPage($pageName, $pageParent, $pageTemplate)
    {
        //if(!checkName($pageName)) return false;
        //if(!checkPath($pagePath)) return false;
        //if(!checkTemplate($pageTemplate)) return false;

        echo $pageName;
        echo "'". ABS_PATH . "/content/pages/" . $pageName . "'";


        return true;
    }
}
