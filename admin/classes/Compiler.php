<?php

namespace Admin\Classes;

class Compiler
{
    public function compilePage($pageContent)
    {
        $pageJSON = json_decode($pageContent, true);
        $pageHTML = "<html>";
        foreach($pageJSON['blocks'] as $key => $value)
        {
            $methodName = 'compile'. ucfirst($value['type']);

            if (method_exists($this, $methodName))
                $pageHTML .= $this->$methodName($value['data']);
            else
                $pageHTML .= $value['type']." NOT SUPPORTED<br>";
        }
        $pageHTML .= "</html>";
        return $pageHTML;
    }

    private function compileParagraph($elementData)
    {
        $elementHTML = "<p class=\"editor__paragraph\">" . $elementData['text'] . "</p>";
        return $elementHTML;
    }

    private function compileHeader($elementData)
    {
        $headerLevel = "h" . $elementData['level'];
        $elementHTML = "<{$headerLevel} class=\"editor__header_{$headerLevel}\">" . $elementData['text'] . "</{$headerLevel}>";
        return $elementHTML;
    }

    private function compileList($elementData)
    {
        if($elementData['style'] == "unordered") $listType = "ul";
        else $listType = "ol";
        $elementHTML = "<{$listType} class=\"editor__list\">";
        foreach($elementData['items'] as $key => $value)
        {
            $elementHTML .= "<li>" . $value . "</li>";
        }
        $elementHTML .= "</{$listType}>";
        return $elementHTML;
    }

    private function compileChecklist($elementData)
    {
        $listType = "ul";
        $elementHTML = "<{$listType}> class=\"editor__checklist\">";
        foreach($elementData['items'] as $key => $value)
        {
            $elementHTML .= "<li>";
            if($value['checked']) $elementHTML .= "<s>";
            $elementHTML .= $value['text'];
            if($value['checked']) $elementHTML .= "</s>";
            $elementHTML .= "</li>";
        }
        $elementHTML .= "</{$listType}>";
        return $elementHTML;
    }

    private function compileWarning($elementData)
    {
        return "<div class=\"editor__warning\"><div class=\"editor__warning_title\">".$elementData['title']."</div>"."<div class=\"editor__warning_message\">".$elementData['message']."</div></div></div>";
    }

    private function compileCode($elementData)
    {
        return "<code class=\"editor__code\">".$elementData['code']."</code>";
    }

    private function compileDelimiter($elementData)
    {
        return "<div class=\"editor__delimiter\"></div>";
    }

    private function compileTable($elementData)
    {
        $elementHTML = "<table class=\"editor__table\">";
        foreach($elementData['content'] as $key1 => $value1)
        {
            $elementHTML .= "<tr>";
            foreach($value1 as $key2 => $value2)
            {
                $elementHTML .= "<td>" . $value2 . "</td>";
            }
            $elementHTML .= "</tr>";
        }
        return $elementHTML;
    }

    private function compileAttaches($elementData)
    {
        return '<div class="attache"><a href="'.$elementData['file']['url'].'" target="_blank">'.$elementData['title'].' (Pobierz)</a></div>';
    }

    private function compileImage($elementData)
    {
        return '<div class="image"><img src="'.$elementData['file']['url'].'" class="'.($elementData['withBorder'] ? 'withBorder ' : '').($elementData['withBackground'] ? 'withBackground ' : '').($elementData['stretched'] ? 'stretched ' : '').'" alt="'.$elementData['caption'].'"><h3>'.$elementData['caption'].'</h3></div>';
    }
}