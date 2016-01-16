<?php
namespace App\Shell\Task;

use Bake\Shell\Task\SimpleBakeTask;

class FooTask extends SimpleBakeTask
{
    public $pathFragment = 'Foo/';

    public function name()
    {
        return 'foo';
    }

    public function fileName($name)
    {
        return $name . 'Foo.php';
    }

    public function template()
    {
        return 'foo';
    }

}