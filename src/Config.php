<?php
class Config {
    public static function get($key) {
        $config = [
            'pathsToTemplates' => [__DIR__ . '/../templates'],
            'pathToCompiledTemplates' => __DIR__ . '/../compiled_templates',
        ];
        return $config[$key];
    }
}