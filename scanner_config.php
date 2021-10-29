<?php
$projectPath = __DIR__ ;
//Declare directories which contains php code
$scanDirectories = [
    $projectPath . '/config/',
    $projectPath . '/src/',
    $projectPath . '/bin/',
];
return [
    'composerJsonPath' => $projectPath . '/composer.json',
    'vendorPath' => $projectPath . '/vendor/',
    'scanDirectories' => $scanDirectories
];