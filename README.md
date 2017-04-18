[![Build Status](https://travis-ci.org/mehulkaklotar/wp-nonce.svg?branch=master)](https://travis-ci.org/mehulkaklotar/wp-nonce)

WPNonce
===================

WordPress Nonce In An Object Oriented Way.

## Basic Usage

1. Create a demo `composer.json` file in your plugin.
2. Run `composer install`
3. It will load plugin dependency in a `vendor/` folder

### demo `composer.json`

```
{
    "repositories": [
        {
            "type": "vcs",
            "url" : "https://github.com/mehulkaklotar/wp-nonce"
        }
    ],
    "require": {
        "mehulkaklotar/wp-nonce" : "1.0.*"
    }
}
```

Here I have created a demo plugin to use this system. [WP Nonce Client](https://github.com/mehulkaklotar/wp-nonce-client)

### The Configuration:

WP Nonce need an action to find the current action which is secured by a nonce. The first parameter of the configuration defines this name. Usually forms or URLs passes the nonce. The second parameter is for request key. In this case, we would expect the nonce to be in `$_REQUEST['request_name']`.

```
$configuration = new NonceConfig( 
	'action', 
	'request_name' 
);
```


### To Create a Nonce
To create a simple Nonce, use `NonceCreate`:
```
$nonce_create = new NonceCreate( $configuration );
$nonce = $nonce_create->create();
```

To add a nonce to an URL, you can use

```
$nonce_create = new NonceCreateURL( $configuration );
$url = $nonce_create->create_url( 'http://example.com/' );
```
Return URL will be:
`http://example.com/?request_name=$nonce`

To add a form field:
```
$create = new NonceCreateField( $configuration );
$field = $create->create_field();
```
Return field will be:
`<input type="hidden" name="request_name" value="$nonce">`

Replicate `wp_nonce_field()` functionality by adding two parameters: `(bool) $referer` and `(bool) $echo`. Both are set to `false` by default. 

Set `$referer` to `true`, field will be appended with the URL of the current page. 
Set `$echo` to `true`, it will echo the field, before `create_url()`.

### To Verify a Nonce

To verify a nonce, you can use `NonceVerify`:
```
$nonce_verify = new NonceVerify( $configuration );
$is_valid = $nonce_verify->verify( $nonce );
```