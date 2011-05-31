<?php

function __autoload($class) {
    is_file($file = './lib/' . strtr($class, '_', '/') . '.php') && require_once $file;
}

echo '<pre>';

$parser        = new Parser;
$prettyPrinter = new PrettyPrinter_Zend;
$nodeDumper    = new NodeDumper;

// Output Demo
$stmts = $parser->parse(new Lexer(
    '<?php
        x::$y[z];
        $x->y[z];
        $x->y[z][k]->l()->m[t];
        $x->y[z]();
        $x->$y[z]();
        $x->$$y[z]();'
    ),
    function ($msg) {
        echo $msg;
    }
);

if (false !== $stmts) {
    echo htmlspecialchars($nodeDumper->dump($stmts));
}

echo "\n\n";

$code = $prettyPrinter->pStmts(
    $parser->parse(
        new Lexer(file_get_contents(
            '../symfonySandbox\src\vendor\symfony\src\Symfony\Components\Console\Input\InputDefinition.php'
        )),
        function ($msg) {
            echo $msg;
        }
    )
);

echo htmlspecialchars($code);