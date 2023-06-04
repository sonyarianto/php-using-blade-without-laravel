# php-using-blade-without-laravel
Sample of using Blade template system on PHP without using Laravel.

## How to run?

Just use PHP built-in web server. Run this on this project directory.

```
php -S localhost:3000 -t public
```

## How to look into code?
- Look at `public/index.php`, that's the entry point.
- Look at `src/Blade.php`, that's the class of Blade that prepare when constructor run and has `render()` function to render the template.
- Look at `src/Config.php`, contains some config need for Blade, such as templates directory and target directory of compiled templates.

## License

MIT

Maintained by Sony Arianto Kurniawan <<sony@sony-ak.com>> and contributors.
