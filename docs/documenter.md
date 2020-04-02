# Documenter

Compass documenter ships with [Documentarian](https://github.com/mpociot/documentarian) package by [Marcel Pociot](https://github.com/mpociot) that will be used to simply write beautiful API documentation. below is the example of how it looks like:

![Example of API documentation.](https://res.cloudinary.com/dave24hwj8/image/upload/v1585786513/example-of-api-documentation.png)

Yes, Documentarian is a PHP port of the popular [Slate](https://github.com/slatedocs/slate) API documentation tool.

### Build Documentation

When building documentation, you should run the `build` command:

```bash
php artisan compass:build
```

Next, you should be able to visit the results at `yourproject.test/docs/index.html` in your browser.

### Rebuild Documentation

You may rebuild documentation from existing markdown file, you should run the `rebuild` command:

```bash
php artisan compass:rebuild
```
