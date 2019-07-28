Lazy Response Bundle
=====================

I prefer to handle response type outside of Symfony controllers and return DTOs instead which are transformed into their corresponding responses afterwards. Some of the very standard DTOs and `kernel.view` event handlers are in this library.

Installation
-------------

```bash
composer req basster/lazy-response-bundle
```

If you are using [Symfony Flex](https://flex.symfony.com/) you are done here, otherwise add the following lines to your `services.yaml`:

```yaml
services:
    _defaults:
        # make sure autowire and autoconfigure are activated
        autowire: true      
        autoconfigure: true
    
    Basster\LazyResponseBundle\Response\Handler\TwigResponseHandler: ~
    Basster\LazyResponseBundle\Response\Handler\RedirectResponseHandler: ~
    Basster\LazyResponseBundle\Response\Handler\JsonSerializeResponseHandler: ~
```

Usage
-----

I prefer pure Symfony controllers without extending the `Symfony\Bundle\FrameworkBundle\Controller\AbstractController`, using proper Dependency Injection to get the services I want to use. I also liked the idea of the `@Template` annotation, so controllers return data, no responses. But sometimes, that comes with a drawback: If you want to attach proper typehints to your controller actions. E.g. if you handle a form in an action, you return either view model as array or a `RedirectResponse` after successful form handling. Downside: Those "return types" have nothing in common.

Here is my approach:

```php
<?php 
use Basster\LazyResponseBundle\Response\LazyResponseInterface;
use Basster\LazyResponseBundle\Response\RedirectResponse;
use Basster\LazyResponseBundle\Response\TemplateResponse;

class MyController {
    public function commentNew(Request $request, FormFactoryInterface $formFactory): LazyResponseInterface
    {
        $post = new Post();
    
        $form = $formFactory->create(PostType::class, $post);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // do stuff with the submitted data
            return new RedirectResponse('post_index'); // will end up in a RedirectResponse
        }
        
        return new TemplateResponse('post/new.html.twig',[
            'post' => $post,
            'form' => $form->createView(),
        ]); // will end up in a regular Response with contents of the rendered template.
    }
}
```

LazyResponseInterface
---------------------

The `Basster\LazyResponseBundle\Response\LazyResponseInterface` is just a marking interface to be shared by multiple DTOs. Currently there are the following standard DTOs:

* `Basster\LazyResponseBundle\Response\JsonSerializeResponse`
* `Basster\LazyResponseBundle\Response\RedirectResponse`
* `Basster\LazyResponseBundle\Response\TemplateResponse`

The response DTOs are framework agnostic and can be used wherever you want!

LazyResponseHandlers
--------------------

The handlers, that come with this library, are Symfony `kernel.view` event subscriber transforming the DTOs into Symfony response objects:

* `Basster\LazyResponseBundle\Response\Handler\JsonSerializeResponseHandler` handles `JsonSerializeResponse` and utilizes the Symfony serializer.
* `Basster\LazyResponseBundle\Response\Handler\RedirectResponseHandler` handles `RedirectResponse` and utilizes the Symfony router.
* `Basster\LazyResponseBundle\Response\Handler\TwigResponseHandler` handles `TemplateResponse` utilizes Twig (doh!). 
