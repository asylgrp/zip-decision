<?php

namespace Bob\BuildConfig;

task('default', ['test', 'sniff']);

desc('Run unit tests and static analysis');
task('test', ['phpunit', 'phpstan']);

desc('Run phpunit tests');
task('phpunit', function() {
    sh('phpunit', null, ['failOnError' => true]);
    println('Phpunit tests passed');
});

desc('Run statical analysis using phpstan');
task('phpstan', function() {
    sh('phpstan analyze -l 7 src', null, ['failOnError' => true]);
    println('Phpstan analysis passed');
});

desc('Run php code sniffer');
task('sniff', function() {
    sh('phpcs src --standard=PSR2 --ignore=src/Loader/__set_state.php', null, ['failOnError' => true]);
    println('Syntax checker on src/ passed');
    sh('phpcs tests --standard=PSR2', null, ['failOnError' => true]);
    println('Syntax checker on tests/ passed');
});
