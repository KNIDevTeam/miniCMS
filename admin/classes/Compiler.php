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
            switch($value['type'])
            {
                case "paragraph":
                    $pageHTML .= $this->compileParagraph($value['data']);
                    break;
                case "header":
                    $pageHTML .= $this->compileHeader($value['data']);
                    break;
                case "list":
                    $pageHTML .= $this->compileList($value['data']);
                    break;
                case "checklist":
                    $pageHTML .= $this->compileChecklist($value['data']);
                    break;
                case "quote":
                    $pageHTML .= $this->compileQuote($value['data']);
                    break;
                case "warning":
                    $pageHTML .= $this->compileWarning($value['data']);
                    break;
                case "code":
                    $pageHTML .= $this->compileCode($value['data']);
                    break;
                case "delimiter":
                    $pageHTML .= $this->compileDelimiter($value['data']);
                    break;
                case "linkTool":
                    $pageHTML .= $this->compileLinkTool($value['data']);
                    break;
                case "table":
                    $pageHTML .= $this->compileTable($value['data']);
                    break;
            }
        }
        $pageHTML .= "</html>";
        return $pageHTML;
    }

    private function compileParagraph($elementData)
    {
        $elementHTML = "<p>" . $elementData['text'] . "</p>";
        return $elementHTML;
    }

    private function compileHeader($elementData)
    {

    }

    private function compileList($elementData)
    {

    }

    private function compileChecklist($elementData)
    {

    }

    private function compileQuote($elementData)
    {

    }

    private function compileWarning($elementData)
    {

    }

    private function compileCode($elementData)
    {

    }

    private function compileDelimiter($elementData)
    {

    }

    private function compileLinkTool($elementData)
    {

    }

    private function compileTable($elementData)
    {

    }
}