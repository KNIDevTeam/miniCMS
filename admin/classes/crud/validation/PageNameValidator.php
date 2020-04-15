<?php

namespace Admin\Classes\crud\validation;
use admin\classes\crud\validation\PageValidatorInterface;
use admin\classes\Validator;

class PageNameValidator implements PageValidatorInterface
{
    private $errors = [];
    private $lastCheck;
    public function validate($pageName, $template, $pageParent, $pagesRepo, $templatesRepo)
    {
        $validator = new Validator(['name' => $pageName, 'template' => $template, 'parent' => $pageParent],
            ['name' => 'required|maxLength:15', 'template' => 'required', 'parent' => 'required']);
        $this->lastCheck = $validator->validate();
        foreach($validator->getErrors() as $value)
        {
            foreach ($value as $errormess) array_push($this->errors, $errormess['error']." ");
        }
        $this->validateNameIfExist($pageName, $pagesRepo);
        $this->validateTemplateIfExist($template, $templatesRepo);
        $this->validateParentIfExist($pageParent, $pagesRepo);
        $this->validatePageNameCharacters($pageName);
        //TODO forbide to name page none bo będzie przyps
        return $this->lastCheck;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validateNameIfExist($name, $pagesRepo)
    {
        $errmesg = "Strona o podanej nazwie już istnieje";
        if(in_array($name, $pagesRepo->getPagesNamesList()))
        {
            array_push($this->errors, $errmesg);
            $this->lastCheck = false;
        }
    }

    private function validateTemplateIfExist($templateName, $templatesRepo)
    {
        $errmesg = "Template o podanej nazwie nie istnieje";
        if(!in_array($templateName, $templatesRepo->ListTemplatesNames()))
        {
            array_push($this->errors, $errmesg);
            $this->lastCheck = false;
        }
    }

    private function validateParentIfExist($name, $pagesRepo)
    {
        $errmesg = "Strona podana jako rodzic nie istnieje";
        $listOfPages = $pagesRepo->getPagesNamesList();
        array_push($listOfPages, "none");
        if(!in_array($name, $listOfPages))
        {
            array_push($this->errors, $errmesg);
            $this->lastCheck = false;
        }
    }

    private function validatePageNameCharacters($name)
    {
        $errmesg = "Nazwa strony może zawierać tylko wielkie i małe litery, cyfry oraz spacje";
        $allowedCharacters = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM 1234567890śćżźółąęŚĆŹŻÓĄĘŁ";
        foreach(str_split($name) as $letter)
        {
            if(!in_array($letter, str_split($allowedCharacters)))
            {
                array_push($this->errors, $errmesg);
                $this->lastCheck = false;
            }
        }
    }

}