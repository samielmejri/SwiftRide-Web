<?php

namespace App\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class Month extends FunctionNode
{
    public $date;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'MONTH(' . $this->date->dispatch($sqlWalker) . ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
    public function getMonthName(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return "MONTHNAME(" . $this->date->dispatch($sqlWalker) . ")";
    }
}

$config = new \Doctrine\ORM\Configuration();
$config->addCustomStringFunction('MONTH', 'Month');


