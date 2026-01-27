<?php

return [
    'ali' => [
        'appid' => '2021002158657413',
        'private_key' => 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCD3wrzRqG6xKVmrrrwnuU5tQ0cDOmXcZNUCVi6I/E39MGO4CDZZoAUajl629iNqXMwC6gR/7wyQnIKVXehh+0je0oxDA1XmbOEqM5MqWPjWbF/fNrnIDKG7LsrEpS55tqeCp8bY25xoXcdvZ0zkbuVSLDa0XXkSiZm1g5qscXsRS3eKcMih9l8w4Zfl9fm1ABRw1Gc2QRHqCIIW9Xgv5YCN2GbZw02iObaEEZPscTjcihml+4skAaYiJp9BHA2Bldn9h3HJ5xb9/RBph0uY3RlVoVRzvWZJceKUVLfE28ne+UftDn/yo6zm8qwCdp/l9UtXlsbuf0zm/RNqYvvgr3/AgMBAAECggEAQTTK31xvoECYYNvJiC2pvw0tfE9OOhpo9Ubh3rjjD/4wr4tX8ufiMTYNUhjfTb0aPgmlg7DmyBte9IkqbG8f7UmLeBEzj7tqrxAhYnrn74VsZVPBkkOzeFAahMPdUsc6Fqe94Pcbp4hltAkMcHGBReH5wVmNZ+LadkMmQc/BxIACD8qv7/Y6rIXL9bf3WII9kiBDjQImK8lxHB4NlTf8n950+dGAxcWqKyfRWlsei+np4AQkwclulncfkwF/+KFM881+ReJIurchlbybJmzyJJG9jYSCzS+bBv1W46Qqv2MY03+aXSGX1Sojr79q8Zl0MRntj26xy6MStNleqIQJEQKBgQDKS88u7liQ2xjVFyfG8g45E15Yjhxsvi5Mu4Hg5zhgmNfgXlS3eDoFjSNN734M0HjVcFAkBg09aigtmxp6pnZy8Cy98o/7fomV4ecqutpfPwnV0xNbl6ekRuZEKSqB8QeoQr22/tC3YhcgiYoio1i9zvNXpqLYsx7dQ+lgPhJD3QKBgQCm4RvPOc7apRt7TLxen3le/tWME/wImVuFyNpSm8r5X952mnFxil8fWsgvU0IrIk/H5R854qZ9aEjF6XEZzc1fLJve/XYYzqTTyhNHLRWli6OE04tU2ocgQbmI5YFrtRav3QHHJDWSUNrYLOOU51mzCY7HSC+jUn1C1cUCXMepiwKBgCE4NbuVNEIFWJyVgtiuoxtITPPp0k0hJeU/3WIbViy2rKyRkQPX4F9NAAEqVN6x1UXnfaGMxNvS9OoYUE7XyxewzQgcLvyzmNBeGmHv8TA239yXHtSpoMPfSKzkvbA87m75FsJYMdoLZ5TWQTLS9B2nQFqiaJeBQo4/OrGtP76ZAoGAZgYsHVYnS+8zTP+ODn+LEXPVFM3HAW7Y0IMKTwTmY+2jsXkcsCC7pQy4ZI6PXpWclwZSP+58gSE3lJ/ywKbczzoTlZH6GJKFnOHnRVWf7VTgxL0cauUrRaJJDxPZOwM8eoowoxJVGj4Kfa17+bYzVc0bGGTekwhEgo704kvc2Z8CgYBBlgRk66hbubJf6ulXGZFxdQ5rYQgUDUg8dee0cxb1c/+ZqzKcjvFjfeyZoveJWkAfpivRQU7aoIshmReDH+uvE5kiep5AXJDgR/tqeax6GxFkMdTooxVwzEOz0aSpluLgiMqMriEUvI8P/4iYVuTtURmjNqLe49L0iH19MObr5Q==',
        'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsKqHXgDvWywWdBdQbCYeRB81xrpgjXMI/69V44MDijViYdQ4tOOp7N6ZQ0PJm/54BYjbu1ICHUTYqA/dAZUbW/laxnollp5NhAxcEd0vHAZo2x2UXZwx6GtgB4/Pp/t/K7J/Wq3jwzmaK8X+XuHoKAMvRjYlmrfr755hRhWcC8Aws6JTmPKBZxKQSHUzbNNGJ7L/HZOw9aYAsfxkvxdb60qABf4zBmkhvHvwXQcpYbPAHpS5xYv40Yw8rqosIZfO5YTJ/l4q0BTPrIjmM6SqRpOSSNsS++loXFq9hPYbfWacZuSKbLS/HStZxE+3NDdneM0ngxcw161iVg2tGErASQIDAQAB',
        'notify_url' => env('APP_URL', '') . '/api/payment/ali-notify',
    ],
    'paypal' => [
        "client_id" => env('PAYMENT_PAYPAL_CLIENT_ID',''),
        'secret' => env('PAYMENT_PAYPAL_SECRET', ''),
        'gateway' => env('PAYMENT_PAYPAL_GATEWAY', 'https://api-m.paypal.com'),
        'hooks' => [
            'CHECKOUT.ORDER.COMPLETED' => env('PAYMENT_PAYPAL_HOOK_ORDER_COMPLETED')
        ],
    ],
];
